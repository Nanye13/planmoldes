<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['work_week_id', 'title', 'area', 'priority', 'task_date',
                         'start_time', 'end_time', 'estimated_hours', 'actual_hours', 'notes', 'completed'];
    
    public function workWeek()
    {
        return $this->belongsTo(WorkWeek::class);
    }
}
