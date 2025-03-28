<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkWeek extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'total_hours',
        'excess_hours_area_a',
        'excess_hours_area_b',
        'excess_hours_carried'
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function calculateHours()
    {
        $dailyLimits = [
            'monday' => 14,
            'tuesday' => 14,
            'wednesday' => 14,
            'thursday' => 14,
            'friday' => 14,
            'saturday' => 12,
            'sunday' => 0
        ];

        $excessHours = ['A' => 0, 'B' => 0];

        foreach ($this->tasks->groupBy('task_date') as $date => $tasks) {
            $dayName = strtolower($date->format('l'));
            $dayLimit = $dailyLimits[$dayName] ?? 0;
            $dayHours = $tasks->sum('estimated_hours');

            if ($dayHours > $dayLimit) {
                $excess = $dayHours - $dayLimit;
                // Distribuir el excedente proporcionalmente por áreas
                $areaHours = $tasks->groupBy('area')->map->sum('estimated_hours');
                $totalHours = $areaHours->sum();

                foreach ($areaHours as $area => $hours) {
                    $excessHours[$area] += $excess * ($hours / $totalHours);
                }
            }
        }

        $this->excess_hours_area_a = $excessHours['A'];
        $this->excess_hours_area_b = $excessHours['B'];
        $this->save();
    }

    // app/Models/WorkWeek.php

    public static function firstOrCreateForUser(User $user)
    {
        $today = now();
        $startOfWeek = $today->startOfWeek()->format('Y-m-d'); // Lunes
        $endOfWeek = $today->endOfWeek()->format('Y-m-d');     // Domingo

        return self::firstOrCreate(
            [
                'user_id' => $user->id,
                'start_date' => $startOfWeek,
                'end_date' => $endOfWeek,
            ],
            [
                'total_hours' => 0,
                'excess_hours_area_a' => 0,
                'excess_hours_area_b' => 0
            ]
        );
    }
}
