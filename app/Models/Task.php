<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'priority', 'status', 'user_id'
    ];

    /**
     * リレーション: タスクを担当するユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
