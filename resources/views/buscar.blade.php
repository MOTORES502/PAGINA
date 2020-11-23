@extends('layouts.master')

@section('content')
<input type="hidden" id="search" value="{{ $search }}">
@if ($existe)
<!--Popular Cars Section-->
<section class="recent-tickets-section">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title">
            <h2>{{ $titulo }}</h2>
        </div>

        <!--End Sec Title-->
        <div id="carros_buscados">
            <!--Styled Pagination-->
            {{ $data->links() }}
            <!--End Styled Pagination-->

            <br>
            <!--Car Block-->
            @foreach($data->chunk(4) as $bloque)
                <div class="row clearfix">
                @foreach ($bloque as $item)
                    <div class="car-block col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                            <img alt="{{ $item->alt }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                            </a>
                            <div class="price">{{ $item->precio }}</div>
                        </div>
                        <h3>
                            <a  href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                            {{ $item->completo }} <br> {{ $item->codigo }}
                            </a>
                        </h3>
                        <div class="lower-box">
                            <ul class="car-info">
                                <li><span class="icon fa fa-road"></span>{{ number_format($item->kilometro, 0, '.', ',') }}</li>
                                <li><span class="icon fa fa-car"></span>{{ $item->combustible }}</li>
                                <br>
                                <li><span class="icon fa fa-clock-o"></span>{{ $item->modelo }}</li>
                            </ul>
                        </div>
                        </div>
                    </div>            
                @endforeach
                </div>
            @endforeach
            
            <!--Styled Pagination-->
            {{ $data->links() }}
            <!--End Styled Pagination-->
        </div>
    </div>
</section>
<!--End Popular Cars Section-->
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

@section('script')
  <script type="text/javascript" src="{{ asset('js/paginador_buscar.js') }}"></script>
@endsection