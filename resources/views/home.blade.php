@extends('layouts.master')

@section('content')
    <div class="row">
      <div class="col-12">
        <div
          id="carouselExampleIndicators"
          class="carousel slide carousel-fade"
          style="height: 450px"
          data-ride="carousel"
        >
            <div
              class="carousel-item active"
              style="
                background-image: url('https://www.motores502.com/img/home-banner/b119sq.jpg');
                height: 65vh;
              "
            ></div>
            <div
              class="carousel-item"
              style="
                background-image: url('https://www.motores502.com/img/home-banner/b121sq.jpg');
                height: 65vh;
              "
            ></div>
            <div
              class="carousel-item"
              style="
                background-image: url('https://www.motores502.com/img/home-banner/b120sq.jpg');
                height: 65vh;
              "
            ></div>

          <a
            class="carousel-control-prev"
            href="#carouselExampleIndicators"
            role="button"
            data-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a
            class="carousel-control-next"
            href="#carouselExampleIndicators"
            role="button"
            data-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
    <div class="row">
      @foreach ($ofertas as $item)
      <div class="col-md-3 mb-3">
        <div class="card">       
          <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
            <img class="img-fluid" alt="{{ $item->alt }}" src="{{ asset('img/encima_motores502.png') }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" />
          </a>
          <div class="card-body">
            <h4 class="card-title">{{ $item->codigo }}</h4>
            <p class="card-text">
                <ul>
                    <li>{{ $item->marca }}</li>
                    <li>{{ $item->linea }}</li>
                    <li>{{ $item->modelo }}</li>
                    <li>{{ $item->kilometro }}</li>
                    <li>{{ $item->precio }}</li>
                </ul>
            </p>
          </div>
        </div>
      </div>          
      @endforeach
      <div class="col-12">
        <hr />
      </div>
    </div>
    @foreach ($carros as $key => $item)
    <div class="row">
      <div class="col-6"><h3 class="mb-3" style="color: #808080;"><strong>categoría | {{ $item['nombre'] }}</strong></h3></div>
      @if (count($item['carrusel']) > 1)
      <div class="col-6 text-right">
        <a class="btn btn-primary mb-3 mr-1" style="color: white;" href="{{ "#carrusel_carros".$key }}" role="button" data-slide="prev">Atrás</a>
        <a class="btn btn-primary mb-3" href="{{ "#carrusel_carros".$key }}" role="button" data-slide="next">Siguiente</a>
      </div>
      @endif
      <div class="col-12">
        <div id="{{ "carrusel_carros".$key }}" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            @foreach ($item['carrusel'] as $carrusel)
              <div class="{{ $carrusel['numero'] == 0 ? "carousel-item active" : "carousel-item" }}">
                <div class="row">
                  @foreach ($carrusel['vehiculos'] as $vehiculo)
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
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    @endforeach
@stop