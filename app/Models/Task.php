<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'status',
        'completionDate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeFilterTitle($query, $title)
    {
        return $query->when($title, fn($q) => $q->where('title', 'like', "%{$title}%"));
    }

    public function scopeFilterStatus($query, $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }

    public function scopeCompletionBetween($query, $from, $to)
    {
        return $query->whereBetween('completionDate', [$from, $to]);
    }

}
