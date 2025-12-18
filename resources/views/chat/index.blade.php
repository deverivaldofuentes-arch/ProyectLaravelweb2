@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<h2>Chat</h2>
<input id="msg">
<button onclick="enviar()">Enviar</button>
<div id="res"></div>

<script>
function enviar() {
    axios.post(API_URL + '/chat/responder', {
        mensaje: msg.value
    }, {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    }).then(res => {
        document.getElementById('res').innerText = res.data.respuesta;
    });
}
</script>
@endsection
