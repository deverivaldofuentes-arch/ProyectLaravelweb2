<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Market Premium')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS (No Vite - Direct Asset) -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <!-- External Libs (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Inline Scripts for Base Config -->
    <script>
        window.API_URL = "{{ url('/api') }}";
        window.APP_URL = "{{ url('/') }}";
        // Ensure axios is available before custom scripts run
    </script>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="container nav-content">
            <a href="/" class="brand">NovaMarket</a>
            
            <div class="nav-links" id="nav-links">
                <a href="/" class="nav-link">Inicio</a>
                <a href="/tiendas" class="nav-link">Tiendas</a>
                <a href="/productos" class="nav-link">Productos</a>
            </div>

            <div class="flex items-center gap-4" id="auth-section">
                <!-- Content injected by JS -->
                <div class="loader-placeholder" style="color: var(--text-muted);">Cargando...</div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} NovaMarket. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- App Logic (No Vite - Direct Asset) -->
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
