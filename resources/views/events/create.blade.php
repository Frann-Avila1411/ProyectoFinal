@extends('layouts.app')

@section('content')
@can('create', App\Models\Event::class)
<div class="container">
    <h1 class="neon-text">Crear Evento</h1>
    <form action="{{ route('events.store') }}" method="POST" id="formEvento" novalidate>
        @csrf
        <div class="mb-3">
            <label for="nombre_evento" class="form-label">Nombre del Evento</label>
            <input type="text" class="form-control @error('nombre_evento') is-invalid @enderror" id="nombre_evento" name="nombre_evento" value="{{ old('nombre_evento') }}" required maxlength="100">
            @error('nombre_evento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
            @error('fecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" class="form-control @error('lugar') is-invalid @enderror" id="lugar" name="lugar" value="{{ old('lugar') }}" required maxlength="255">
            @error('lugar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="descripción" class="form-label">Descripción</label>
            <textarea class="form-control @error('descripción') is-invalid @enderror" id="descripción" name="descripción">{{ old('descripción') }}</textarea>
            @error('descripción')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-principal">Guardar</button>
        <a href="{{ route('events.index') }}" class="btn btn-cancelar">Cancelar</a>
    </form>
</div>
<script>
    // Autoguardado con localStorage para crear evento
    const formId = 'formEventoCreate';
    const fields = ['nombre_evento', 'fecha', 'lugar', 'descripción'];
    // Cargar datos guardados
    window.addEventListener('DOMContentLoaded', function() {
        const saved = localStorage.getItem(formId);
        if (saved) {
            const data = JSON.parse(saved);
            fields.forEach(f => {
                if (data[f]) document.getElementById(f).value = data[f];
            });
        }
    });
    // Guardar cambios
    fields.forEach(f => {
        document.getElementById(f).addEventListener('input', function() {
            const data = {};
            fields.forEach(ff => data[ff] = document.getElementById(ff).value);
            localStorage.setItem(formId, JSON.stringify(data));
        });
    });
    // Validación de fecha no pasada
    function isDatePast(dateStr) {
        const inputDate = new Date(dateStr);
        const today = new Date();
        today.setHours(0,0,0,0);
        return inputDate < today;
    }
    document.getElementById('formEvento').addEventListener('submit', function(e) {
        const fechaInput = document.getElementById('fecha');
        const errorDiv = fechaInput.nextElementSibling;
        if (isDatePast(fechaInput.value)) {
            e.preventDefault();
            fechaInput.classList.add('is-invalid');
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.textContent = 'La fecha no puede ser pasada.';
            }
            return false;
        } else {
            fechaInput.classList.remove('is-invalid');
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.textContent = '';
            }
        }
        localStorage.removeItem(formId);
    });
</script>
@endcan
@endsection 