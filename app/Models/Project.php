<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'assigned_user_id',
        'status',
        'priority',
        'progress',
        'start_at',
        'due_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'due_at'   => 'datetime',
        'progress' => 'integer',
    ];

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function getStatusReadableAttribute()
    {
        switch ($this->status) {
            case 'in_progress':
                return 'In Progress';
            case 'incomplete':
                return 'Incomplete';
            case 'completed':
                return 'Completed';
            case 'cancelled':
                return 'Cancelled';
            default:
                return ucfirst($this->status);
        }
    }

    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            'High'   => 'bg-red-500 text-black',
            'Medium' => 'bg-yellow-500 text-black',
            'Low'    => 'bg-green-500 text-black',
            default  => 'bg-gray-300 text-black',
        };
    }

    public function getProgressPercentAttribute(): string
    {
        return $this->progress . '%';
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }
}