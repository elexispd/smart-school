<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users List</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #10b981; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .header { text-align: center; margin-bottom: 30px; }
        .date { text-align: right; margin-bottom: 10px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="date">Generated: {{ date('F d, Y h:i A') }}</div>
    <div class="header">
        <h1>{{ auth()->user()->school->name }}</h1>
        <p>Users List</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>ID Number</th>
                <th>Class</th>
                <th>Class Arm</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->student?->admission_number ?? ($user->staff?->staff_id ?? 'N/A') }}</td>
                <td>{{ $user->student?->currentClass?->name ?? 'N/A' }}</td>
                <td>{{ $user->student?->classArm?->name ?? 'N/A' }}</td>
                <td>{{ $user->student?->status ?? ($user->staff?->status ?? 'N/A') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p style="margin-top: 30px; font-size: 10px; color: #666;">Total Users: {{ count($users) }}</p>
</body>
</html>
