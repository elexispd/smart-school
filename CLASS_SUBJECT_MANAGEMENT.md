# Class and Subject Management System

## Overview
Multi-tenant class, class arm, and subject management system for schools. Only school admins can create/edit/delete, but all staff (school_admin and teacher) can view.

## Database Structure

### Tables Created
1. **classes** - Main class table (e.g., Grade 1, JSS 1, SS 2)
   - id (UUID)
   - school_id (UUID) - Multi-tenant scoping
   - name
   - description
   - is_active
   - timestamps

2. **class_arms** - Class sections/arms (e.g., A, B, Gold, Silver)
   - id (UUID)
   - school_id (UUID) - Multi-tenant scoping
   - class_id (UUID) - Foreign key to classes
   - name
   - capacity
   - is_active
   - timestamps

3. **subjects** - School subjects
   - id (UUID)
   - school_id (UUID) - Multi-tenant scoping
   - name
   - code
   - description
   - is_active
   - timestamps

## Models Created

1. **SchoolClass** (`app/Models/SchoolClass.php`)
   - Uses `HasUuid` and `BelongsToSchool` traits
   - Automatically scoped to authenticated user's school
   - Relationship: hasMany ClassArm

2. **ClassArm** (`app/Models/ClassArm.php`)
   - Uses `HasUuid` and `BelongsToSchool` traits
   - Automatically scoped to authenticated user's school
   - Relationship: belongsTo SchoolClass

3. **Subject** (`app/Models/Subject.php`)
   - Uses `HasUuid` and `BelongsToSchool` traits
   - Automatically scoped to authenticated user's school

## Livewire Components

1. **ManageClasses** (`app/Livewire/School/ManageClasses.php`)
   - View: All staff (school_admin, teacher)
   - Create/Edit/Delete: Only school_admin
   - Features: Search, pagination, status toggle

2. **ManageClassArms** (`app/Livewire/School/ManageClassArms.php`)
   - View: All staff (school_admin, teacher)
   - Create/Edit/Delete: Only school_admin
   - Features: Search, class filter, pagination, capacity management

3. **ManageSubjects** (`app/Livewire/School/ManageSubjects.php`)
   - View: All staff (school_admin, teacher)
   - Create/Edit/Delete: Only school_admin
   - Features: Search, subject code, pagination

## Routes

```php
// Accessible to school_admin and teacher
Route::get('school/classes', \App\Livewire\School\ManageClasses::class)->name('school.classes');
Route::get('school/class-arms', \App\Livewire\School\ManageClassArms::class)->name('school.class-arms');
Route::get('school/subjects', \App\Livewire\School\ManageSubjects::class)->name('school.subjects');
```

## Navigation
Added to main navigation menu for school_admin and teacher roles:
- Classes
- Class Arms
- Subjects

## Multi-Tenancy Implementation

All models use the `BelongsToSchool` trait which:
1. Automatically filters queries by authenticated user's school_id
2. Automatically sets school_id when creating records
3. Ensures data isolation between schools

## Security

- Only school_admin can create, edit, or delete records
- All staff (school_admin, teacher) can view records
- All queries are automatically scoped to the user's school
- Authorization checks in Livewire methods using `auth()->user()->role`

## Usage

1. Run migrations:
```bash
php artisan migrate
```

2. Access pages:
- `/school/classes` - Manage classes
- `/school/class-arms` - Manage class arms
- `/school/subjects` - Manage subjects

## Design Features

- Modern card-based UI for classes
- Table-based UI for class arms and subjects
- Modal dialogs for create/edit/delete operations
- Dark mode support
- Responsive design
- Search and filter functionality
- Status badges (Active/Inactive)
- Emerald color scheme matching project design
