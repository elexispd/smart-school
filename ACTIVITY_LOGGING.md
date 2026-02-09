# Activity Logging System

## Overview
The system now has two separate activity log types:
1. **SAAS Activity Logs** - System-wide activities (schools, super admin actions)
2. **School Activity Logs** - School-specific activities (users, students, staff within a school)

## Features

### Detailed Change Tracking
- Shows exactly what changed (old value → new value)
- Displays field names in human-readable format
- Color-coded changes (red for old, green for new)
- Timestamps with full date and time

### Separation of Concerns
- **SAAS Logs**: For super admins to track all schools and system-wide changes
- **School Logs**: For school admins to track only their school's activities

### Automatic Logging
Models automatically log when:
- Created
- Updated (only dirty/changed fields)
- Deleted

## Routes

### Super Admin
- `/super-admin/activity-logs` - View SAAS activity logs

### School Admin
- `/admin/activity-logs` - View school-specific activity logs

## Models with Activity Logging

### User Model
Logs: name, email, role, school_id
- Automatically categorized as 'school' or 'saas' based on school_id
- Shows detailed changes when user is updated

### School Model
Logs: name, email, phone, address, is_active, subscription_plan
- Always categorized as 'saas'
- Tracks all school management activities

## Adding Activity Logging to New Models

```php
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class YourModel extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['field1', 'field2'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('school') // or 'saas'
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Record was created",
                'updated' => "Record was updated",
                'deleted' => "Record was deleted",
                default => "{$eventName} on record"
            });
    }

    protected static function bootLogsActivity()
    {
        static::updated(function ($model) {
            if ($model->isDirty()) {
                activity('school') // or 'saas'
                    ->performedOn($model)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'attributes' => $model->getChanges(),
                        'old' => array_intersect_key($model->getOriginal(), $model->getChanges()),
                        'school_id' => $model->school_id ?? null
                    ])
                    ->tap(function ($activity) use ($model) {
                        $activity->school_id = $model->school_id ?? null;
                    })
                    ->log("Your custom message");
            }
        });
    }
}
```

## Database Structure

### activity_log table
- `id` - Primary key
- `log_name` - 'saas' or 'school'
- `description` - Human-readable description
- `subject_type` - Model class name
- `subject_id` - Model ID
- `causer_type` - User model
- `causer_id` - User ID who performed the action
- `school_id` - School ID for filtering (nullable)
- `properties` - JSON with 'attributes' and 'old' values
- `created_at` - Timestamp

## UI Components

### Livewire Components
- `SaasActivityLogs` - SAAS logs component
- `SchoolActivityLogs` - School logs component

### Features
- Search functionality
- Pagination (20 per page)
- Real-time updates
- Dark mode support
- Responsive design
- Detailed change display with visual indicators

## Example Log Entry

```
User 'John Doe' was updated

By: Super Admin
Feb 08, 2026 5:30 PM

Changes Made:
Name: John → John Doe
Email: john@old.com → john@new.com
Role: staff → admin
```
