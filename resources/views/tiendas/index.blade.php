@extends('layouts.app')

@section('title', 'Tiendas - NovaMarket')

@section('content')
<div class="container" style="padding-top: 2rem;">
    <h1 class="mb-4">Nuestras Tiendas</h1>
    <div id="stores-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card" style="grid-column: 1/-1; text-align: center;">Cargando tiendas...</div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const grid = document.getElementById('stores-grid');
        try {
            const res = await axios.get('/api/tiendas');
            // Controller returns json(array) directly or inside data?
            // TiendaController: return response()->json($tiendas); -> Array
            const stores = Array.isArray(res.data) ? res.data : (res.data.data || []);

            grid.innerHTML = '';

            if (stores.length === 0) {
                grid.innerHTML = '<div class="card" style="grid-column: 1/-1; text-align: center;">No hay tiendas registradas aún.</div>';
                return;
            }

            stores.forEach(store => {
                const card = document.createElement('div');
                card.className = 'card animate-fade-in';
                // Assuming logo_url, nombre_tienda, descripcion, usuario.name
                const logo = store.logo_url ? `<img src="${store.logo_url}" alt="${store.nombre_tienda}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 1rem;">` : '<div style="width: 60px; height: 60px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-size: 1.5rem;">🏪</div>';
                
                card.innerHTML = `
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        ${logo}
                        <div>
                            <h3 style="margin: 0; font-size: 1.25rem;">${store.nombre_tienda}</h3>
                            <small style="color: var(--text-muted);">Por: ${store.usuario ? store.usuario.name : 'Desconocido'}</small>
                        </div>
                    </div>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem; min-height: 3rem;">${store.descripcion || 'Sin descripción disponible.'}</p>
                    <a href="/tiendas/${store.id_tienda || store.id}" class="btn btn-outline" style="width: 100%; text-align: center;">Visitar Tienda</a>
                `;
                grid.appendChild(card);
            });

        } catch (e) {
            console.error(e);
            grid.innerHTML = '<div class="card" style="grid-column: 1/-1; text-align: center; color: #ef4444;">Error al cargar tiendas.</div>';
        }
    });
</script>
@endsection
