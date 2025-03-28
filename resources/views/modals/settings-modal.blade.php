<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('weekly-planner.settings') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="settingsModalLabel">Configuración del Planeador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre para Área A</label>
                        <input type="text" name="area_a_name" class="form-control" 
                               value="{{ $userSettings->area_a_name ?? 'Área A' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre para Área B</label>
                        <input type="text" name="area_b_name" class="form-control" 
                               value="{{ $userSettings->area_b_name ?? 'Área B' }}" required>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="carry_over_hours" id="carry_over_hours" 
                               class="form-check-input" {{ $userSettings->carry_over_hours ? 'checked' : '' }}>
                        <label class="form-check-label" for="carry_over_hours">
                            Pasar horas excedentes a la siguiente semana
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                </div>
            </form>
        </div>
    </div>
</div>