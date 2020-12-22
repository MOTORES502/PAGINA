@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Marca {{ $marca->name }}</h1>
        </div>
    </section>

    <!--End Page Title-->
    <section class="recent-tickets-section">
    	<div class="auto-container">
            <div class="sec-title">
                <h2>{{  $marca->name }} / {{ $marca->code }}</h2>
                <div style="vertical-align: middle; align-items: center;">
                    <div style="float: left;">
                        <img width="100%" class="lazyload" data-src="{{ Storage::disk('images')->url($marca->image) }}" alt="{{  $marca->name }}">
                    </div>
                    <br>
                    {!! $marca->description !!}
                </div>  
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="offer-section">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title light centered">
                <h2>Últimos ingresos</h2>
            </div>
            <div class="three-item-carousel owl-carousel owl-theme">
                <!--Offer Block-->
                @foreach ($nuevo_ingreso as $item)
                <div class="offer-block">
                    <div class="inner-box">
                        <div class="image">
                            <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}" title="{{ $item->alt }}">
                                <img alt="{{ $item->alt }}" class="lazyload" data-src="{{ Storage::disk('images')->url($item->image) }}" />
                            </a>
                        </div>
                        <h3>
                            {{ $item->completo }} <br> {{ $item->codigo }}
                        </h3>
                        <div class="lower-box">
                            <div class="plus-box">
                                <span class="icon fa fa-plus"></span>
                                <ul class="tooltip-data">
                                    <li>{{ $item->marca }}</li>
                                    <li>{{ $item->linea }}</li>
                                    <li>{{ $item->version }}</li>
                                    <li>{{ $item->estado }}</li>
                                </ul>
                            </div>
                            <div class="lower-price">{{ $item->oferta ? $item->oferta : $item->precio }}</div>
                            <ul>
                                <li><span class="icon fa fa-road"></span>{{ number_format($item->kilometro, 0, '.', ',') }}</li>
                                <li><span class="icon fa fa-car"></span>{{ $item->combustible }}</li>
                                <li><span class="icon fa fa-clock-o"></span>{{ $item->modelo }}</li>
                                <li><span class="icon fa fa-gear"></span>{{ $item->transmision }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>                    
                </section>
            </div>
        </div>
    </section>

    <!--End Page Title-->
    <section class="inventory-section invent-style-two">
    	<div class="auto-container" id="categorias_carros">
            <!--Styled Pagination-->
            {{ $carros->links() }}
            <!--End Styled Pagination-->
            <hr>
            <div class="row clearfix">
              @foreach ($carros as $vehiculo)
            	<!--Column-->
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<div class="layout-box clearfix">
                    <div class="car-block-two">
                        <div class="inner-box">
                        	<div class="row clearfix">
                            	<div class="image-column col-md-4 col-sm-4 col-xs-12">
                                    <div class="image">
                                        @if ($vehiculo->estado != 'DISPONIBLE')
                                            <div class="ribbon ribbon-top-left"><span>{{ $vehiculo->estado }}</span></div>
                                        @endif
                                        <a href="{{ route('vehiculo', ['slug' => $vehiculo->slug, 'value' => base64_encode($vehiculo->codigo)]) }}" title="{{ $vehiculo->alt }}">
                                          <img alt="{{ $vehiculo->alt }}" class="lazyload" data-src="{{ Storage::disk('images')->url($vehiculo->image) }}" />
                                        </a>
                                    </div>
                                </div>
                                <div class="content-column col-md-8 col-sm-8 col-xs-12">
                                    <h3>
                                        {{ $vehiculo->completo }}
                                    </h3>
                                    <div class="price">{{ $vehiculo->oferta ? $vehiculo->oferta : $vehiculo->precio }}</div>
                                    <div class="info-box">
                                        <ul class="car-info">
                                            <li><span class="fa fa-road icon"></span><span class="info-title">Kms</span>{{ $vehiculo->kilometro }}</li>
                                            <li><span class="icon fa fa-car"></span><span class="info-title">Combustible</span>{{ $vehiculo->combustible }}</li>
                                            <li><span class="icon fa fa-clock-o"></span><span class="info-title">Modelo</span>{{ $vehiculo->modelo }}</li>
                                            <li><span class="fa fa-gears icon"></span><span class="info-title">Transmisión</span>{{ $vehiculo->transmision }}</li>
                                        </ul>
                                    </div>
                                    <div class="lower-box clearfix">
                                    	<!--Btns-->
                                        <div class="btns-box">
                                        	<ul class="btns clearfix">
                                        		<li>{{ $vehiculo->codigo }}</li>
                                            </ul>
                                        </div>
                                        <!--Logos-->
                                        <div class="logos-box">
                                        	<ul class="logos clearfix">
                                            <li class="logo">
                                                <a href="{{ route('marca', ['slug' => str_replace(' ', '_', mb_strtolower($vehiculo->brands_name)), 'value' => base64_encode($vehiculo->brands_id)]) }}" title="{{ $vehiculo->brands_name }}">
                                                    <img width="25%" class="lazyload" data-src="{{ Storage::disk('images')->url($vehiculo->brands_image) }}" alt="{{  $vehiculo->brands_name }}" />
                                                </a>
                                            </li>
                                          </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>              
              @endforeach
            </div>
            <!--Styled Pagination-->
            {{ $carros->links() }}
            <!--End Styled Pagination-->
      </div>
    </section>
@stop

@section('script')
  <script type="text/javascript" src="{{ asset('js/buscar_categoria_carros.js') }}"></script>
@endsection