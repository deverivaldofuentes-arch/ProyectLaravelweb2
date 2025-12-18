@extends('layouts.app')

@section('title', 'Productos - NovaMarket')

@section('content')
<div class="container" style="padding-top: 2rem;">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar Filters -->
        <aside style="width: 100%; max-width: 250px;">
            <div class="card">
                <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">Categorías</h3>
                <ul id="categories-list" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <li><button onclick="filterByCategory(null)" class="btn btn-outline" style="width: 100%; text-align: left; border: none; padding-left: 0;">Todas</button></li>
                    <!-- Categories injected here -->
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div style="flex: 1;">
            <div class="flex justify-between items-center mb-4">
                <h2 style="font-size: 1.5rem; margin: 0;">Catálogo</h2>
                <div style="position: relative; width: 300px;">
                    <input type="text" id="search-input" class="input" placeholder="Buscar productos..." oninput="debounceSearch(event)">
                </div>
            </div>

            <div id="products-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Products injected here -->
                <div class="card" style="grid-column: 1/-1; text-align: center;">Cargando productos...</div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentCategory = null;
    let currentSearch = '';

    document.addEventListener('DOMContentLoaded', () => {
        loadCategories();
        loadProducts();
    });

    async function loadCategories() {
        try {
            const res = await axios.get('/api/categorias');
            const categories = res.data.data || res.data; // Adjust based on API structure
            
            const list = document.getElementById('categories-list');
            // Keep "Todas" button
            list.innerHTML = `<li><button onclick="filterByCategory(null)" class="btn btn-outline" style="width: 100%; text-align: left; border: none; padding-left: 0; color: var(--primary);">Todas</button></li>`;

            categories.forEach(cat => {
                const li = document.createElement('li');
                li.innerHTML = `<button onclick="filterByCategory('${cat.id_categoria}')" class="btn btn-outline" style="width: 100%; text-align: left; border: none; padding-left: 0;">${cat.nombre_categoria || cat.nombre}</button>`;
                list.appendChild(li);
            });
        } catch (e) {
            console.error('Error loading categories', e);
        }
    }

    async function loadProducts() {
        const grid = document.getElementById('products-grid');
        grid.innerHTML = '<div class="card" style="grid-column: 1/-1; text-align: center;">Cargando...</div>';

        try {
            const params = {};
            if (currentCategory) params.id_categoria = currentCategory;
            if (currentSearch) params.nombre = currentSearch;

            const res = await axios.get('/api/productos', { params });
            const products = res.data.data;

            grid.innerHTML = '';
            
            if (products.length === 0) {
                grid.innerHTML = '<div class="card" style="grid-column: 1/-1; text-align: center;">No se encontraron productos.</div>';
                return;
            }

            products.forEach(p => {
                const div = document.createElement('div');
                div.className = 'card animate-fade-in';
                div.innerHTML = `
                    <div style="height: 180px; background: #1e293b; border-radius: 8px; margin-bottom: 1rem; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                         ${p.imagen_url ? `<img src="${p.imagen_url}" alt="${p.nombre_producto}" style="width: 100%; height: 100%; object-fit: cover;">` : '<span style="font-size: 2rem;">📦</span>'}
                    </div>
                    <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">${p.nombre_producto}</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${p.descripcion || ''}</p>
                    <div class="flex justify-between items-center">
                        <span style="font-weight: 700; color: var(--secondary); font-size: 1.1rem;">$${p.precio}</span>
                        <a href="/productos/${p.id_producto || p.id}" class="btn btn-primary" style="padding: 0.5rem 0.75rem; font-size: 0.8rem;">Ver Detalles</a>
                    </div>
                `;
                grid.appendChild(div);
            });

        } catch (e) {
            console.error('Error loading products', e);
            grid.innerHTML = '<div class="card" style="grid-column: 1/-1; text-align: center; color: #ef4444;">Error al cargar productos.</div>';
        }
    }

    window.filterByCategory = (id) => {
        currentCategory = id;
        loadProducts();
    };

    let timeout;
    window.debounceSearch = (e) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            currentSearch = e.target.value;
            loadProducts();
        }, 500);
    };
</script>
@endsection
