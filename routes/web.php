<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SchoolCreated;
use App\Models\School;


Route::view('/', 'welcome');

Route::get('/request-onboarding', \App\Livewire\PublicSchoolRequest::class)->name('school.request');

// Test Email Route
Route::get('/test-email', function () {
    $user = auth()->user();
    if (!$user) {
        return 'Please login first';
    }

    try {
        $testEmail = 'promisedeco24@gmail.com';
        
        Mail::raw('This is a test email from School System. If you receive this, your email configuration is working correctly!', function ($message) use ($testEmail) {
            $message->to($testEmail)
                    ->subject('Test Email - School System');
        });

        return '<h2>Test email sent successfully!</h2>' .
               '<p><strong>To:</strong> ' . $testEmail . '</p>' .
               '<p><strong>From:</strong> ' . config('mail.from.address') . '</p>' .
               '<p><strong>Mail Driver:</strong> ' . config('mail.default') . '</p>' .
               '<p><strong>Host:</strong> ' . config('mail.mailers.smtp.host') . '</p>' .
               '<p>Check your inbox and spam folder!</p>' .
               '<p><a href="/dashboard">Back to Dashboard</a></p>';
    } catch (\Exception $e) {
        return '<h2>Error sending email</h2>' .
               '<p style="color: red;">' . $e->getMessage() . '</p>' .
               '<p><a href="/dashboard">Back to Dashboard</a></p>';
    }
})->middleware('auth')->name('test.email');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('super_admin')) return redirect()->route('super_admin.dashboard');
    if ($user->hasRole('school_admin')) return redirect()->route('admin.dashboard');
    if ($user->hasRole('teacher')) return redirect()->route('staff.dashboard');
    if ($user->hasRole('student')) return redirect()->route('student.dashboard');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'school.status'])->group(function () {
    Route::view('admin/dashboard', 'livewire.school.admin.dashboard')->name('admin.dashboard')->middleware('role:school_admin');
    Route::view('staff/dashboard', 'livewire.school.staff.dashboard')->name('staff.dashboard')->middleware('role:teacher');
    Route::view('student/dashboard', 'livewire.school.student.dashboard')->name('student.dashboard')->middleware('role:student');
    
    // User Management - School Admin only
    Route::get('school/users', \App\Livewire\School\ManageUsers::class)->name('school.users')->middleware('role:school_admin');
    
    // Session Management - School Admin only
    Route::get('school/sessions', \App\Livewire\School\ManageSessions::class)->name('school.sessions')->middleware('role:school_admin');
    
    // Academic Management - Accessible to school_admin and teacher
    Route::get('school/classes', \App\Livewire\School\ManageClasses::class)->name('school.classes');
    Route::get('school/classes/{classId}/subjects', \App\Livewire\School\ManageClassSubjects::class)->name('school.class-subjects');
    Route::get('school/class-arms', \App\Livewire\School\ManageClassArms::class)->name('school.class-arms');
    Route::get('school/class-arms/{classArmId}/subjects', \App\Livewire\School\ManageClassArmSubjects::class)->name('school.class-arm-subjects');
    Route::get('school/subjects', \App\Livewire\School\ManageSubjects::class)->name('school.subjects');
    Route::get('school/staff-assignments', \App\Livewire\School\ManageStaffAssignments::class)->name('school.staff-assignments')->middleware('role:school_admin');
    
    // Fee Management - School Admin only
    Route::get('school/fee-categories', \App\Livewire\School\ManageFeeCategories::class)->name('fee-categories.index')->middleware('role:school_admin');
    Route::get('school/fee-structures', \App\Livewire\School\ManageFeeStructures::class)->name('fee-structures.index')->middleware('role:school_admin');
    Route::get('school/student-payments', \App\Livewire\School\ManageStudentPayments::class)->name('student-payments.index')->middleware('role:school_admin');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
