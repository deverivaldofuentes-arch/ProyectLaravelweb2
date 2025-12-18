@extends('layouts.app')

@section('title', 'Carrito')

@section('content')
<h2>Carrito</h2>
<div id="carrito"></div>

<script>
axios.get(API_URL + '/carrito', {
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
}).then(res => {
    console.log(res.data);
});
</script>
@endsection
