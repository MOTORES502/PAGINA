@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>multas de tránsito</h1>
        </div> 
    </section>
    <!--End Page Title-->

    <section class="Category-display">
        <div class="auto-container">
            @foreach ($multas as $item)
                <div class="row clearfix">
                    <div class="client-column col-md-12 col-sm-12 col-xs-12 text-center">
                        <hr>
                        <h2>{{ $item['titulo'] }}</h2>
                        <hr>
                    </div>
                </div>
                <div class="row clearfix">
                    @if (count($item['dato']) == 1)
                        @foreach ($item['dato'] as $valor)
                            <div class="client-column col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <div class="image">
                                    <a target="_blank" rel="noopener noreferrer" href="{{ $valor['link'] }}" title="{{ $valor['nombre'] }}">
                                        <img class="lazyload" data-ll-status="loaded" width="200" height="200" data-src="{{ asset('img/multas/'.$valor['logo']) }}" alt="{{ $valor['nombre'] }}">
                                        <h4>{{ $valor['nombre'] }}</h4>                                
                                    </a>
                                </div>
                            </div>
                        @endforeach                        
                    @else 
                        @foreach ($item['dato'] as $valor)
                            <div class="client-column col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center" style="padding-bottom: 25px;">
                                <div class="image">
                                    <a target="_blank" rel="noopener noreferrer" href="{{ $valor['link'] }}" title="{{ $valor['nombre'] }}">
                                        <img class="lazyload" data-ll-status="loaded" width="200" height="200" data-src="{{ asset('img/multas/'.$valor['logo']) }}" alt="{{ $valor['nombre'] }}">
                                        <h4>{{ $valor['nombre'] }}</h4>                                
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div> 
    </section>
@stop