<?php

namespace App\Notifications;

use App\Models\ProjectFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FileUploadedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public $file;

    public function __construct(ProjectFile $file)
    {
        $this->file = $file;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // choose channels
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New File Uploaded')
            ->line($this->file->user->name . ' uploaded a new file: ' . $this->file->file_name)
            ->action('View Project', route('projects.show', $this->file->project_id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->file->user->name . ' uploaded file: ' . $this->file->file_name,
            'project_id' => $this->file->project_id,
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->file->user->name . ' uploaded file: ' . $this->file->file_name,
            'project_id' => $this->file->project_id,
        ]);
    }
}