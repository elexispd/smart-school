<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchoolStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public School $school,
        public bool $isActive,
        public string $adminName,
        public string $adminEmail,
        public ?string $reason = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('School Status Updated - ' . ($this->isActive ? 'Activated' : 'Deactivated'))
            ->view('emails.school-status-changed', [
                'schoolName' => $this->school->name,
                'isActive' => $this->isActive,
                'adminName' => $this->adminName,
                'adminEmail' => $this->adminEmail,
                'reason' => $this->reason,
                'loginUrl' => url('/login'),
            ]);
    }
}
