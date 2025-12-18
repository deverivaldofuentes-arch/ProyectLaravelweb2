/**
 * Init global axios
 */
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Auth State Management
const updateAuthUI = () => {
    const token = localStorage.getItem('token');
    const authSection = document.getElementById('auth-section');

    // Set axios Auth header globally if token exists
    if (token) {
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    } else {
        delete window.axios.defaults.headers.common['Authorization'];
    }

    if (!authSection) return;

    if (token) {
        authSection.innerHTML = `
            <a href="/carrito" class="nav-link" title="Carrito">
                🛒 <span id="cart-count"></span>
            </a>
            <a href="/perfil" class="nav-link">Mi Perfil</a>
            <button id="logout-btn" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Cerrar Sesión</button>
        `;

        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', async () => {
                try {
                    await window.axios.post('/api/logout');
                } catch (error) {
                    console.error('Logout error', error);
                } finally {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                }
            });
        }
    } else {
        authSection.innerHTML = `
            <a href="/login" class="nav-link">Iniciar Sesión</a>
            <a href="/register" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Registrarse</a>
        `;
    }
};

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    updateAuthUI();
});
