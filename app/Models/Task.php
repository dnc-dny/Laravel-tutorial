<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'priority', 'status',
    ];

    // 優先順位を表現するための定数
    const PRIORITY_LOW = 0;    // ★
    const PRIORITY_MEDIUM = 1; // ★★
    const PRIORITY_HIGH = 2;   // ★★★

    // 優先順位を文字列で取得
    public function getPriorityLabelAttribute()
    {
        switch ($this->priority) {
            case self::PRIORITY_LOW:
                return '★';
            case self::PRIORITY_MEDIUM:
                return '★★';
            case self::PRIORITY_HIGH:
                return '★★★';
            default:
                return '★'; // デフォルトは最低優先度
        }
    }
}
