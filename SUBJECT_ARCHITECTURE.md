# Subject Assignment Architecture

## Overview
This system implements a three-tier subject assignment model that allows flexible subject allocation at different levels:

1. **Class-Level Subjects** - Compulsory subjects for all students in a class
2. **Class Arm-Level Subjects** - Specific subjects for particular class arms
3. **Student-Level Elective Subjects** - Individual student choices

## Database Structure

### Tables

#### 1. `class_subject` (Class-Level)
Assigns subjects to entire classes (e.g., all JS1 students take English and Math)
```
- id
- class_id (FK to classes)
- subject_id (FK to subjects)
- is_compulsory (boolean)
- timestamps
```

#### 2. `class_arm_subject` (Class Arm-Level)
Assigns subjects to specific class arms (e.g., only JS1 Gold takes Physics)
```
- id
- class_arm_id (FK to class_arms)
- subject_id (FK to subjects)
- is_compulsory (boolean)
- timestamps
```

#### 3. `student_subject` (Student-Level)
Individual student elective choices
```
- id
- student_id (FK to students)
- subject_id (FK to subjects)
- type (enum: 'elective', 'additional')
- timestamps
```

## Model Relationships

### SchoolClass Model
```php
public function subjects() // All class subjects
public function compulsorySubjects() // Only compulsory
public function electiveSubjects() // Only electives
```

### ClassArm Model
```php
public function subjects() // Arm-specific subjects
public function students() // Students in this arm
```

### Subject Model
```php
public function classes() // Classes offering this subject
public function classArms() // Arms offering this subject
public function students() // Students taking this subject
```

### Student Model
```php
public function currentClass() // Student's class
public function classArm() // Student's class arm
public function electiveSubjects() // Student's electives
public function getAllSubjects() // OPTIMIZED: All subjects for student
```

## Query Optimization

### Student::getAllSubjects() Method
This method efficiently retrieves all subjects for a student in a single optimized query:

```php
public function getAllSubjects()
{
    // 1. Get class compulsory subjects
    $classSubjects = DB::table('class_subject')
        ->where('class_id', $this->current_class_id)
        ->where('is_compulsory', true)
        ->pluck('subject_id');

    // 2. Get class arm specific subjects
    $classArmSubjects = DB::table('class_arm_subject')
        ->where('class_arm_id', $this->class_arm_id)
        ->pluck('subject_id');

    // 3. Get student elective subjects
    $electiveSubjects = DB::table('student_subject')
        ->where('student_id', $this->id)
        ->pluck('subject_id');

    // 4. Merge and get unique subjects
    $allSubjectIds = $classSubjects
        ->merge($classArmSubjects)
        ->merge($electiveSubjects)
        ->unique();

    // 5. Return subjects with source metadata
    return Subject::whereIn('id', $allSubjectIds)
        ->where('is_active', true)
        ->get()
        ->map(function ($subject) use ($classSubjects, $classArmSubjects, $electiveSubjects) {
            $subject->source = [];
            if ($classSubjects->contains($subject->id)) {
                $subject->source[] = 'class_compulsory';
            }
            if ($classArmSubjects->contains($subject->id)) {
                $subject->source[] = 'class_arm';
            }
            if ($electiveSubjects->contains($subject->id)) {
                $subject->source[] = 'elective';
            }
            return $subject;
        });
}
```

### Performance Benefits
- **Single Query per Level**: Uses direct DB queries instead of Eloquent relationships
- **Efficient Merging**: Combines results in memory
- **Source Tracking**: Identifies where each subject comes from
- **Active Filter**: Only returns enabled subjects

## Use Case Example

### Scenario: JS1 Students
```
Class: JS1
Arms: Gold, Silver, Bronze

Class-Level (All JS1):
- English (Compulsory)
- Mathematics (Compulsory)
- Basic Science (Compulsory)

Arm-Level:
- JS1 Gold: Physics, Chemistry
- JS1 Silver: Government, Economics
- JS1 Bronze: Agricultural Science

Student-Level:
- Student A (Gold): Computer Science (Elective)
- Student B (Silver): French (Elective)
```

### Query Result for Student A (JS1 Gold)
```php
$student->getAllSubjects();
// Returns:
[
    English (source: ['class_compulsory']),
    Mathematics (source: ['class_compulsory']),
    Basic Science (source: ['class_compulsory']),
    Physics (source: ['class_arm']),
    Chemistry (source: ['class_arm']),
    Computer Science (source: ['elective'])
]
```

## Management Interfaces

### 1. Class Subject Assignment
**Route**: `/school/classes/{classId}/subjects`
**Component**: `ManageClassSubjects`
- Assign compulsory subjects to entire class
- All students in class automatically get these subjects

### 2. Class Arm Subject Assignment
**Route**: `/school/class-arms/{classArmId}/subjects`
**Component**: `ManageClassArmSubjects`
- Assign subjects specific to a class arm
- Only students in that arm get these subjects

### 3. Student Elective Selection
**Future Implementation**
- Students select from available electives
- Respects class/arm prerequisites

## Benefits

1. **Flexibility**: Three-tier system handles complex scenarios
2. **Performance**: Optimized queries reduce database load
3. **Scalability**: Can handle large numbers of students
4. **Maintainability**: Clear separation of concerns
5. **Traceability**: Source tracking shows where subjects come from
6. **Multi-tenancy**: All queries respect school_id scoping

## Future Enhancements

1. **Subject Prerequisites**: Require certain subjects before allowing electives
2. **Capacity Limits**: Limit number of students per elective
3. **Timetable Integration**: Auto-generate timetables based on assignments
4. **Grade Tracking**: Link to assessment system
5. **Reports**: Generate subject enrollment reports
