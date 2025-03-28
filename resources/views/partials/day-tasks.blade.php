<div class="day-tasks-container">
    <!-- Encabezado del día -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>{{ $day['name'] }} - {{ \Carbon\Carbon::parse($day['date'])->format('d/m/Y') }}</h5>
        <span class="badge {{ $day['hours'] > $day['limit'] ? 'badge-danger' : 'badge-success' }}">
            {{ $day['hours'] }}/{{ $day['limit'] }} horas
        </span>
    </div>

    <!-- Alertas de exceso de horas -->
    @if($day['hours'] > $day['limit'])
        <div class="alert alert-warning py-2">
            <i class="fas fa-exclamation-triangle"></i> Excediste el límite por {{ $day['hours'] - $day['limit'] }} horas
        </div>
    @endif

    <!-- Lista de tareas -->
    <div class="list-group">
        @forelse($day['tasks'] as $task)
            <div class="list-group-item task-item {{ $task->completed ? 'completed' : '' }}"
                 data-task-id="{{ $task->id }}">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">
                            {{ $task->title }}
                            <span class="badge badge-{{ $task->area == 'A' ? 'primary' : 'info' }}">
                                {{ $task->area == 'A' ? $userSettings->area_a_name : $userSettings->area_b_name }}
                            </span>
                        </h6>
                        <small class="text-muted">
                            {{ $task->start_time }} - {{ $task->end_time }} 
                            (Prioridad: {{ $task->priority }})
                        </small>
                    </div>
                    <div>
                        <span class="hours-badge">{{ $task->estimated_hours }}h</span>
                    </div>
                </div>
                @if($task->notes)
                    <p class="mb-0 mt-2 small">{{ $task->notes }}</p>
                @endif
                <div class="task-actions mt-2">
                    <button class="btn btn-sm btn-outline-secondary toggle-complete"
                            data-task-id="{{ $task->id }}">
                        {{ $task->completed ? 'Marcar como pendiente' : 'Completar' }}
                    </button>
                </div>
            </div>
        @empty
            <div class="list-group-item text-center text-muted">
                No hay tareas programadas para este día
            </div>
        @endforelse
    </div>

    <!-- Botón para agregar nueva tarea -->
    <div class="mt-3">
        <button class="btn btn-sm btn-primary w-100 add-task-btn"
                data-date="{{ $day['date'] }}"
                data-toggle="modal"
                data-target="#taskModal">
            <i class="fas fa-plus"></i> Agregar Tarea
        </button>
    </div>
</div>

<style>
    .task-item.completed {
        background-color: #f8f9fa;
        opacity: 0.7;
    }
    .task-item.completed h6 {
        text-decoration: line-through;
    }
    .hours-badge {
        background: #e9ecef;
        padding: 3px 8px;
        border-radius: 10px;
        font-weight: bold;
    }
</style>