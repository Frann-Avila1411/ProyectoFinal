@extends('layouts.app')

@section('content')
    <h2>Crear Evento</h2>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre del Evento</label>
            <input type="text" name="nombre_evento" 
            class="form-control @error('nombre_evento') is-invalid @enderror"
                value="{{ old('nombre_evento') }}">
            @error('nombre_evento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" 
            class="form-control @error('fecha') is-invalid @enderror"
                value="{{ old('fecha') }}">
            @error('fecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Lugar</label>
            <input type="text" name="lugar" 
            class="form-control @error('lugar') is-invalid @enderror"
                value="{{ old('lugar') }}">
            @error('lugar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripción"
                class="form-control @error('descripción') is-invalid @enderror">{{ old('descripción') }}</textarea>
            @error('descripción')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/eventos.js') }}"></script>
@endsection