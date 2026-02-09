@extends('emails.layout')

@section('content')
<div class="email-header">
    <h1>{{ $isActive ? '✅ School Activated' : '⚠️ School Deactivated' }}</h1>
    <p>Your school status has been updated</p>
</div>

<div class="email-body">
    <h2>Hello {{ $adminName }},</h2>
    
    @if($isActive)
        <p>Great news! Your school <strong>{{ $schoolName }}</strong> has been activated.</p>
        
        <p>You can now access all platform features and manage your school operations.</p>
        
        <div style="text-align: center;">
            <a href="{{ $loginUrl }}" class="button">Access Your Dashboard</a>
        </div>
    @else
        <p>We're writing to inform you that your school <strong>{{ $schoolName }}</strong> has been deactivated.</p>
        
        <div class="info-box" style="border-left-color: #ef4444;">
            <h3 style="color: #dc2626;">⚠️ What This Means</h3>
            <p style="margin: 0;">Your school account is temporarily suspended. You will not be able to access the platform until your account is reactivated.</p>
        </div>
        
        @if($reason)
            <div class="info-box" style="border-left-color: #ef4444;">
                <h3 style="color: #dc2626;">Reason</h3>
                <p style="margin: 0;">{{ $reason }}</p>
            </div>
        @endif
        
        <p>If you believe this is a mistake or need assistance, please contact our support team immediately.</p>
    @endif

    <div class="divider"></div>

    <div class="info-box">
        <h3>📋 School Details</h3>
        <div class="info-row">
            <span class="info-label">School Name:</span>
            <span class="info-value">{{ $schoolName }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value">{{ $isActive ? 'Active' : 'Inactive' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Updated:</span>
            <span class="info-value">{{ now()->format('F d, Y h:i A') }}</span>
        </div>
    </div>

    <p>If you have any questions, please contact our support team.</p>
</div>

<div class="email-footer">
    <p><strong>School System</strong></p>
    <p>Transforming Education Through Technology</p>
    <p style="margin-top: 15px;">© {{ date('Y') }} School System. All rights reserved.</p>
</div>
@endsection
