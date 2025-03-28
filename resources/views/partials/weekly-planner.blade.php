@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-3">Planeador Semanal</h2>
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span style="color: black">
                        Semana del {{ \Carbon\Carbon::parse($week->start_date)->format('d M') }} al 
                        {{ \Carbon\Carbon::parse($week->end_date)->format('d M Y') }}
                    </span>
                    <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#settingsModal" style="color: black">
                        <i class="fas fa-cog"></i> Configuración
                    </button>
                </div>
                
                <div class="card-body" style="color: black">
                    @include('partials.week-summary')
                    
                    <ul class="nav nav-tabs" id="weekDaysTab" role="tablist">
                        @foreach($weekDays as $day)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                               id="{{ $day['name'] }}-tab" 
                               data-toggle="tab" 
                               href="#day-{{ $loop->index }}">
                                {{ $day['name'] }} 
                                <span class="badge {{ $day['hours'] > $day['limit'] ? 'badge-danger' : 'badge-success' }}">
                                    {{ $day['hours'] }}/{{ $day['limit'] }}h
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="tab-content p-3 border border-top-0 rounded-bottom" id="weekDaysContent">
                        @foreach($weekDays as $day)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                             id="day-{{ $loop->index }}" 
                             role="tabpanel">
                            @include('partials.day-tasks', ['day' => $day])
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.task-modal')
@include('modals.settings-modal')
@endsection

@section('scripts')

@endsection