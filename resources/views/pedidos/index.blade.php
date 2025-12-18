@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
<h2>Mis pedidos</h2>

<script>
axios.get(API_URL + '/pedidos', {
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
}).then(res => console.log(res.data));
</script>
@endsection
