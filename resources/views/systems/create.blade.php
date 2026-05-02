@extends('layouts.bootstrap', ['title' => 'Nuevo Sistema'])

@section('content')
    <div class="mb-4">
        <a href="{{ route('systems.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="h3 fw-800 mb-1">
            <i class="fas fa-plus-circle text-primary"></i> Registrar Nuevo Sistema
        </h1>
        <p class="text-muted">Completa el formulario para añadir un nuevo sistema al inventario de tu organización.</p>
    </div>

    <div class="card card-soft">
        <div class="card-body p-4">
            <form action="{{ route('systems.store') }}" method="POST">
                @include('systems._form', ['submitLabel' => 'Guardar Sistema'])
            </form>
        </div>
    </div>
@endsection
