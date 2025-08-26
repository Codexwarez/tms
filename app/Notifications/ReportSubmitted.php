<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportSubmitted extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public function __construct(public $report) {}

    public function via($notifiable) { return ['database']; }

    public function toArray($notifiable) {
        return [
            'type' => 'report',
            'message' => $this->report->user->name . ' submitted a report for project "' . $this->report->project->name . '".',
            'project_id' => $this->report->project->id,
        ];
    }
    public function toBroadcast($notifiable){
        return new BroadcastMessage([
            'message' => $this->report->user->name . ' submitted a report for project "' . $this->report->project->name . '".',
            'project_id' => $this->report->project->id,
        ]);
    }
}