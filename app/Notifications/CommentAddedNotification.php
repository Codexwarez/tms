<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CommentAddedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Comment Added')
            ->line($this->comment->user->name . ' added a comment: ' . $this->comment->body)
            ->action('View Project', route('projects.show', $this->comment->project_id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->comment->user->name . ' commented: ' . $this->comment->body,
            'project_id' => $this->comment->project_id,
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->comment->user->name . ' commented: ' . $this->comment->body,
            'project_id' => $this->comment->project_id,
        ]);
    }
}