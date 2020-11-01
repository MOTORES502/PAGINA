@extends('layouts.master')

@section('content')
@if ($existe)
    <br><br>
    <div class="row">
        <div class="col-12">
            <h1 style="font-size: 3vw;" class="text-center"><strong>{{ $titulo }}</strong></h1>
        </div>
    </div>   
    <div class=" py-4">
        <nav class="d-flex justify-content-end" aria-label="...">
            {{ $data->links() }}
        </nav> 
    </div> 
    <div class="row">
        @foreach ($data as $vehiculo)
        <div class="col-md-3 mb-3">
            <div class="card">
                <a href="{{ route('vehiculo', ['slug' => $vehiculo->slug, 'value' => base64_encode($vehiculo->codigo)]) }}">
                <img class="img-fluid" alt="{{ $vehiculo->alt }}" src="{{ asset('img/encima_motores502.png') }}" style="background-blend-mode: normal; background-image: url({{ $vehiculo->image }}); background-size: 100% 100%; background-repeat: no-repeat;" />
                </a>
                <div class="card-body">
                <h4 class="card-title">{{ $vehiculo->codigo }}</h4>
                <p class="card-text">
                    <ul>
                        <li>{{ $vehiculo->marca }}</li>
                        <li>{{ $vehiculo->linea }}</li>
                        <li>{{ $vehiculo->modelo }}</li>
                        <li>{{ $vehiculo->kilometro }}</li>
                        <li>{{ $vehiculo->oferta ? $vehiculo->oferta : $vehiculo->precio }}</li>
                    </ul>
                </p>
                </div>
            </div>
        </div>                      
        @endforeach
    </div>   
    <div class=" py-4">
        <nav class="d-flex justify-content-end" aria-label="...">
            {{ $data->links() }}
        </nav> 
    </div>                       
</div> 
@else
    <br><br>
    <div class="row">
        <div class="col-12">
            <div class="jumbotron image-no-result">
                <h1 class="display-4">¡Lo Sentimos!</h1>
                <p class="lead">En nuestra base de datos no se encuentran {{ $titulo }} registrados.</p>
                <hr class="my-4">
                <p>Le invitamos a seguir buscando más información.</p>
                <p class="lead text-center">
                    <img src="{{ asset('img/logo_s_fondo_mrm.png') }}" alt="Motores 502">
                    <br>
                    <a class="btn btn-info btn-lg" href="{{ route('home') }}" role="button">Regresar a la página de inicio</a>
                </p>
            </div>
        </div>
    </div>  
    <br><br>  
@endif
@stop