<?php

use Illuminate\Support\Facades\Route;


Route::get('/', fn () => view('home'))->name('home');

// Auth
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::get('/register', fn () => view('auth.register'))->name('register');

// Perfil
Route::get('/perfil', fn () => view('profile.index'))->name('profile');

// Tiendas
Route::get('/tiendas', fn () => view('tiendas.index'))->name('tiendas.index');
Route::get('/tiendas/{id}', fn () => view('tiendas.show'))->name('tiendas.show');

// Productos
Route::get('/productos', fn () => view('productos.index'))->name('productos.index');
Route::get('/productos/{id}', fn () => view('productos.show'))->name('productos.show');

// Carrito
Route::get('/carrito', fn () => view('carrito.index'))->name('carrito');

// Pedidos
Route::get('/pedidos', fn () => view('pedidos.index'))->name('pedidos.index');
Route::get('/pedidos/{id}', fn () => view('pedidos.show'))->name('pedidos.show');

// Chat
Route::get('/chat', fn () => view('chat.index'))->name('chat');
