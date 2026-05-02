@csrf

<div class="row g-4">
    <div class="col-12 col-md-6">
        <label for="name" class="form-label">
            <i class="fas fa-cube text-primary"></i> Nombre del Sistema
        </label>
        <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name', $system->name ?? '') }}" required maxlength="120" placeholder="Ej: Apache Web Server">
        @error('name')<small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="owner" class="form-label">
            <i class="fas fa-user-circle text-info"></i> Responsable
        </label>
        <input type="text" class="form-control form-control-lg" id="owner" name="owner" value="{{ old('owner', $system->owner ?? '') }}" maxlength="120" placeholder="Nombre del responsable">
        @error('owner')<small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="current_version" class="form-label">
            <i class="fas fa-code-branch text-success"></i> Versión Actual
        </label>
        <input type="text" class="form-control form-control-lg" id="current_version" name="current_version" value="{{ old('current_version', $system->current_version ?? '') }}" required maxlength="50" placeholder="Ej: 2.4.41">
        @error('current_version')<small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="latest_version" class="form-label">
            <i class="fas fa-arrow-up text-warning"></i> Versión Objetivo
        </label>
        <input type="text" class="form-control form-control-lg" id="latest_version" name="latest_version" value="{{ old('latest_version', $system->latest_version ?? '') }}" required maxlength="50" placeholder="Ej: 2.4.58">
        @error('latest_version')<small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label for="risk_level" class="form-label">
            <i class="fas fa-exclamation-triangle text-danger"></i> Nivel de Riesgo
        </label>
        <select id="risk_level" name="risk_level" class="form-select form-select-lg" required>
            @php($risk = old('risk_level', $system->risk_level ?? 'medium'))
            <option value="low" @selected($risk === 'low')><i class="fas fa-check"></i> Bajo</option>
            <option value="medium" @selected($risk === 'medium')><i class="fas fa-minus"></i> Medio</option>
            <option value="high" @selected($risk === 'high')><i class="fas fa-exclamation"></i> Alto</option>
            <option value="critical" @selected($risk === 'critical')><i class="fas fa-times"></i> Crítico</option>
        </select>
        @error('risk_level')<small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label for="status" class="form-label">
            <i class="fas fa-signal text-info"></i> Estado
        </label>
        @php($status = old('status', $system->status ?? 'unknown'))
        <select id="status" name="status" class="form-select form-select-lg" required>
            <option value="updated" @selected($status === 'updated')><i class="fas fa-check-circle"></i> Actualizado</option>
            <option value="outdated" @selected($status === 'outdated')><i class="fas fa-clock"></i> Desactualizado</option>
            <option value="unknown" @selected($status === 'unknown')><i class="fas fa-question-circle"></i> Desconocido</option>
        </select>
        @error('status')<small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label for="last_updated_at" class="form-label">
            <i class="fas fa-calendar-alt text-secondary"></i> Última Actualización
        </label>
        <input type="date" class="form-control form-control-lg" id="last_updated_at" name="last_updated_at" value="{{ old('last_updated_at', isset($system) && $system->last_updated_at ? $system->last_updated_at->format('Y-m-d') : '') }}">
        @error('last_updated_at')<small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>@enderror
    </div>

    <div class="col-12">
        <div class="form-check form-check-lg p-3 bg-light rounded-3 border-2">
            <input class="form-check-input" type="checkbox" value="1" id="is_documented" name="is_documented" @checked(old('is_documented', $system->is_documented ?? false))>
            <label class="form-check-label" for="is_documented">
                <i class="fas fa-file-check text-success"></i>
                <strong>Versiones documentadas internamente</strong>
                <small class="text-muted d-block">Marca esta opción si tu organización mantiene documentación interna sobre las versiones instaladas.</small>
            </label>
        </div>
    </div>

    <div class="col-12">
        <label for="notes" class="form-label">
            <i class="fas fa-sticky-note text-warning"></i> Notas y Observaciones
        </label>
        <textarea class="form-control" id="notes" name="notes" rows="4" maxlength="2000" placeholder="Añade información adicional sobre este sistema, cambios recientes, problemas conocidos, etc." style="border-radius: 8px; border: 2px solid #e5e7eb;">{{ old('notes', $system->notes ?? '') }}</textarea>
        <small class="text-muted d-block mt-2"><i class="fas fa-info-circle"></i> Máximo 2000 caracteres</small>
        @error('notes')<small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>@enderror
    </div>
</div>

<div class="mt-5 d-flex gap-2 justify-content-end">
    <a href="{{ route('systems.index') }}" class="btn btn-lg btn-outline-secondary">
        <i class="fas fa-times-circle"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-lg btn-primary">
        <i class="fas fa-save"></i> {{ $submitLabel }}
    </button>
</div>
