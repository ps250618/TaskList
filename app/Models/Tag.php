<?php

namespace App\Models;

use App\Policies\TagPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(TagPolicy::class)]
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'tag_tasks')
            ->withPivot(['added_by, added_at']);
    }
}
