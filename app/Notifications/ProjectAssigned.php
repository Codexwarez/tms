<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProjectAssigned extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(public $project) {}

    public function via($notifiable) { return ['database']; }

    public function toArray($notifiable) {
        return [
            'type' => 'assignment',
            'message' => 'New project "' . $this->project->name . '" assigned to you.',
            'project_id' => $this->project->id,
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'New project "' . $this->project->name . '" assigned to you.',
            'project_id' => $this->project->id,
        ]);
    }
}