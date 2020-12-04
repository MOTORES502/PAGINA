@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Comparar vehículo</h1>
        </div>
    </section>
    <!--End Page Title--> 


    <!--Cars Compare Section-->
    <section class="cars-compare-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Options Cars Column-->
                <div class="options-cars-column col-sm-12">
                    <form action="{{ route('comparar.store') }}" method="post">
                        @csrf
                        <div class="row clearfix">
                            <!--Car Block-->
                            <div class="car-option-block col-md-6 col-sm-6 col-xs-12">
                                <div class="inner-box">
                                    <h2>Seleccionar el primer vehículo</h2>
                                    <div class="icon-box" id="icono_carro_one">
                                        <span class="icon flaticon-cabriolet"></span>
                                    </div>

                                    <div class="icon-box" id="imagen_carro_one">
                                        <span class="icon flaticon-cabriolet"></span>
                                    </div>

                                    <!--Calculate Form-->
                                    <div class="default-form">
                                        <div class="form-group">
                                            <select id="marca_id_one" name="marca_id_one" class="form-control js-example-basic-single">
                                                <option value="">Seleccione marca</option>
                                                @foreach ($marcas as $item)
                                                    <option value="0" disabled><strong>{{ $item->name }}</strong></option>
                                                    @foreach ($item->brands as $marca)
                                                        <option value="{{ $marca->id }}"><b>{{ $marca->name }}</b></option>
                                                    @endforeach
                                                @endforeach
                                            </select>   
                                        </div>
                                        <div class="form-group">
                                            <select id="linea_id_one" name="linea_id_one" class="form-control js-example-basic-single">
                                                <option value="">Seleccione línea</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select id="codigo_id_one" name="codigo_id_one" class="form-control js-example-basic-single">
                                                <option value="">Seleccione un código de vehículo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Car Block-->
                            <div class="car-option-block col-md-6 col-sm-6 col-xs-12">
                                <div class="inner-box">
                                    <h2>Seleccionar el segundo vehículo</h2>
                                    <div class="icon-box" id="icono_carro_two">
                                        <span class="icon flaticon-cabriolet"></span>
                                    </div>

                                    <div class="icon-box" id="imagen_carro_two">
                                        <span class="icon flaticon-cabriolet"></span>
                                    </div>

                                    <!--Calculate Form-->
                                    <div class="default-form">
                                        <div class="form-group">
                                            <select id="marca_id_two" name="marca_id_two" class="form-control js-example-basic-single">
                                                <option value="">Seleccione marca</option>
                                                @foreach ($marcas as $item)
                                                    <option value="0" disabled><strong>{{ $item->name }}</strong></option>
                                                    @foreach ($item->brands as $marca)
                                                        <option value="{{ $marca->id }}"><b>{{ $marca->name }}</b></option>
                                                    @endforeach
                                                @endforeach
                                            </select>  
                                        </div>
                                        <div class="form-group">
                                            <select id="linea_id_two" name="linea_id_two" class="form-control js-example-basic-single">
                                                <option value="">Seleccione línea</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select id="codigo_id_two" name="codigo_id_two" class="form-control js-example-basic-single">
                                                <option value="">Seleccione un código de vehículo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="theme-btn btn-style-one compare-btn">Comparar Vehículo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--End Cars Compare Section-->    

    <!--Comparison Section-->
    <section class="comparison-section grey-bg">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title centered">
                <h2>Últimas comparaciones</h2>
            </div>

            @foreach ($carros->chunk(2) as $bloque)
            <div class="row clearfix">
                @foreach ($bloque as $item)
                <!--Comparison Block-->
                <div class="comparison-block col-md-6 col-sm-12 col-xs-12">
                    <div class="inner-box">
                        <a href="{{ route('comparar.compracion_historica', ['slug_uno' => $item->slug_one, 'slug_dos' => $item->slug_two, 'comparacion' => $item->id]) }}" class="overlay-link"></a>
                        <div class="vs">Vs</div>
                        <div class="clearfix">
                            <div class="inner-car-block col-md-6 col-sm-6 col-xs-12">
                                <div class="inner">
                                    <div class="image">
                                        <img alt="{{ $item->alt_one }}" style="background-blend-mode: normal; background-image: url({{ $item->image_one }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                                    </div>
                                    <div class="lower-box">
                                        <div class="car-name">{{ $item->completo_one }} <br> {{ $item->code_one }}</div>
                                        <div class="price">{{ $item->oferta_one ? $item->oferta_one : $item->precio_one }}</div>
                                        <div class="overlay-text">{{ $item->completo_one }} <br> {{ $item->code_one }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="inner-car-block col-md-6 col-sm-6 col-xs-12">
                                <div class="inner">
                                    <div class="image">
                                        <img alt="{{ $item->alt_two }}" style="background-blend-mode: normal; background-image: url({{ $item->image_two }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                                    </div>
                                    <div class="lower-box">
                                        <div class="car-name">{{ $item->completo_two }} <br> {{ $item->code_two }}</div>
                                        <div class="price">{{ $item->oferta_two ? $item->oferta_two : $item->precio_two }}</div>
                                        <div class="overlay-text">{{ $item->completo_two }} <br> {{ $item->code_two }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach                
            </div>
            @endforeach
        </div>
    </section>
    <!--End Comparison Section-->
@stop