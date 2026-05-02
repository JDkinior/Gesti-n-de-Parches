@extends('layouts.bootstrap', ['title' => 'Detalle del Sistema'])

@section('content')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <a href="{{ route('systems.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <h1 class="h2 fw-800 mb-1">
                <i class="fas fa-cube text-primary"></i> {{ $system->name }}
            </h1>
            <p class="text-muted">Detalles y estado actual del sistema</p>
        </div>
        <div class="d-flex gap-2">
            @can('update', $system)
                <a href="{{ route('systems.edit', $system) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
            @endcan
            @can('delete', $system)
                <form action="{{ route('systems.destroy', $system) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Confirma que desea eliminar este sistema? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card card-soft">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-info"></i> Información General</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <h6 class="text-muted mb-2"><i class="fas fa-user-circle"></i> Responsable</h6>
                            <p class="fs-5 fw-600">{{ $system->owner ?: 'Sin asignar' }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="text-muted mb-2"><i class="fas fa-user"></i> Creado Por</h6>
                            <p class="fs-5 fw-600">{{ $system->creator?->name }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="text-muted mb-2"><i class="fas fa-calendar-alt"></i> Fecha de Creación</h6>
                            <p class="fs-5 fw-600">{{ $system->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="text-muted mb-2"><i class="fas fa-sync-alt"></i> Última Actualización</h6>
                            <p class="fs-5 fw-600">{{ $system->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-soft">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-danger"></i> Estado y Riesgo</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Riesgo</h6>
                        @php
                            $riskBg = match($system->risk_level) {
                                'critical' => 'danger',
                                'high' => 'warning',
                                'medium' => 'info',
                                default => 'success'
                            };
                        @endphp
                        <span class="badge text-bg-{{ $riskBg }} p-3 fs-6 rounded-pill">
                            {{ strtoupper($system->risk_level) }}
                        </span>
                    </div>
                    <hr>
                    <div>
                        <h6 class="text-muted mb-2">Estado</h6>
                        <span class="badge bg-light text-dark p-3 fs-6 rounded-pill">
                            {{ ucfirst($system->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card card-soft">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-code-branch text-success"></i> Versiones</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Versión Actual Instalada</h6>
                        <code class="fs-5 bg-light p-2 rounded d-block">{{ $system->current_version }}</code>
                    </div>
                    <div>
                        <h6 class="text-muted mb-2">Versión Objetivo / Recomendada</h6>
                        <code class="fs-5 bg-light p-2 rounded d-block">{{ $system->latest_version }}</code>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card card-soft">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file-check text-info"></i> Documentación</h5>
                </div>
                <div class="card-body">
                    <h6 class="text-muted mb-3">¿Está Documentado?</h6>
                    @if($system->is_documented)
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-check-circle"></i> Sí, está documentado internamente
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-circle"></i> No, falta documentación
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card card-soft">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-sticky-note text-warning"></i> Notas y Observaciones</h5>
        </div>
        <div class="card-body">
            @if($system->notes)
                <p class="mb-0">{{ nl2br(e($system->notes)) }}</p>
            @else
                <p class="text-muted mb-0"><i class="fas fa-inbox"></i> Sin observaciones registradas</p>
            @endif
        </div>
    </div>
@endsection
