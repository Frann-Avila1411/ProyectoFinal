@extends('layouts.app')

@section('content')
@can('view', $evento)
<div class="container">
    <h2 class="neon-text">Detalles del Evento</h2>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $evento->nombre_evento }}</h5>
            <p class="card-text"><strong>Fecha:</strong> {{ $evento->fecha->format('d/m/Y') }}</p>
            <p class="card-text"><strong>Lugar:</strong> {{ $evento->lugar }}</p>
            <p class="card-text"><strong>Descripción:</strong> <span class="descripcion-evento">{{ $evento->descripción }}</span></p>
            <a href="{{ route('events.index') }}" class="btn btn-cancelar">Volver</a>
        </div>
    </div>
    <div id="climaCard" class="card" style="max-width: 400px; display:none;">
        <div class="card-body">
            <h5 class="card-title">Clima actual en <span id="climaLugar"></span></h5>
            <p class="card-text" id="climaInfo"></p>
        </div>
    </div>
    <div id="climaError" class="alert alert-danger mt-2" style="display:none;"></div>
</div>
<script>
// Función para obtener coordenadas de una ciudad usando Open-Meteo Geocoding API
async function getCoords(city) {
    const url = `https://geocoding-api.open-meteo.com/v1/search?name=${encodeURIComponent(city)}&count=1&language=es&format=json`;
    const resp = await axios.get(url);
    if (resp.data && resp.data.results && resp.data.results.length > 0) {
        return {
            lat: resp.data.results[0].latitude,
            lon: resp.data.results[0].longitude,
            name: resp.data.results[0].name
        };
    } else {
        throw new Error('No se encontraron coordenadas para la ciudad.');
    }
}
// Función para obtener clima actual
async function getWeather(lat, lon) {
    const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true&timezone=auto`;
    const resp = await axios.get(url);
    if (resp.data && resp.data.current_weather) {
        return resp.data.current_weather;
    } else {
        throw new Error('No se pudo obtener el clima actual.');
    }
}
// Mostrar clima al cargar la página
window.addEventListener('DOMContentLoaded', async function() {
    const lugar = @json($evento->lugar);
    document.getElementById('climaLugar').textContent = lugar;
    try {
        const coords = await getCoords(lugar);
        const weather = await getWeather(coords.lat, coords.lon);
        let icon = '';
        if (weather.weathercode === 0) icon = '☀️';
        else if ([1,2,3].includes(weather.weathercode)) icon = '⛅';
        else if ([45,48].includes(weather.weathercode)) icon = '🌫️';
        else if ([51,53,55,56,57,61,63,65,66,67,80,81,82].includes(weather.weathercode)) icon = '🌧️';
        else if ([71,73,75,77,85,86].includes(weather.weathercode)) icon = '❄️';
        else if ([95,96,99].includes(weather.weathercode)) icon = '⛈️';
        document.getElementById('climaInfo').innerHTML = `${icon} ${weather.temperature}°C, Viento: ${weather.windspeed} km/h`;
        document.getElementById('climaCard').style.display = '';
    } catch (err) {
        document.getElementById('climaError').textContent = 'Error al obtener el clima: ' + err.message;
        document.getElementById('climaError').style.display = '';
    }
});
</script>
@endcan
@endsection 