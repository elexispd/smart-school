<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $schoolId;
    protected $schoolAcronym;
    protected $classId;
    protected $classArmId;

    public function __construct($schoolId, $schoolAcronym, $classId, $classArmId)
    {
        $this->schoolId = $schoolId;
        $this->schoolAcronym = $schoolAcronym;
        $this->classId = $classId;
        $this->classArmId = $classArmId;
    }

    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            $firstName = strtolower(explode(' ', $row['name'])[0]);
            $schoolAcronym = strtolower($this->schoolAcronym ?? 'school');
            
            // Generate unique email
            $email = $firstName . '@' . $schoolAcronym . '.com';
            $counter = 2;
            while (User::where('email', $email)->exists()) {
                $email = $firstName . $counter . '@' . $schoolAcronym . '.com';
                $counter++;
            }

            // Create user
            $user = User::create([
                'name' => $row['name'],
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'student',
                'school_id' => $this->schoolId,
            ]);

            // Create student profile
            $student = Student::create([
                'user_id' => $user->id,
                'school_id' => $this->schoolId,
                'admission_number' => $row['admission_number'],
                'current_class_id' => $this->classId,
                'class_arm_id' => $this->classArmId,
                'gender' => strtolower($row['gender']),
                'r_pin' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT),
                'status' => 'active',
            ]);

            // Log activity
            activity('school')
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties(['school_id' => $this->schoolId])
                ->tap(function ($activity) {
                    $activity->school_id = $this->schoolId;
                })
                ->log('Imported student: ' . $user->name);

            return $user;
        });
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'admission_number' => 'required|unique:students,admission_number',
            'gender' => 'required|in:male,female,Male,Female',
        ];
    }
}
