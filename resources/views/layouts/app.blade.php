<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eventos')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark-mode');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                document.documentElement.classList.remove('dark-mode');
            }
        })();
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg mb-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <!-- Heroicon: Calendar -->
                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="7" width="18" height="14" rx="4" fill="#fff" stroke="#6366F1" stroke-width="2"/><path d="M16 3v4M8 3v4" stroke="#6366F1" stroke-width="2" stroke-linecap="round"/><rect x="7" y="11" width="2" height="2" rx="1" fill="#6366F1"/><rect x="11" y="11" width="2" height="2" rx="1" fill="#6366F1"/><rect x="15" y="11" width="2" height="2" rx="1" fill="#6366F1"/></svg>
                <span>Eventos</span>
            </a>
            <div class="d-flex align-items-center ms-auto">
                <span class="me-2">🌞</span>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="themeSwitch">
                </div>
                <span class="ms-2">🌙</span>
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Cambiar tema claro/oscuro y guardar preferencia
        const themeSwitch = document.getElementById('themeSwitch');
        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
            }
            localStorage.setItem('theme', theme);
            themeSwitch.checked = theme === 'dark';
        }
        // Inicializar tema
        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);
        themeSwitch.addEventListener('change', function() {
            setTheme(this.checked ? 'dark' : 'light');
        });
    </script>
</body>
</html> 