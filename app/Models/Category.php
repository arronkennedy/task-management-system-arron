<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'description',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getTaskCountAttribute(): int
    {
        return $this->tasks()->count();
    }
}


