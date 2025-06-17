@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Lista de Eventos</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Botón para crear un nuevo evento, que redirige al formulario de creación -->
        <a href="{{ route('events.create') }}" class="btn btn-primary">Nuevo Evento</a>
        
        <!-- Contenedor para la barra de búsqueda con filtros para filtrar eventos -->
        <div class="input-group" style="max-width: 800px; width: 100%;">
            <!-- Formulario que envía la información de búsqueda por método GET -->
            <form action="{{ route('events.index') }}" method="GET" class="d-flex w-100">
                <div class="d-flex flex-wrap w-100 gap-3">
                    <!-- Filtro desplegable para seleccionar el tipo de evento -->
                    <div class="mb-3">
                        <label for="evento" class="form-label">Tipo de Evento</label>
                        <select name="evento" id="evento" class="form-select">
                            <!-- Opción por defecto que no filtra por ningún tipo -->
                            <option value="">Seleccione un tipo de evento</option>
                            <!-- Opciones que se seleccionan dinámicamente según la petición actual -->
                            <option value="Boda" {{ request()->evento == 'Boda' ? 'selected' : '' }}>Boda</option>
                            <option value="Cumpleaños" {{ request()->evento == 'Cumpleaños' ? 'selected' : '' }}>Cumpleaños</option>
                            <option value="Aniversario" {{ request()->evento == 'Aniversario' ? 'selected' : '' }}>Aniversario</option>
                            <option value="Fiesta" {{ request()->evento == 'Fiesta' ? 'selected' : '' }}>Fiesta</option>
                            <option value="Concierto" {{ request()->evento == 'Concierto' ? 'selected' : '' }}>Concierto</option>
                            <option value="Taller" {{ request()->evento == 'Taller' ? 'selected' : '' }}>Taller</option>
                            <option value="Evento benéfico" {{ request()->evento == 'Evento benéfico' ? 'selected' : '' }}>Evento benéfico</option>
                            <option value="Bautizo" {{ request()->evento == 'Bautizo' ? 'selected' : '' }}>Bautizo</option>
                            <option value="Graduación" {{ request()->evento == 'Graduación' ? 'selected' : '' }}>Graduación</option>
                            <option value="Fiesta de 15 años" {{ request()->evento == 'Fiesta de 15 años' ? 'selected' : '' }}>Fiesta de 15 años</option>
                            <option value="Carnaval" {{ request()->evento == 'Carnaval' ? 'selected' : '' }}>Carnaval</option>
                        </select>
                    </div>

                    <!-- Filtro desplegable para seleccionar el lugar del evento -->
                    <div class="mb-3">
                        <label for="lugar" class="form-label">Lugar</label>
                        <select name="lugar" id="lugar" class="form-select">
                            <!-- Opción por defecto que no filtra por ningún lugar -->
                            <option value="">Seleccione un lugar</option>
                            <!-- Opciones que se seleccionan dinámicamente según la petición actual -->
                            <option value="Playa" {{ request()->lugar == 'Playa' ? 'selected' : '' }}>Playa</option>
                            <option value="Hotel" {{ request()->lugar == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="Restaurante" {{ request()->lugar == 'Restaurante' ? 'selected' : '' }}>Restaurante</option>
                            <option value="Salón" {{ request()->lugar == 'Salón' ? 'selected' : '' }}>Salón</option>
                            <option value="Finca" {{ request()->lugar == 'Finca' ? 'selected' : '' }}>Finca</option>
                            <option value="Estadio" {{ request()->lugar == 'Estadio' ? 'selected' : '' }}>Estadio</option>
                            <option value="Plaza" {{ request()->lugar == 'Plaza' ? 'selected' : '' }}>Plaza</option>
                        </select>
                    </div>

                    <!-- Campo de texto para buscar eventos o lugares con palabras clave -->
                    <div class="mb-3">
                        <label for="search" class="form-label">Buscar Evento o Lugar</label>
                        <!-- El valor del input se mantiene con la búsqueda actual para mejor experiencia -->
                        <input type="text" name="search" id="search" class="form-control" value="{{ request()->search }}" placeholder="Ejemplo: Fiesta, Playa">
                    </div>

                    <!-- Botón que envía el formulario para realizar la búsqueda -->
                    <div class="mb-3 d-flex align-items-end">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>

            <!-- Botón que aparece solo si hay algún filtro activo, para limpiar los filtros -->
            @if(request()->evento || request()->lugar || request()->search)
                <a href="{{ route('events.index') }}" class="btn btn-outline-danger ms-2 align-self-end">
                    Limpiar Filtros
                </a>
            @endif
        </div>
    </div>

    <!-- Mensaje de alerta que se muestra cuando no hay resultados para la búsqueda -->
    @if($eventos->isEmpty() && (request()->evento || request()->lugar || request()->search))
        <div class="alert alert-warning">
            <strong>¡No se encontraron resultados!</strong> Intenta con otra búsqueda.
        </div>
    @endif

    <!-- Tabla que muestra la lista de eventos filtrados o todos los eventos -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Lugar</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Recorremos cada evento para mostrarlo en una fila de la tabla -->
            @foreach($eventos as $evento)
                <tr>
                    <!-- Mostramos el nombre del evento -->
                    <td>{{ $evento->nombre_evento }}</td>
                    <!-- Mostramos la fecha formateada en día/mes/año -->
                    <td>{{ $evento->fecha->format('d/m/Y') }}</td>
                    <!-- Mostramos el lugar del evento -->
                    <td>{{ $evento->lugar }}</td>
                    <td>
                        <!-- Botón para ver detalles del evento -->
                        <a href="{{ route('events.show', $evento->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <!-- Botón para editar el evento -->
                        <a href="{{ route('events.edit', $evento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <!-- Formulario para eliminar el evento con confirmación -->
                        <form action="{{ route('events.destroy', $evento->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este evento?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación para navegar entre páginas de resultados -->
    <div class="d-flex justify-content-center">
        <!-- Se mantienen los filtros actuales al cambiar de página -->
        {{ $eventos->appends(['evento' => request()->evento, 'lugar' => request()->lugar, 'search' => request()->search])->links('pagination::bootstrap-4') }}
    </div>
@endsection
