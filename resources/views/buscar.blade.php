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
                            <a href="{{ route('vehiculo_buscar', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                            <img alt="{{ $item->alt }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                            </a>
                            <div class="price">{{ $item->precio }}</div>
                        </div>
                        <h3>
                            <a  href="{{ route('vehiculo_buscar', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
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
    <section class="error-section" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
    	<div class="auto-container">
        	<div class="inner-section">
                <h2>{{ "No pudimos encontrar vehículos con las siguientes especficaciones $titulo" }}</h2>
                <div class="text">Te invitamos a que sigas navegando en nuestra página</div>
            </div>
        </div>
    </section>
    <!--End Error Section-->
@endif
@stop

@section('script')
  <script type="text/javascript" src="{{ asset('js/paginador_buscar.js') }}"></script>
@endsection