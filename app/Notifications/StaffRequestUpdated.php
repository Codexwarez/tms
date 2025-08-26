<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class StaffRequestUpdated extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(public $staffRequest) {}

    public function via($notifiable) { return ['database']; }

    public function toArray($notifiable) {
        return [
            'type' => 'request_update',
            'message' => 'Your ' . $this->staffRequest->type . ' request was ' . $this->staffRequest->status . '.',
            'project_id' => $this->staffRequest->project->id,
        ];
    }

    public function toBroadcast($notifiable){
        return new BroadcastMessage([
            'type' => 'request_update',
            'message' => 'Your ' . $this->staffRequest->type . ' request was ' . $this->staffRequest->status . '.',
            'project_id' => $this->staffRequest->project->id,
        ]);
    }
}