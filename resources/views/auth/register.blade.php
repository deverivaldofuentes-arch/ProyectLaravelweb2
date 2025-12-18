@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="auth-wrapper">
    <div class="card auth-card animate-fade-in" style="max-width: 500px;">
        <h2 style="text-align: center; margin-bottom: 2rem;">Crear Cuenta</h2>
        
        <div id="error-msg" style="display: none; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: #fca5a5; padding: 0.75rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.9rem;"></div>

        <form id="register-form">
            <div class="form-group">
                <label class="label" for="name">Nombre Completo</label>
                <input type="text" id="name" class="input" placeholder="Juan Pérez" required>
            </div>
            <div class="form-group">
                <label class="label" for="email">Correo Electrónico</label>
                <input type="email" id="email" class="input" placeholder="ejemplo@correo.com" required>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="label" for="password">Contraseña</label>
                    <input type="password" id="password" class="input" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label class="label" for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" class="input" placeholder="••••••••" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Registrarse</button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
            ¿Ya tienes una cuenta? <a href="/login" style="color: var(--primary);">Inicia Sesión</a>
        </p>
    </div>
</div>

<script>
    document.getElementById('register-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;
        
        const errorMsg = document.getElementById('error-msg');
        const btn = e.target.querySelector('button');

        errorMsg.style.display = 'none';
        
        if (password !== password_confirmation) {
            errorMsg.innerText = 'Las contraseñas no coinciden';
            errorMsg.style.display = 'block';
            return;
        }

        btn.disabled = true;
        btn.innerHTML = 'Cargando...';

        try {
            await axios.post('/api/register', {
                name,
                email,
                password,
                password_confirmation
            });

            // Redirect to login on success
            // Some APIs return token on register, others require login.
            // Safe bet: redirect to login with a message, or auto-login.
            // Let's redirect to login for simplicity.
            window.location.href = '/login';

        } catch (error) {
            console.error(error);
            const msg = error.response?.data?.message || 'Error al registrarse checkea los datos.';
            // Sometimes validation errors are in errors object
            // if (error.response?.data?.errors) ...
            errorMsg.innerText = msg;
            errorMsg.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = 'Registrarse';
        }
    });
</script>
@endsection
