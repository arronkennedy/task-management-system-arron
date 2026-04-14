<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'category_id',
        'due_date',
        'completed_at',
    ];

    protected $casts = [
        'due_date'     => 'date',
        'completed_at' => 'datetime',
    ];

    // ──────────── Relationships ────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // ──────────── Business Logic ────────────

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isOverdue(): bool
    {
        if (!$this->due_date || $this->isCompleted() || $this->isCancelled()) {
            return false;
        }
        return $this->due_date->isPast();
    }

    public function markAsCompleted(): bool
    {
        return $this->update([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function getPriorityLevelAttribute(): int
    {
        return match ($this->priority) {
            'low'      => 1,
            'medium'   => 2,
            'high'     => 3,
            'critical' => 4,
            default    => 0,
        };
    }

    // ──────────── Scopes ────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotIn('status', ['completed', 'cancelled'])
                     ->whereNotNull('due_date')
                     ->where('due_date', '<', now()->toDateString());
    }
}
