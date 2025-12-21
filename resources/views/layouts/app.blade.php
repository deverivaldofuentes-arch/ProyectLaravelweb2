<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NovaMarket')</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #10b981;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #cbd5e1;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: var(--light);
            min-height: 100vh;
            position: relative;
        }
        
        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--light);
            border: 1px solid var(--gray);
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1000;
            padding: 1rem 2rem;
        }
        
        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-link {
            color: var(--gray-light);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .auth-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: 600;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--dark-light);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            padding: 1rem;
            min-width: 200px;
            display: none;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .dropdown-menu.active {
            display: flex;
        }
        
        .dropdown-item {
            color: var(--light);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: var(--transition);
        }
        
        .dropdown-item:hover {
            background: var(--glass-bg);
        }
        
        .main-content {
            padding-top: 80px;
            min-height: calc(100vh - 120px);
            max-width: 1400px;
            margin: 0 auto;
            padding: 6rem 2rem 2rem;
        }
        
        .footer {
            background: rgba(15, 23, 42, 0.95);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            text-align: center;
            color: var(--gray);
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .cart-count {
            background: var(--secondary);
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 50%;
            position: absolute;
            top: -8px;
            right: -8px;
        }
        
        .cart-link {
            position: relative;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-left-color: var(--secondary);
            color: #34d399;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-left-color: #ef4444;
            color: #f87171;
        }
        
        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border-left-color: #3b82f6;
            color: #60a5fa;
        }
        
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--light);
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .nav-links {
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background: var(--dark);
                flex-direction: column;
                padding: 2rem;
                gap: 1rem;
                transform: translateY(-100%);
                opacity: 0;
                transition: var(--transition);
                border-bottom: 1px solid var(--glass-border);
            }
            
            .nav-links.active {
                transform: translateY(0);
                opacity: 1;
            }
            
            .main-content {
                padding: 5rem 1rem 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="logo">NovaMarket</a>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="nav-links" id="navLinks">
                <a href="/" class="nav-link">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ route('tiendas.index') }}" class="nav-link">
                    <i class="fas fa-store"></i> Tiendas
                </a>
                <a href="{{ route('productos.index') }}" class="nav-link">
                    <i class="fas fa-box"></i> Productos
                </a>
                <a href="{{ route('carrito.index') }}" class="nav-link cart-link">
                    <i class="fas fa-shopping-cart"></i> Carrito
                    <span class="cart-count" id="cartCount">0</span>
                </a>
                <a href="{{ route('pedidos.index') }}" class="nav-link">
                    <i class="fas fa-receipt"></i> Pedidos
                </a>
                <a href="{{ route('chat.index') }}" class="nav-link">
                    <i class="fas fa-robot"></i> Chat IA
                </a>
                
                <div class="auth-section" id="authSection">
                    <!-- Se llenará dinámicamente con JS -->
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} NovaMarket. Todos los derechos reservados.</p>
            <p>Plataforma de e-commerce para emprendedores</p>
            <div style="margin-top: 1rem;">
                <a href="#" class="nav-link" style="display: inline-block; margin: 0 0.5rem;">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="nav-link" style="display: inline-block; margin: 0 0.5rem;">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="nav-link" style="display: inline-block; margin: 0 0.5rem;">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    
    <script>
        // Estado global
        window.NovaMarket = {
            token: localStorage.getItem('token'),
            user: JSON.parse(localStorage.getItem('user') || 'null'),
            cart: JSON.parse(localStorage.getItem('cart') || '{"items":[], "count":0}')
        };
		axios.defaults.baseURL = '{{ url('/') }}'; // Solo la raíz, sin /api

		// Configurar headers por defecto
		axios.defaults.headers.common['Accept'] = 'application/json';
		axios.defaults.headers.common['Content-Type'] = 'application/json';

		// Interceptor para agregar token automáticamente
		axios.interceptors.request.use(function (config) {
			const token = localStorage.getItem('token');
			if (token) {
				config.headers.Authorization = `Bearer ${token}`;
			}
			return config;
		}, function (error) {
			return Promise.reject(error);
		});

        if (window.NovaMarket.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.NovaMarket.token;
        }

        // Actualizar contador del carrito
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart') || '{"count":0}');
            document.getElementById('cartCount').textContent = cart.count || 0;
        }

        // Renderizar sección de autenticación
        function renderAuthSection() {
            const authSection = document.getElementById('authSection');
            if (!authSection) return;

            if (window.NovaMarket.user) {
                authSection.innerHTML = `
                    <div class="user-dropdown">
                        <div class="user-avatar" onclick="this.nextElementSibling.classList.toggle('active')">
                            ${window.NovaMarket.user.name ? window.NovaMarket.user.name.charAt(0).toUpperCase() : 'U'}
                        </div>
                        <div class="dropdown-menu glass-effect">
                            <a href="{{ route('profile.index') }}" class="dropdown-item">
                                <i class="fas fa-user"></i> Mi Perfil
                            </a>
                            <a href="{{ route('pedidos.index') }}" class="dropdown-item">
                                <i class="fas fa-receipt"></i> Mis Pedidos
                            </a>
                            <div class="dropdown-divider" style="height: 1px; background: var(--glass-border); margin: 0.5rem 0;"></div>
                            <button onclick="logout()" class="dropdown-item" style="background: none; border: none; color: inherit; cursor: pointer; text-align: left;">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </div>
                    </div>
                `;
            } else {
                authSection.innerHTML = `
                    <a href="{{ route('login') }}" class="btn-secondary">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary">
                        <i class="fas fa-user-plus"></i> Registrarse
                    </a>
                `;
            }
        }

        // Función de logout
        async function logout() {
            try {
                await axios.post('/api/logout');
            } catch (error) {
                console.log('Error en logout:', error);
            } finally {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                localStorage.removeItem('cart');
                window.NovaMarket.token = null;
                window.NovaMarket.user = null;
                window.NovaMarket.cart = {items: [], count: 0};
                axios.defaults.headers.common['Authorization'] = null;
                renderAuthSection();
                updateCartCount();
                window.location.href = '/';
            }
        }

        // Mobile menu toggle
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            renderAuthSection();
            updateCartCount();
        });

        // Función global para mostrar loading
        window.showLoading = function(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading"></span> Procesando...';
            button.disabled = true;
            return originalText;
        };

        window.hideLoading = function(button, originalText) {
            button.innerHTML = originalText;
            button.disabled = false;
        };

        // Función global para mostrar alertas
        window.showAlert = function(message, type = 'success', duration = 5000) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" 
                            style="background: none; border: none; color: inherit; cursor: pointer;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            const container = document.querySelector('.main-content') || document.body;
            container.insertBefore(alertDiv, container.firstChild);
            
            if (duration > 0) {
                setTimeout(() => {
                    if (alertDiv.parentElement) {
                        alertDiv.remove();
                    }
                }, duration);
            }
        };
    </script>
    
    @yield('scripts')
</body>
</html>
