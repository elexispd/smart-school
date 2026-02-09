@extends('emails.layout')

@section('content')
<div class="email-header">
    <h1>{{ $status === 'approved' ? '✅' : '❌' }} Request Status Update</h1>
    <p>Your onboarding request has been {{ $status }}</p>
</div>

<div class="email-body">
    <h2>Hello {{ $adminName }},</h2>
    
    <p>We have reviewed your onboarding request for <strong>{{ $schoolName }}</strong>.</p>

    <div style="text-align: center; margin: 30px 0;">
        <span class="status-badge status-{{ $status }}">{{ strtoupper($status) }}</span>
    </div>

    @if($status === 'approved')
        <p>Congratulations! Your school has been approved and is now active on our platform.</p>
        
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

        <p><strong>What's Next?</strong></p>
        <ul style="color: #374151; line-height: 1.8;">
            <li>Log in to your admin dashboard</li>
            <li>Complete your school profile</li>
            <li>Add teachers and students</li>
            <li>Start managing your school digitally</li>
        </ul>
    @else
        <p>Unfortunately, your onboarding request has been rejected.</p>
        
        @if($rejectionReason)
            <div class="info-box" style="border-left-color: #ef4444;">
                <h3 style="color: #dc2626;">Reason for Rejection</h3>
                <p style="margin: 0;">{{ $rejectionReason }}</p>
            </div>
        @endif

        <p>If you believe this was a mistake or would like to reapply, please contact our support team for assistance.</p>
    @endif

    <p>If you have any questions, please don't hesitate to reach out to our support team.</p>
</div>

<div class="email-footer">
    <p><strong>School System</strong></p>
    <p>Transforming Education Through Technology</p>
    <p style="margin-top: 15px;">© {{ date('Y') }} School System. All rights reserved.</p>
</div>
@endsection
