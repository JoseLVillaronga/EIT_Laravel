@include('layouts.header')
<main class="container">
    <h1>Soy una vista</h1>
    {{ $nombre }}
    <hr>
    {{ $numero }}
    <hr>
    @if($numero < 100)
        El numero es menor a 100
    @else
        El numero no es menor a 100
    @endif
    <ul>
        @foreach($datos as $clave => $elemento)
            <li>{{$elemento}}</li>
        @endforeach
    </ul>
</main>
@include('layouts.footer')
