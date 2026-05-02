@extends('layouts.bootstrap', ['title' => 'Editar Sistema'])

@section('content')
    <div class="mb-4">
        <a href="{{ route('systems.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="h3 fw-800 mb-1">
            <i class="fas fa-edit text-warning"></i> Editar Sistema
        </h1>
        <p class="text-muted">Actualiza la información del sistema: {{ $system->name }}</p>
    </div>

    <div class="card card-soft">
        <div class="card-body p-4">
            <form action="{{ route('systems.update', $system) }}" method="POST">
                @method('PUT')
                @include('systems._form', ['submitLabel' => 'Actualizar Sistema'])
            </form>
        </div>
    </div>
@endsection
