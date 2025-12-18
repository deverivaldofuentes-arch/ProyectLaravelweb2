@extends('layouts.app')

@section('title', 'Inicio - NovaMarket')

@section('content')
<div class="hero">
    <div class="container animate-fade-in">
        <h1>El Futuro del Comercio Online</h1>
        <p>Descubre productos exclusivos con la mejor calidad y precios del mercado. Una experiencia de compra única te espera.</p>
        <div class="flex justify-center gap-4">
            <a href="/productos" class="btn btn-primary">Ver Productos</a>
            <a href="/tiendas" class="btn btn-outline">Explorar Tiendas</a>
        </div>
    </div>
</div>

<div class="container" style="padding-bottom: 4rem;">
    <h2 class="mb-4">Productos Destacados</h2>
    <div id="featured-products" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Products will be loaded here -->
        <div class="card">
            <p class="text-muted">Cargando productos...</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await axios.get('/api/productos');
            const products = response.data; // Adjust based on actual API response structure (e.g. data.data)
            
            // Assuming pagination or array
            const list = Array.isArray(products) ? products : (products.data || []);
            
            const container = document.getElementById('featured-products');
            container.innerHTML = '';

            if (list.length === 0) {
                container.innerHTML = '<p class="text-muted">No hay productos destacados por ahora.</p>';
            }

            list.slice(0, 6).forEach(product => {
                const card = document.createElement('div');
                card.className = 'card animate-fade-in';
                card.innerHTML = `
                    <div style="height: 200px; background: #1e293b; border-radius: 8px; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                         ${product.imagen ? `<img src="${product.imagen}" alt="${product.nombre}" style="width: 100%; height: 100%; object-fit: cover;">` : '<span style="font-size: 2rem;">📦</span>'}
                    </div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">${product.nombre}</h3>
                    <p style="color: var(--text-muted); margin-bottom: 1rem; font-size: 0.9rem;">${product.descripcion || 'Sin descripción'}</p>
                    <div class="flex justify-between items-center">
                        <span style="font-weight: 700; color: var(--primary); font-size: 1.2rem;">$${product.precio}</span>
                        <a href="/productos/${product.id}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Ver</a>
                    </div>
                `;
                container.appendChild(card);
            });

        } catch (error) {
            console.error('Error fetching products:', error);
            document.getElementById('featured-products').innerHTML = '<p style="color: #ef4444;">Error al cargar productos.</p>';
        }
    });
</script>
@endsection
