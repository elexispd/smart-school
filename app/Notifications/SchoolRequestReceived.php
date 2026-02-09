<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchoolRequestReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public School $school, public string $adminName, public string $adminEmail, public ?string $message)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New School Onboarding Request')
            ->line("A new onboarding request has been received from '{$this->school->name}'.")
            ->line('School Details:')
            ->line("School: {$this->school->name}")
            ->line("Admin: {$this->adminName} ({$this->adminEmail})")
            ->line("Email: {$this->school->email}")
            ->line("Phone: {$this->school->phone}")
            ->line("Location: {$this->school->city}, {$this->school->state}, {$this->school->country}")
            ->when($this->message, fn($mail) => $mail->line("Message: {$this->message}"))
            ->action('Review Request', url('/super_admin/schools'));
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "New onboarding request from '{$this->school->name}' by {$this->adminName}",
            'school_id' => $this->school->id,
            'school_name' => $this->school->name,
            'contact_person' => $this->adminName,
        ];
    }
}
