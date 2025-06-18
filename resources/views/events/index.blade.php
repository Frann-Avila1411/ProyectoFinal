@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="neon-text">Lista de Eventos</h1>
    @if(session('success'))
        <div class="alert alert-success transition">{{ session('success') }}</div>
    @endif
    {{-- Campo de búsqueda --}}
    <div class="mb-3">
        <input type="text" id="busquedaEvento" class="form-control" placeholder="Buscar por nombre o fecha (dd/mm/yyyy)">
    </div>
    {{-- Botón crear --}}
    @can('create', App\Models\Event::class)
    <a href="{{ route('events.create') }}" class="btn btn-principal mb-3">
        <!-- Heroicon: Plus -->
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="vertical-align:middle;"><path stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4" stroke="#fff"/></svg>
        Crear Evento
    </a>
    @endcan
    <div id="spinnerEventos" class="spinner" style="display:none;"></div>
    <div class="timeline" id="timelineEventos">
        @forelse ($eventos as $evento)
        <div class="timeline-card transition">
            <div class="d-flex align-items-center mb-2">
                <!-- Heroicon: Calendar -->
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-2"><rect x="3" y="7" width="18" height="14" rx="4" fill="#fff" stroke="#6366F1" stroke-width="2"/><path d="M16 3v4M8 3v4" stroke="#6366F1" stroke-width="2" stroke-linecap="round"/></svg>
                <span class="fw-bold fs-5">{{ $evento->nombre_evento }}</span>
            </div>
            <div class="mb-2">
                <!-- Heroicon: MapPin -->
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1"><path stroke-linecap="round" stroke-width="2" d="M12 21c-4.418 0-8-4.03-8-9a8 8 0 1 1 16 0c0 4.97-3.582 9-8 9z" stroke="#6366F1"/><circle cx="12" cy="12" r="3" fill="#6366F1"/></svg>
                <span>{{ $evento->lugar }}</span>
            </div>
            <div class="mb-2">
                <!-- Heroicon: Clock -->
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1"><circle cx="12" cy="12" r="10" stroke="#6366F1" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M12 6v6l4 2" stroke="#6366F1"/></svg>
                <span>{{ $evento->fecha->format('d/m/Y') }}</span>
            </div>
            <div class="mb-2">
                <span class="descripcion-evento">{{ $evento->descripción }}</span>
            </div>
            <div class="mt-2">
                @can('view', $evento)
                <a href="{{ route('events.show', $evento->id) }}" class="btn btn-info btn-sm transition">
                    <!-- Heroicon: Eye -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="M1.5 12s3.5-7 10.5-7 10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12z" stroke="#6366F1"/><circle cx="12" cy="12" r="3" fill="#6366F1"/></svg>
                    Ver
                </a>
                @endcan
                @can('update', $evento)
                <a href="{{ route('events.edit', $evento->id) }}" class="btn btn-principal btn-sm transition">
                    <!-- Heroicon: Pencil -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 1 1 2.828 2.828L11.828 15.828a2 2 0 0 1-2.828 0L9 13z" stroke="#fff"/></svg>
                    Editar
                </a>
                @endcan
                @can('delete', $evento)
                <form action="{{ route('events.destroy', $evento->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-cancelar btn-sm transition" onclick="return confirm('¿Eliminar este evento?')">
                        <!-- Heroicon: Trash -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M9 7V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v3" stroke="#6366F1"/><path stroke-linecap="round" stroke-width="2" d="M4 7h16" stroke="#6366F1"/></svg>
                        Eliminar
                    </button>
                </form>
                @endcan
            </div>
        </div>
        @empty
        <div class="alert alert-info">No hay eventos disponibles.</div>
        @endforelse
    </div>
    {{ $eventos->links() }}
</div>
<script>
// Spinner de carga 
const spinner = document.getElementById('spinnerEventos');
const timeline = document.getElementById('timelineEventos');
spinner.style.display = 'block';
timeline.style.display = 'none';
window.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        spinner.style.display = 'none';
        timeline.style.display = '';
    }, 700); 
});
// Filtro de eventos por nombre o fecha
document.getElementById('busquedaEvento').addEventListener('input', function() {
    const filtro = this.value.toLowerCase();
    const filas = document.querySelectorAll('#timelineEventos .timeline-card');
    filas.forEach(fila => {
        const nombre = fila.querySelector('.fw-bold').textContent.toLowerCase();
        const fecha = fila.querySelector('span:nth-child(3)').textContent.toLowerCase();
        if (nombre.includes(filtro) || fecha.includes(filtro)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});
</script>
@endsection 