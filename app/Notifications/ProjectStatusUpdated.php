<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectStatusUpdated extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(public $project, public $byUser) {}

    public function via($notifiable) { return ['database']; }

    public function toArray($notifiable) {
        return [
            'type' => 'status_update',
            'message' => $this->byUser->name . ' updated project "' . $this->project->name . '" status to ' . $this->project->status . '.',
            'project_id' => $this->project->id,
        ];
    }

    public function toBroadcast($notifiable){
        return new BroadcastMessage ([
            'message' => $this->byUser->name . ' updated project "' . $this->project->name . '" status to ' . $this->project->status . '.',
            'project_id' => $this->project->id,
        ]);
    }
}