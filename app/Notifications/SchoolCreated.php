<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchoolCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public School $school)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New School Registered')
            ->line("A new school '{$this->school->name}' has been registered.")
            ->line('School Details:')
            ->line("Email: {$this->school->email}")
            ->line("Phone: {$this->school->phone}")
            ->line("Location: {$this->school->city}, {$this->school->state}")
            ->action('View School', url('/super_admin/schools'));
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "New school '{$this->school->name}' has been registered",
            'school_id' => $this->school->id,
            'school_name' => $this->school->name,
        ];
    }
}
