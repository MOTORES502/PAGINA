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
                        <img width="100%" src="{{ $marca->image }}" alt="{{  $marca->name }}">
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
                            <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                                <img alt="{{ $item->alt }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                            </a>
                        </div>
                        <h3>
                            <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                            {{ $item->completo }} <br> {{ $item->codigo }}
                            </a>
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
    	<div class="auto-container">
        @foreach ($carros as $item)
          <div class="sec-title">
              <h2>{{  $item['subs']->name }}</h2>
          </div>
          @foreach ($item['carros']->chunk(4) as $bloque)
            <div class="row clearfix">
              @foreach ($bloque as $vehiculo)
            	<!--Column-->
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<div class="layout-box clearfix">
                    <div class="car-block-two">
                        <div class="inner-box">
                        	<div class="row clearfix">
                            	<div class="image-column col-md-4 col-sm-4 col-xs-12">
                                    <div class="image">
                                        <a href="{{ route('vehiculo', ['slug' => $vehiculo->slug, 'value' => base64_encode($vehiculo->codigo)]) }}">
                                          <img alt="{{ $vehiculo->alt }}" src="{{ asset('img/encima_motores502.png') }}" style="background-blend-mode: normal; background-image: url({{ $vehiculo->image }}); background-size: 100% 100%; background-repeat: no-repeat;" />
                                        </a>
                                    </div>
                                </div>
                                <div class="content-column col-md-8 col-sm-8 col-xs-12">
                                    <h3><a href="inventory-single.html">{{ $vehiculo->completo }}</a></h3>
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
                                        		<li><a href="javascript:" class="theme-btn btn-style-four">{{ $vehiculo->codigo }}</a></li>
                                            </ul>
                                        </div>
                                        <!--Logos-->
                                        <div class="logos-box">
                                        	<ul class="logos clearfix">
                                            <li class="logo"><a href="javascript:"><img width="25%" src="{{ $marca->image }}" alt="{{  $marca->name }}"></a></li>
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
          @endforeach
        @endforeach
      </div>
    </section>
@stop