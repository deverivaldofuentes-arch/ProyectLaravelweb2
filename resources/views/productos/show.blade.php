@extends('layouts.app')

@section('title', 'Detalle del Producto')

@section('content')
<div class="container" style="padding-top: 2rem;">
    <!-- Breadcrumb or Back Button -->
    <a href="/productos" class="btn btn-outline" style="margin-bottom: 2rem; display: inline-flex; align-items: center; gap: 0.5rem;">
        &larr; Volver al Catálogo
    </a>

    <div id="product-detail-container" class="card" style="min-height: 400px; display: flex; align-items: center; justify-content: center;">
        <span style="color: var(--text-muted);">Cargando detalle del producto...</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        // Extract ID from URL: /productos/{id}
        const pathParts = window.location.pathname.split('/');
        const productId = pathParts[pathParts.length - 1]; // standard method if URL is clean

        const container = document.getElementById('product-detail-container');
        
        try {
            const res = await axios.get(`/api/productos/${productId}`);
            const product = res.data.data;

            if (!product) throw new Error('Producto no encontrado');

            container.style.display = 'block'; // Reset flex centering
            container.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in">
                    <div style="background: #1e293b; border-radius: 8px; overflow: hidden; height: 400px; display: flex; align-items: center; justify-content: center;">
                         ${product.imagen_url ? `<img src="${product.imagen_url}" alt="${product.nombre_producto}" style="width: 100%; height: 100%; object-fit: contain;">` : '<span style="font-size: 4rem;">📦</span>'}
                    </div>
                    
                    <div class="flex flex-col justify-center">
                        <div class="mb-4">
                            <span style="background: rgba(99, 102, 241, 0.2); color: var(--primary); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600;">
                                ${product.categoria ? product.categoria.nombre_categoria : 'Sin Categoría'}
                            </span>
                        </div>
                        
                        <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">${product.nombre_producto}</h1>
                        
                        <p style="font-size: 1.5rem; font-weight: 700; color: var(--secondary); margin-bottom: 1.5rem;">
                            $${product.precio}
                        </p>
                        
                        <p style="color: var(--text-muted); margin-bottom: 2rem; line-height: 1.8;">
                            ${product.descripcion || 'Sin descripción detallada.'}
                        </p>

                        <div class="flex items-center gap-4">
                            <div style="width: 100px;">
                                <input type="number" id="quantity" class="input" value="1" min="1" max="${product.stock}" style="text-align: center;">
                            </div>
                            
                            ${product.stock > 0 
                                ? `<button onclick="addToCart('${product.id_producto || product.id}')" class="btn btn-primary" style="flex: 1;">Agregar al Carrito</button>` 
                                : `<button class="btn btn-outline" disabled style="flex: 1; opacity: 0.5;">Agotado</button>`
                            }
                        </div>
                        <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                            Vendido por: <strong>${product.tienda ? product.tienda.nombre_tienda : 'Tienda Oficial'}</strong>
                        </p>
                    </div>
                </div>
            `;

        } catch (e) {
            console.error(e);
            container.innerHTML = '<div style="text-align: center; color: #ef4444;">Error al cargar el producto o no existe.</div>';
        }
    });

    window.addToCart = async (id) => {
        const qty = document.getElementById('quantity').value;
        const btn = document.querySelector('button.btn-primary'); // risky selector but works here
        
        if (!localStorage.getItem('token')) {
            alert('Debes iniciar sesión para comprar.');
            window.location.href = '/login';
            return;
        }

        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Agregando...';

        try {
            await axios.post('/api/carrito/detalle', {
                id_producto: id,
                cantidad: parseInt(qty)
            });
            
            btn.innerHTML = '¡Agregado!';
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }, 2000);
            
            // Optionally update cart count in navbar
            // updateAuthUI(); // If this function was exported or available globally
            alert('Producto agregado al carrito exitosamente');

        } catch (e) {
            console.error(e);
            btn.disabled = false;
            btn.innerHTML = originalText;
            alert('Error al agregar al carrito: ' + (e.response?.data?.message || e.message));
        }
    };
</script>
@endsection
