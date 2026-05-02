@extends('layouts.bootstrap', ['title' => 'Sistemas'])

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h2 fw-800 mb-1">
                <i class="fas fa-server text-primary"></i> Inventario de Sistemas
            </h1>
            <p class="text-muted mb-0">Gestiona versiones instaladas y prioridades de actualización en toda tu infraestructura.</p>
        </div>

        @can('create', App\Models\System::class)
            <a href="{{ route('systems.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Registrar Sistema
            </a>
        @endcan
    </div>

    <div class="card card-soft mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('systems.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md-8">
                    <label for="search" class="form-label">
                        <i class="fas fa-search"></i> Buscar Sistema
                    </label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        class="form-control form-control-lg"
                        placeholder="Nombre, responsable, versión..."
                        value="{{ $search }}"
                    >
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1" type="submit">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('systems.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-soft">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="fas fa-cube"></i> Sistema</th>
                        <th><i class="fas fa-user"></i> Responsable</th>
                        <th><i class="fas fa-code-branch"></i> Versión</th>
                        <th><i class="fas fa-arrow-right"></i> Objetivo</th>
                        <th><i class="fas fa-exclamation"></i> Riesgo</th>
                        <th><i class="fas fa-signal"></i> Estado</th>
                        <th><i class="fas fa-file-check"></i> Documentado</th>
                        <th class="text-end"><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($systems as $system)
                        <tr>
                            <td>
                                <strong>{{ $system->name }}</strong>
                            </td>
                            <td>
                                @if($system->owner)
                                    <span class="badge bg-light text-dark">{{ $system->owner }}</span>
                                @else
                                    <span class="badge bg-secondary">Sin asignar</span>
                                @endif
                            </td>
                            <td><code>{{ $system->current_version }}</code></td>
                            <td><code>{{ $system->latest_version }}</code></td>
                            <td>
                                @php
                                    $riskBg = match($system->risk_level) {
                                        'critical' => 'danger',
                                        'high' => 'warning',
                                        'medium' => 'info',
                                        default => 'success'
                                    };
                                @endphp
                                <span class="badge text-bg-{{ $riskBg }}">{{ strtoupper($system->risk_level) }}</span>
                            </td>
                            <td>
                                @php
                                    $statusIcon = match($system->status) {
                                        'updated' => 'check-circle text-success',
                                        'outdated' => 'clock text-warning',
                                        default => 'question-circle text-secondary'
                                    };
                                @endphp
                                <span><i class="fas fa-{{ $statusIcon }}"></i> {{ ucfirst($system->status) }}</span>
                            </td>
                            <td class="text-center">
                                @if($system->is_documented)
                                    <span class="badge text-bg-success"><i class="fas fa-check"></i> Sí</span>
                                @else
                                    <span class="badge text-bg-warning"><i class="fas fa-times"></i> No</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('systems.show', $system) }}" class="btn btn-primary" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('update', $system)
                                        <a href="{{ route('systems.edit', $system) }}" class="btn btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $system)
                                        <form action="{{ route('systems.destroy', $system) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Confirma que desea eliminar este sistema?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-50 d-block"></i>
                                <p>No hay registros disponibles. <a href="{{ route('systems.create') }}">Crea el primero</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $systems->links() }}
    </div>
@endsection
