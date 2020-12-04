@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Comparar vehículo</h1>
        </div>
    </section>
    <!--End Page Title--> 

    <!--Cars Comparison Section-->
    <section class="cars-comparison-section">
        <div class="auto-container">
            <div class="comparison-box">
                <!--Compare Outer-->
                <div class="compare-outer">

                    <div class="car-compare-header">
                        <div class="header-outer clearfix">

                            <!--Title Column-->
                            <div class="title-column">
                                <h2>Comparación</h2>
                                <h3>Características</h3>
                            </div>

                            <!--Car Column-->
                            <div class="car-column">
                                <div class="inner">
                                    <figure class="image"><img alt="{{ $image_one->concat }}" style="background-blend-mode: normal; background-image: url({{ $image_one->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" /></figure>
                                    <div class="title-box">
                                        <h4>{{ $vehiculo_one->nombre_completo }}</h4>
                                        <div class="price">{{ $vehiculo_one->oferta ? $vehiculo_one->oferta : $vehiculo_one->oferta }}</div>
                                    </div>
                                </div>
                            </div>
                            <!--Car Column-->
                            <div class="car-column">
                                <div class="inner">
                                    <figure class="image"><img alt="{{ $image_two->concat }}" style="background-blend-mode: normal; background-image: url({{ $image_two->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" /></figure>
                                    <div class="title-box">
                                        <h4>{{ $vehiculo_two->nombre_completo }}</h4>
                                        <div class="price">{{ $vehiculo_two->oferta ? $vehiculo_two->oferta : $vehiculo_two->oferta }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Info Block-->
                    <div class="car-info-block">
                        <div class="info-inner">
                            <div class="info-row clearfix">
                                <div class="info-col">Fabricación</div>
                                <div class="info-col">{{ $general_one->fabrications }}</div>
                                <div class="info-col">{{ $general_two->fabrications }}</div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="info-col">Transmisión</div>
                                <div class="info-col">{{ $general_one->transmisions }}</div>
                                <div class="info-col">{{ $general_two->transmisions }}</div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="info-col">Total Kilometros</div>
                                <div class="info-col">{{ $vehiculo_one->mileage }}Km’s</div>
                                <div class="info-col">{{ $vehiculo_two->mileage }}Km’s</div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="info-col">Tracción</div>
                                <div class="info-col">{{ $general_one->tractions }}</div>
                                <div class="info-col">{{ $general_two->tractions }}</div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="info-col">Combustible</div>
                                <div class="info-col">{{ $vehiculo_one->fuels }}</div>
                                <div class="info-col">{{ $vehiculo_two->fuels }}</div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="info-col">Rendimiento</div>
                                <div class="info-col">{{ $general_one->yields }} kmpl</div>
                                <div class="info-col">{{ $general_two->yields }} kmpl</div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="info-col">Color</div>
                                <div class="info-col">{{ $vehiculo_one->colors }}</div>
                                <div class="info-col">{{ $vehiculo_two->colors }}</div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="info-col">Estado</div>
                                <div class="info-col">{{ $vehiculo_one->estado }}</div>
                                <div class="info-col">{{ $vehiculo_two->estado }}</div>
                            </div>
                        </div>
                    </div>

                    <!--Info Block-->
                    <div class="car-info-block">
                        <h3>Ingeniería</h3>
                        <div class="info-inner">
                            <div class="info-row clearfix">
                                <div class="info-col">Descripción</div>
                                <div class="info-col">{!! $general_one->description !!}</div>
                                <div class="info-col">{!! $general_two->description !!}</div>
                            </div>
                        </div>
                    </div>

                    <!--Info Block-->
                    <div class="car-info-block">
                        <h3>Comfort</h3>
                        <div class="info-inner">
                            <div class="info-row clearfix">
                                <div class="info-col">Descripción</div>
                                <div class="info-col">{!! $comfort_one->description !!}</div>
                                <div class="info-col">{!! $comfort_two->description !!}</div>
                            </div>
                        </div>
                    </div>

                    <!--Info Block-->
                    <div class="car-info-block">
                        <h3>Protección</h3>
                        <div class="info-inner">
                            <div class="info-row clearfix">
                                <div class="info-col">Descripción</div>
                                <div class="info-col">{!! $seguridad_one->description !!}</div>
                                <div class="info-col">{!! $seguridad_two->description !!}</div>
                            </div>
                        </div>
                    </div>

                    <!--Info Block-->
                    <div class="car-info-block">
                        <h3>Extras</h3>
                        <div class="info-inner">
                            <div class="info-row clearfix">
                                <div class="info-col">Diferencias únicas</div>
                                <div class="info-col">
                                    @foreach ($diferencia_one as $item)
                                        <span class="fa fa-check"></span> {{ $item->name }}
                                        <br>
                                    @endforeach
                                </div>
                                <div class="info-col">
                                    @foreach ($diferencia_two as $item)
                                        <span class="fa fa-check"></span> {{ $item->name }}
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="info-col">Descripción</div>
                                <div class="info-col">{!! $extra_one->description !!}</div>
                                <div class="info-col">{!! $extra_two->description !!}</div>
                            </div>
                        </div>
                    </div>

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