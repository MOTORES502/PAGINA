@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 style="font-size: 3vw;" class="text-center"><strong>Categoría {{ $sub_categoria->name }}</strong></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-6"><h3 class="mb-3" style="color: #808080;"><strong>Últimos Ingresos</strong></h3></div>
      @if (count($nuevo_ingreso) > 1)
      <div class="col-6 text-right">
        <a class="btn btn-primary mb-3 mr-1" href="#carrusel_categoria" role="button" data-slide="prev">Atrás</a>
        <a class="btn btn-primary mb-3" href="#carrusel_categoria" role="button" data-slide="next">Siguiente</a>
      </div>          
      @endif
      <div class="col-12">
        <div id="carrusel_categoria" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            @foreach ($nuevo_ingreso as $carrusel)
              <div class="{{ $carrusel['numero'] == 0 ? "carousel-item active" : "carousel-item" }}">
                <div class="row">
                  @foreach ($carrusel['vehiculos'] as $vehiculo)
                  <div class="col-md-3 mb-3">
                    <div class="card box">
                        @if ($vehiculo->estado != 'DISPONIBLE')
                            <div class="ribbon ribbon-top-left"><span>{{ $vehiculo->estado }}</span></div>
                        @endif
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
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    @foreach ($array as $item)
    <div class="row">
      <div class="col-12"><hr style="height: 10px; width: 80%; background-color:#343a40;"></div>
      <div class="col-12">
          <div class="row">
            <div class="col-6 text-right">
                <img class="img-fluid" width="10%" alt="{{ $item['marca']->name }}" src="{{ $item['marca']->image }}" />
            </div>
            <div class="col-6 text-left">
                <h2 style="color: #808080;">{{  $item['marca']->name }} / {{ $item['marca']->code }}</h2>
            </div>
          </div>
      </div>
      <div class="col-12">
        <br><br>
        <div class="row">
            @foreach ($item['carros'] as $vehiculo)
            <div class="col-md-3 mb-3">
            <div class="card box">
                @if ($vehiculo->estado != 'DISPONIBLE')
                    <div class="ribbon ribbon-top-left"><span>{{ $vehiculo->estado }}</span></div>
                @endif
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
      </div>
    </div>
    @endforeach
@stop