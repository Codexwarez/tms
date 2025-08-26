<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class StaffRequestSubmitted extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(public $staffRequest) {}

    public function via($notifiable) { return ['database']; }

    public function toArray($notifiable) {
        return [
            'type' => 'request',
            'message' => $this->staffRequest->user->name . ' submitted a ' . $this->staffRequest->type . ' request for project "' . $this->staffRequest->project->name . '".',
            'project_id' => $this->staffRequest->project->id,
        ];
    }

    public function toBroadcast($notifiable){
        return new BroadcastMessage([
            'message' => $this->staffRequest->user->name . ' submitted a ' . $this->staffRequest->type . ' request for project "' . $this->staffRequest->project->name . '".',
            'project_id' => $this->staffRequest->project->id,
        ]);
    }
}