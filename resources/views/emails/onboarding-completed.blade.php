@extends('emails.layout')

@section('content')
<div class="email-header">
    <h1>🎉 Welcome to School System!</h1>
    <p>Your school has been successfully onboarded</p>
</div>

<div class="email-body">
    <h2>Hello {{ $adminName }},</h2>
    
    <p>Great news! Your school <strong>{{ $schoolName }}</strong> has been successfully onboarded to our platform.</p>
    
    <div class="info-box">
        <h3>📋 School Details</h3>
        <div class="info-row">
            <span class="info-label">School Name:</span>
            <span class="info-value">{{ $schoolName }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $schoolEmail }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Location:</span>
            <span class="info-value">{{ $location }}</span>
        </div>
    </div>

    <div class="info-box">
        <h3>🔐 Your Admin Credentials</h3>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $adminEmail }}</span>
        </div>
        <p style="margin-top: 15px; color: #6b7280; font-size: 14px;">
            Use the password you provided during registration to log in.
        </p>
    </div>

    <div style="text-align: center;">
        <a href="{{ $loginUrl }}" class="button">Access Your Dashboard</a>
    </div>

    <div class="divider"></div>

    <p><strong>Next Steps:</strong></p>
    <ul style="color: #374151; line-height: 1.8;">
        <li>Log in to your admin dashboard</li>
        <li>Complete your school profile</li>
        <li>Add teachers and students</li>
        <li>Explore the platform features</li>
    </ul>

    <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
</div>

<div class="email-footer">
    <p><strong>School System</strong></p>
    <p>Transforming Education Through Technology</p>
    <p style="margin-top: 15px;">© {{ date('Y') }} School System. All rights reserved.</p>
</div>
@endsection
