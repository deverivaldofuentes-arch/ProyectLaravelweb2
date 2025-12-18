@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="auth-wrapper">
    <div class="card auth-card animate-fade-in">
        <h2 style="text-align: center; margin-bottom: 2rem;">Bienvenido de nuevo</h2>
        
        <div id="error-msg" style="display: none; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: #fca5a5; padding: 0.75rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.9rem;"></div>

        <form id="login-form">
            <div class="form-group">
                <label class="label" for="email">Correo Electrónico</label>
                <input type="email" id="email" class="input" placeholder="ejemplo@correo.com" required>
            </div>
            <div class="form-group">
                <label class="label" for="password">Contraseña</label>
                <input type="password" id="password" class="input" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Ingresar</button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
            ¿No tienes una cuenta? <a href="/register" style="color: var(--primary);">Regístrate aquí</a>
        </p>
    </div>
</div>

<script>
    document.getElementById('login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorMsg = document.getElementById('error-msg');
        const btn = e.target.querySelector('button');

        // Reset error
        errorMsg.style.display = 'none';
        btn.disabled = true;
        btn.innerHTML = 'Cargando...';

        try {
            const response = await axios.post('/api/login', {
                email,
                password
            });

            // Assuming standard JWT response structure: { access_token: "...", ... }
            const token = response.data.access_token || response.data.token;
            
            if (token) {
                localStorage.setItem('token', token);
                // Redirect to home
                window.location.href = '/';
            } else {
                throw new Error('No token received');
            }

        } catch (error) {
            console.error(error);
            errorMsg.innerText = error.response?.data?.message || 'Error al iniciar sesión. Verifica tus credenciales.';
            errorMsg.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = 'Ingresar';
        }
    });
</script>
@endsection
