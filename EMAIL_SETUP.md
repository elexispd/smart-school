# Email Configuration Guide

## Quick Setup

### 1. Update .env file with your email settings:

#### For Gmail (recommended for testing):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="School System"
```

#### For Mailtrap (testing):
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="School System"
```

### 2. Set Queue Connection:
```env
QUEUE_CONNECTION=database
```

### 3. Test Email
Visit: `http://127.0.0.1:8000/test-email` (must be logged in)

### 4. Start Queue Worker
```bash
php artisan queue:work
```

## Email Notifications

The system sends emails for:
- New school registration (to super admins)
- School onboarding requests (to super admins)

All emails are queued for better performance.
