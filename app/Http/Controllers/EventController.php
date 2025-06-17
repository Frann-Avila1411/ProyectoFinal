<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Listar eventos con filtros y paginación
    public function index(Request $request)
    {
        $query = Event::orderBy('fecha', 'asc');

        // Aplicar búsqueda según filtro seleccionado
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            if ($request->filter == 'nombre_evento') {
                $query->where('nombre_evento', 'LIKE', '%' . $search . '%');
            } elseif ($request->filter == 'lugar') {
                $query->where('lugar', 'LIKE', '%' . $search . '%');
            } else {
                $query->where('nombre_evento', 'LIKE', '%' . $search . '%')
                      ->orWhere('lugar', 'LIKE', '%' . $search . '%');
            }
        }

        // Filtrar por tipo de evento
        if ($request->has('evento') && $request->evento != '') {
            $query->where('nombre_evento', 'LIKE', '%' . $request->evento . '%');
        }

        // Filtrar por lugar
        if ($request->has('lugar') && $request->lugar != '') {
            $query->where('lugar', 'LIKE', '%' . $request->lugar . '%');
        }

        // Obtener eventos paginados
        $eventos = $query->paginate(10);

        return view('events.index', compact('eventos'));
    }

    // Mostrar formulario para crear nuevo evento
    public function create()
    {
        return view('events.create');
    }

    // Validar y almacenar nuevo evento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_evento' => 'required|string|max:100|unique:events',
            'fecha' => 'required|date|after_or_equal:today',
            'lugar' => 'required|string|max:255',
            'descripción' => 'nullable|string',
        ], [
            'nombre_evento.required' => 'El nombre del evento es obligatorio.',
            'nombre_evento.unique' => 'Este nombre de evento ya existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'Debe ingresar una fecha válida.',
            'fecha.after_or_equal' => 'La fecha debe ser hoy o en el futuro.',
            'lugar.required' => 'El lugar es obligatorio.',
        ]);

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Evento creado correctamente.');
    }

    // Mostrar detalles de un evento específico
    public function show($id)
    {
        $evento = Event::findOrFail($id);
        return view('events.show', compact('evento'));
    }

    // Mostrar formulario para editar evento
    public function edit($id)
    {
        $evento = Event::findOrFail($id);
        return view('events.edit', compact('evento'));
    }

    // Validar y actualizar evento existente
    public function update(Request $request, $id)
    {
        $evento = Event::findOrFail($id);

        $validated = $request->validate([
            'nombre_evento' => 'required|string|max:100|unique:events,nombre_evento,' . $evento->id,
            'fecha' => 'required|date|after_or_equal:today',
            'lugar' => 'required|string|max:255',
            'descripción' => 'nullable|string',
        ], [
            'nombre_evento.required' => 'El nombre del evento es obligatorio.',
            'nombre_evento.unique' => 'Este nombre de evento ya existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'Debe ingresar una fecha válida.',
            'fecha.after_or_equal' => 'La fecha debe ser hoy o en el futuro.',
            'lugar.required' => 'El lugar es obligatorio.',
        ]);

        $evento->update($validated);

        return redirect()->route('events.index')->with('success', 'Evento actualizado correctamente.');
    }

    // Eliminar evento por id
    public function destroy($id)
    {
        $evento = Event::findOrFail($id);
        $evento->delete();

        return redirect()->route('events.index')->with('success', 'Evento eliminado correctamente.');
    }
}
