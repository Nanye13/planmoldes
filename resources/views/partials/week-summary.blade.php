<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Resumen Semanal
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{ $userSettings->area_a_name }}</h5>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-success" style="width: {{ $week->area_a_percentage }}%">
                                {{ $week->area_a_hours }}h
                            </div>
                        </div>
                        @if($week->excess_hours_area_a > 0)
                        <div class="text-danger">
                            <i class="fas fa-exclamation-triangle"></i> Excedente: {{ $week->excess_hours_area_a }}h
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h5>{{ $userSettings->area_b_name }}</h5>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-info" style="width: {{ $week->area_b_percentage }}%">
                                {{ $week->area_b_hours }}h
                            </div>
                        </div>
                        @if($week->excess_hours_area_b > 0)
                        <div class="text-danger">
                            <i class="fas fa-exclamation-triangle"></i> Excedente: {{ $week->excess_hours_area_b }}h
                        </div>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>Total:</strong> {{ $week->total_hours }} horas
                    </div>
                    @if($week->total_excess_hours > 0)
                    <div class="text-danger">
                        <strong>Horas excedentes:</strong> {{ $week->total_excess_hours }}h
                        @if($userSettings->carry_over_hours)
                        <span class="badge badge-secondary">Pasarán a próxima semana</span>
                        @else
                        <span class="badge badge-warning">Horas extras</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Distribución por Prioridad
            </div>
            <div class="card-body">
                <canvas id="priorityChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>