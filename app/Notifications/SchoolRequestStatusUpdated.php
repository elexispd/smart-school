<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchoolRequestStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public School $school,
        public string $status,
        public string $adminName,
        public string $adminEmail,
        public ?string $rejectionReason = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('School Onboarding Request ' . ucfirst($this->status))
            ->view('emails.request-status-updated', [
                'schoolName' => $this->school->name,
                'schoolEmail' => $this->school->email,
                'location' => $this->school->city . ', ' . $this->school->state . ', ' . $this->school->country,
                'status' => $this->status,
                'adminName' => $this->adminName,
                'adminEmail' => $this->adminEmail,
                'rejectionReason' => $this->rejectionReason,
                'loginUrl' => url('/login'),
            ]);
    }
}
