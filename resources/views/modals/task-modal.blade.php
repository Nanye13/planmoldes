<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="taskForm" method="POST" action="{{ route('weekly-planner.tasks.store') }}">
                @csrf
                <input type="hidden" name="task_id" id="taskId">
                <input type="hidden" name="work_week_id" value="{{ $week->id ?? '' }}">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="taskModalLabel">Nueva Tarea</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Título de la tarea *</label>
                                <input type="text" class="form-control" id="title" name="title" required
                                       placeholder="Ej: Revisión de documentos del proyecto">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="task_date" class="font-weight-bold">Fecha *</label>
                                <input type="date" class="form-control" id="task_date" name="task_date" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_time" class="font-weight-bold">Hora de inicio *</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_time" class="font-weight-bold">Hora de fin *</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estimated_hours" class="font-weight-bold">Horas estimadas *</label>
                                <input type="number" step="0.5" class="form-control" id="estimated_hours" 
                                       name="estimated_hours" min="0.5" max="24" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="area" class="font-weight-bold">Área *</label>
                                <select class="form-control" id="area" name="area" required>
                                    <option value="A">{{ $userSettings->area_a_name ?? 'Área A' }}</option>
                                    <option value="B">{{ $userSettings->area_b_name ?? 'Área B' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="priority" class="font-weight-bold">Prioridad *</label>
                                <select class="form-control" id="priority" name="priority" required>
                                    <option value="1">🔥 Prioridad 1 (Urgente)</option>
                                    <option value="2">🔴 Prioridad 2 (Alta)</option>
                                    <option value="3" selected>🟡 Prioridad 3 (Media)</option>
                                    <option value="4">🔵 Prioridad 4 (Baja)</option>
                                    <option value="5">⚪ Prioridad 5 (Mínima)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="font-weight-bold">Notas adicionales</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                                  placeholder="Detalles importantes, enlaces, observaciones..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Tarea
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calcula horas automáticamente al cambiar tiempos
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const estimatedHours = document.getElementById('estimated_hours');
    
    function calculateHours() {
        if(startTime.value && endTime.value) {
            const start = new Date(`2000-01-01T${startTime.value}`);
            const end = new Date(`2000-01-01T${endTime.value}`);
            
            // Validar que la hora final sea posterior a la inicial
            if(end <= start) {
                estimatedHours.value = '';
                alert('La hora de fin debe ser posterior a la hora de inicio');
                return;
            }
            
            const diff = (end - start) / (1000 * 60 * 60); // Diferencia en horas
            estimatedHours.value = diff.toFixed(1);
        }
    }
    
    startTime.addEventListener('change', calculateHours);
    endTime.addEventListener('change', calculateHours);
    
    // Validar horas estimadas manuales
    estimatedHours.addEventListener('change', function() {
        if(this.value < 0.5) {
            this.value = 0.5;
        } else if(this.value > 24) {
            this.value = 24;
        }
    });
    
    // Manejar apertura del modal
    $('#taskModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const date = button.data('date');
        const modal = $(this);
        
        // Configurar para nueva tarea
        modal.find('.modal-title').text('Nueva Tarea');
        modal.find('#task_date').val(date);
        modal.find('#taskId').val('');
        modal.find('form')[0].reset();
        
        // Establecer hora por defecto (09:00 - 10:00)
        const now = new Date();
        const defaultStart = now.getHours() + ':00';
        const defaultEnd = (now.getHours() + 1) + ':00';
        
        modal.find('#start_time').val(defaultStart);
        modal.find('#end_time').val(defaultEnd);
    });
    
    // Manejar envío del formulario
    $('#taskForm').on('submit', function(e) {
        if(!validateTaskForm()) {
            e.preventDefault();
        }
    });
    
    function validateTaskForm() {
        // Validación adicional puede ir aquí
        return true;
    }

});
</script>
@endpush