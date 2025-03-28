<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\WorkWeek;
use Illuminate\Http\Request;

class WeeklyPlannerController extends Controller
{
    //
    public function show(Request $request)
    {
        $user = auth()->user();
        $userSettings = $user->settings;
        
        // return $userSettings;
        // Obtener semana actual o crear una nueva
        $currentWeek = WorkWeek::firstOrCreateForUser($user);

        
        // Calcular límites diarios
        $weekDays = $this->prepareWeekDays($currentWeek);
        // return $weekDays;

        
        return view('partials.weekly-planner', [
            'week' => $currentWeek,
            'weekDays' => $weekDays,
            'userSettings' => $userSettings
        ]);
    }
    
    protected function prepareWeekDays(WorkWeek $week)
    {
        $days = [];
        $currentDate = $week->start_date->copy(); // Usa copy() en lugar de clone
    
        while ($currentDate <= $week->end_date) {
            $dayName = strtolower($currentDate->format('l'));
            $isWeekend = in_array($dayName, ['saturday', 'sunday']);
            
            $days[] = [
                'date' => $currentDate->toDateString(), // Guarda como string
                'name' => trans("days.$dayName"),
                'tasks' => $week->tasks()->whereDate('task_date', $currentDate)->orderBy('priority')->get(),
                'limit' => $dayName === 'saturday' ? 12 : ($isWeekend ? 0 : 14),
                'hours' => $week->tasks()->whereDate('task_date', $currentDate)->sum('estimated_hours')
            ];
            
            $currentDate->addDay(); // Avanza al siguiente día
        }
        
        return $days;
    }
    
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'carry_over_hours' => 'boolean',
            'area_a_name' => 'required|string|max:50',
            'area_b_name' => 'required|string|max:50'
        ]);
        
        auth()->user()->settings()->update($validated);
        
        return back()->with('success', 'Configuración actualizada');
    }
    
    public function storeTask(Request $request)
    {
        // Validación y creación de tarea

        $validated = $request->validate([
            'work_week_id' => 'required|exists:work_weeks,id',
            'title' => 'required|string|max:255',
            'area' => 'required|in:A,B',
            'priority' => 'required|integer|between:1,5',
            'task_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'estimated_hours' => 'required|numeric|min:0.5|max:24',
            'notes' => 'nullable|string'
        ]);

        Task::create($validated);

        return redirect()->route('weekly-planner')->with('success', 'Tarea agregada correctamente');
    }
}
