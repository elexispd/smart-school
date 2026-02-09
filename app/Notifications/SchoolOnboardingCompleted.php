<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchoolOnboardingCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public School $school, public string $adminName, public string $adminEmail)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to School System - Onboarding Complete')
            ->view('emails.onboarding-completed', [
                'schoolName' => $this->school->name,
                'schoolEmail' => $this->school->email,
                'location' => $this->school->city . ', ' . $this->school->state . ', ' . $this->school->country,
                'adminName' => $this->adminName,
                'adminEmail' => $this->adminEmail,
                'loginUrl' => url('/login'),
            ]);
    }
}
