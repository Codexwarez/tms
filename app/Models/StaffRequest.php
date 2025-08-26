<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'user_id', 'type', 'reason', 'proposed_due_at', 'status', 'admin_response'
    ];

    protected $casts = [
        'proposed_due_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
