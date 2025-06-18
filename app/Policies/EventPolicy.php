<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Event;

class EventPolicy
{
    /**
     * Determina si el usuario puede ver la lista de eventos.
     */
    public function viewAny(Usuario $user)
    {
        return $user->hasRole(['admin', 'editor', 'visualizador']);
    }

    /**
     * Determina si el usuario puede ver un evento específico.
     */
    public function view(Usuario $user, Event $event)
    {
        return $user->hasRole(['admin', 'editor', 'visualizador']);
    }

    /**
     * Determina si el usuario puede crear eventos.
     */
    public function create(Usuario $user)
    {
        return $user->hasRole(['admin', 'editor']);
    }

    /**
     * Determina si el usuario puede actualizar un evento.
     */
    public function update(Usuario $user, Event $event)
    {
        return $user->hasRole(['admin', 'editor']);
    }

    /**
     * Determina si el usuario puede eliminar un evento.
     */
    public function delete(Usuario $user, Event $event)
    {
        return $user->hasRole('admin');
    }
} 