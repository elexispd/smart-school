# User Management System

## Overview
School admin interface for managing users (students and staff) with full CRUD operations, proper scoping, and role-based access control.

## Features Implemented

### 1. User Management Component
**File**: `app/Livewire/School/ManageUsers.php`

**Capabilities**:
- Create, Read, Update, Delete users (students and staff)
- Toggle user status (active/inactive)
- Grid and table view modes
- Search functionality (name and email)
- Filter by role (student/staff)
- Proper school scoping (users only see their school's data)
- Transaction-based saves for data integrity

**User Fields**:
- Basic: name, email, password, role
- Student-specific: admission_number, current_class_id, class_arm_id
- Staff-specific: staff_id
- Common profile fields: date_of_birth, gender, blood_group, address, guardian info, emergency contact, medical conditions, admission_date, status

### 2. User Interface
**File**: `resources/views/livewire/school/manage-users.blade.php`

**Views**:
- **Grid View**: Card-based layout showing user avatars, key info, and quick actions
- **Table View**: Compact tabular format for viewing many users at once

**Modals**:
- **Create/Edit Modal**: Comprehensive form with all user fields, dynamically shows student/staff specific fields based on role selection
- **Delete Confirmation Modal**: Safety confirmation before deletion

**Design Features**:
- Responsive design (mobile, tablet, desktop)
- Dark mode support
- Loading states on all actions
- Inline validation errors
- Status badges (active/inactive, student/staff)
- Avatar initials for users

### 3. Routing
**File**: `routes/web.php`

**Route Added**:
```php
Route::get('school/users', \App\Livewire\School\ManageUsers::class)
    ->name('school.users')
    ->middleware('role:school_admin');
```

**Access Control**:
- Only school_admin role can access
- Protected by auth, verified, and school.status middleware
- Properly scoped to school context

### 4. Navigation
**File**: `resources/views/livewire/layout/navigation.blade.php`

**Navigation Links Added**:
- Desktop navigation: "Users" link (visible only to school_admin)
- Mobile navigation: "Users" link (visible only to school_admin)
- Positioned before Classes, Class Arms, and Subjects

## Data Flow

### Creating a User
1. School admin clicks "Add User"
2. Fills in basic info (name, email, password, role)
3. Selects role (student or staff)
4. Form dynamically shows role-specific fields
5. Fills in additional profile information
6. On save:
   - Creates user record in `users` table
   - Creates corresponding record in `students` or `staff` table
   - All within a database transaction
   - Properly scoped to current school

### Editing a User
1. School admin clicks edit button
2. Modal loads with existing user data
3. Can change role (will delete old profile and create new one)
4. Can update password (optional)
5. On save:
   - Updates user record
   - Updates or creates profile record
   - Maintains data integrity

### Deleting a User
1. School admin clicks delete button
2. Confirmation modal appears
3. On confirm:
   - Deletes user record
   - Cascades to delete student/staff record (via foreign key)

### Toggle Status
1. School admin clicks activate/deactivate
2. Updates status in student/staff table
3. Immediate visual feedback

## Security & Scoping

### Role-Based Access
- Only `school_admin` can access user management
- Enforced at route level and component level
- All actions check role before execution

### School Scoping
- All queries automatically scoped to current school via global scope on User model
- New users automatically assigned to admin's school
- Cannot view or modify users from other schools

### Data Validation
- Required fields enforced
- Email uniqueness checked
- Admission number unique per school
- Staff ID unique per school
- Password minimum 8 characters
- Role restricted to student/staff

## Database Relationships

### Users Table
- `id` (UUID, primary key)
- `name`, `email`, `password`
- `school_id` (foreign key to schools)
- `role` (student, staff, school_admin, etc.)

### Students Table
- `id` (UUID, primary key)
- `user_id` (foreign key to users, cascade delete)
- `school_id` (foreign key to schools)
- `admission_number` (unique per school)
- `current_class_id`, `class_arm_id`
- Profile fields (DOB, gender, address, guardian info, etc.)
- `status` (active/inactive)

### Staff Table
- `id` (UUID, primary key)
- `user_id` (foreign key to users, cascade delete)
- `school_id` (foreign key to schools)
- `staff_id` (unique per school)
- Profile fields (DOB, gender, address, next of kin info, etc.)
- `status` (active/inactive)

## Usage

### Access the Feature
1. Login as school_admin
2. Click "Users" in navigation
3. View all students and staff in your school

### Add a Student
1. Click "Add User"
2. Enter name, email, password
3. Select "Student" role
4. Enter admission number (required)
5. Optionally select class and class arm
6. Fill in additional details
7. Click "Save"

### Add a Staff Member
1. Click "Add User"
2. Enter name, email, password
3. Select "Staff" role
4. Optionally enter staff ID
5. Fill in additional details
6. Click "Save"

### Search and Filter
- Use search box to find by name or email
- Use role filter to show only students or staff
- Switch between grid and table views

### Manage Users
- Click edit icon to modify user details
- Click activate/deactivate to change status
- Click delete icon to remove user (with confirmation)

## Design Consistency
- Follows same design pattern as ManageClasses, ManageSubjects
- Uses Tailwind CSS with dark mode support
- Consistent button styles, modals, and loading states
- Mobile-responsive throughout
- Accessible with proper ARIA labels and keyboard navigation
