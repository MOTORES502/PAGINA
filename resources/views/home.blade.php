@extends('layouts.master')

@section('content')

    <!--Main Slider-->
    <section class="main-slider">
        <div class="rev_slider_wrapper fullwidthbanner-container"  id="rev_slider_one_wrapper" data-source="gallery">
            <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
                <ul>
                    <li data-description="Slide Description" data-easein="default" data-easeout="default" data-fsmasterspeed="1500" data-fsslotamount="7" data-fstransition="fade" data-hideafterloop="0" data-hideslideonmobile="off" data-index="rs-1687" data-masterspeed="default" data-param1="" data-param10="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-rotate="0" data-saveperformance="off" data-slotamount="default" data-thumb="images/main-slider/image-1.jpg" data-title="Slide Title" data-transition="parallaxvertical">
                        <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="10" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="" src="{{ asset('template_new/images/main-slider/image-1.jpg') }}">
                    </li>
                    
                    <li data-description="Slide Description" data-easein="default" data-easeout="default" data-fsmasterspeed="1500" data-fsslotamount="7" data-fstransition="fade" data-hideafterloop="0" data-hideslideonmobile="off" data-index="rs-1688" data-masterspeed="default" data-param1="" data-param10="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-rotate="0" data-saveperformance="off" data-slotamount="default" data-thumb="images/main-slider/image-2.jpg" data-title="Slide Title" data-transition="parallaxvertical">
                        <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="10" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="" src="{{ asset('template_new/images/main-slider/image-2.jpg') }}">
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Main Slider-->

    <!--Car Search Form-->
    <div class="car-search-form">
        <div class="container">
            <div class="inner-section">
    <form action="{{ route('buscar.buscador_combo') }}" method="post">
        @csrf
        <div class="row clearfix">
            <div class="column col-lg-5 col-md-12 col-sm-12 col-xs-12">
                <div class="row clearfix">
                    <!--Form Group-->
                    <div class="form-group col-md-6">
                        <select id="marca_id" name="marca_id" class="form-control js-example-basic-single">
                            <option value="">Seleccione marca</option>
                        @foreach ($marcas as $item)
                            <option value="{{ route('lineas', $item->id) }}">{{ $item->name }}</option>
                        @endforeach
                        </select>
                    </div>

                    <!--Form Group-->
                    <div class="form-group col-md-6">
                        <select id="linea_id" name="linea_id" class="form-control js-example-basic-single">
                            <option value="">Seleccione línea</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="column col-lg-5 col-md-12 col-sm-12 col-xs-12">
                <div class="row clearfix">
                    <!--Form Group-->
                    <div class="form-group col-md-6">
                        <select name="precio_minimo" class="form-control js-example-basic-single">
                            <option value="">Seleccione el precio mínimo</option>
                            @foreach ($arra_precio_bajo as $item)
                                <option value="{{ $item['numero'] }}">{{ $item['numero_formato'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--Form Group-->
                    <div class="form-group col-md-6">
                        <select name="precio_maximo" class="form-control js-example-basic-single">
                            <option value="">Seleccione el precio máximo</option>
                            @foreach ($arra_precio_alto as $item)
                                <option value="{{ $item['numero'] }}">{{ $item['numero_formato'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="form-group col-md-2">
                <button id="buscador" class="theme-btn search-btn" type="submit" name="submit-form">Buscar</button>
            </div>
        </div>
    </form>         
            </div>
        </div>
    </div>
    <!--End Car Search Form-->

    <!--Popular Cars Section Two-->
    <section class="Category-display">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title centered">
                <h2>Categorias</h2>
            </div>
            <div class="allcategory">
                <div id="categorias_paginas" class="content">
                    <div class="row clearfix">
                        @foreach ($subs as $sub)
                            <div class="body-block col-md-3 col-sm-4 col-xs-12">
                                <div class="inner-box">
                                    <a href="{{ route('categoria', ['slug' => str_replace(' ', '_', mb_strtolower($sub->name)), 'value' => base64_encode($sub->id)]) }}" class="link-box">
                                    <div class="icon-box">
                                        <img src="{{ $sub->icon ? $sub->icon : asset('template_new/images/icons/car-icons/1.png') }}" alt="{{ $sub->name }}">
                                    </div>
                                    <div class="text">{{ $sub->name }} ({{ $sub->cantidad }})</div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--Styled Pagination-->
                    {{ $subs->appends(['carros' => $carros->currentPage()])->links() }}
                    <!--End Styled Pagination-->      
                </div>
            </div>
        </div>
    </section>
    <!--End Popular Cars Section Two-->

    <!--Offer Section-->
    <section class="offer-section">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title light centered">
                <h2>Ofertas Especiales</h2>
            </div>
            <div class="three-item-carousel owl-carousel owl-theme">
                <!--Offer Block-->
                @foreach ($ofertas as $item)
                <div class="offer-block">
                    <div class="inner-box">
                        <div class="image">
                            <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                                <img alt="{{ $item->alt }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                            </a>
                            <div class="price">-{{ $item->porcentaje }} <span class="percent">%</span></div>
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
                            <div class="lower-price">{{ $item->precio }}</div>
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
    <!--End Offer Section-->

    <!--Popular Cars Section-->
    <section class="recent-tickets-section">
        <div class="auto-container">
            <!--Sec Title-->
        <div class="sec-title">
            <h2>Entradas Recientes</h2>
        </div>
        <!--End Sec Title-->
        <div id="carros_paginas">
            <!--Car Block-->
            @foreach($carros->chunk(4) as $bloque)
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
            {{ $carros->appends(['categorias' => $subs->currentPage()])->links() }}
            <!--End Styled Pagination-->
        </div>
        </div>
    </section>
    <!--End Popular Cars Section-->

    <!--Counter Section-->
    <section class="counter-section" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">

            <div class="fact-counter">
                <div class="row clearfix">

                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="count-outer count-box">
                                    <div class="icon-box"><span class="icon flaticon-transport-1"></span></div>
                                    <span class="count-text" data-speed="10" data-stop="{{ $total_carros }}">0</span>
                                </div>
                                <h4 class="counter-title">Vehículos Disponibles</h4>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="count-outer count-box">
                                    <div class="icon-box"><span class="icon flaticon-good-mood-emoticon"></span></div>
                                    <span class="count-text" data-speed="10" data-stop="{{ $visitas }}">0</span>
                                </div>
                                <h4 class="counter-title">Visitas</h4>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="count-outer count-box">
                                    <div class="icon-box"><span class="icon flaticon-black"></span></div>
                                    <span class="count-text" data-speed="3000" data-stop="295">0</span>+
                                </div>
                                <h4 class="counter-title">Experts Reviews</h4>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="count-outer count-box">
                                    <div class="icon-box"><span class="icon flaticon-interface-1"></span></div>
                                    <span class="count-text" data-speed="3000" data-stop="7">0</span>
                                </div>
                                <h4 class="counter-title">Certification Hold</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!--End Counter Section-->  
        
    <!--Choose Section-->
    <section class="choose-section" style="background-image:url({{ asset('template_new/images/background/3.jpg') }});">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title style-two">
                <h2>Why Choose Us</h2>
            </div>
            <div class="row clearfix">
            
                <!--Services Block-->
                <div class="services-block-two col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-car-washing"></span></div>
                        <h3><a href="javascript:">Auto Loan Facility</a></h3>
                        <div class="sub-title">Easy Finance</div>
                        <div class="text">How all this mistakens idea off ut denouncing pleasures and praisings ut pain.</div>
                        <ul>
                            <li>Professional Finance</li>
                            <li>Affordable EMI</li>
                            <li>Less Interest Rate</li>
                        </ul>
                    </div>
                </div>
                
                <!--Services Block-->
                <div class="services-block-two col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-contract"></span></div>
                        <h3><a href="javascript:">Free Documentation</a></h3>
                        <div class="sub-title">No Hidden Charges</div>
                        <div class="text">Denouncing pleasures and ut praisings pains was born work will gives you.</div>
                        <ul>
                            <li>Quick Documentation</li>
                            <li>Very Confidential</li>
                            <li>On Time Processing</li>
                        </ul>
                    </div>
                </div>
                
                <!--Services Block-->
                <div class="services-block-two col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-telemarketer"></span></div>
                        <h3><a href="javascript:">Customer Support</a></h3>
                        <div class="sub-title">24/7 Online Support</div>
                        <div class="text">Idea of denouncing pleasure ut and praisings pain born and system and expound.</div>
                        <ul>
                            <li>Experienced Team</li>
                            <li>Humble Talk</li>
                            <li>Quick Response</li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!--End Choose Section--> 
    
    <!--Client Section-->
    <section class="client-section" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Title Column-->
                <div class="title-column col-md-4 col-sm-12 col-xs-12">
                    <div class="sec-title light no-border">
                        <h2>Who Trust us</h2>
                    </div>
                    <div class="style-text">Here are some of the brands that have trusted us for car performance.</div>
                    <div class="text">Great explorer of the truth, the master-builder of human happiness one rejects, dislikes, or avoids sed pleasure because it is pleasure.</div>
                </div>
                <!--Client Column-->
                <div class="client-column col-md-8 col-sm-12 col-xs-12">
                    <div class="clients-box">
                        <div class="clearfix">
                        
                            <!--Client Box-->
                            <div class="client-box col-md-3 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('template_new/images/clients/5.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                            <div class="client-box col-md-3 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('template_new/images/clients/6.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                            <div class="client-box col-md-3 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('template_new/images/clients/7.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                            <div class="client-box col-md-3 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('template_new/images/clients/8.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Client Section-->  
        
    <!--News Section-->
    <section class="news-section">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title centered">
                <h2>Our Latest Blogs</h2>
            </div>
            <div class="row clearfix">
            
                <!--News Block-->
                <div class="news-block col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="image">
                            <img src="{{ asset('template_new/images/resource/news-1.jpg') }}" alt="" />
                            <a class="overlay-link" href="blog-single.html"><span class="icon fa fa-link"></span></a>
                        </div>
                        <div class="lower-box">
                            <div class="post-date">21 <br> Nov</div>
                            <div class="content">
                                <div class="author">By Jack Stonney</div>
                                <h3><a href="blog-single.html">Distributed throughout the all over country.</a></h3>
                                <div class="text">Great explorer of the truth, the master builder of human happiness.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--News Block-->
                <div class="news-block col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="image">
                            <img src="{{ asset('template_new/images/resource/news-2.jpg') }}" alt="" />
                            <a class="overlay-link" href="blog-single.html"><span class="icon fa fa-link"></span></a>
                        </div>
                        <div class="lower-box">
                            <div class="post-date">14 <br> Oct</div>
                            <div class="content">
                                <div class="author">By Joe Venanda</div>
                                <h3><a href="blog-single.html">Get some usefull maintanence tips from our expets.</a></h3>
                                <div class="text">There anyone who loves or pursues or sed desires to obtain pain of itself.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--News Block-->
                <div class="news-block col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="image">
                            <img src="{{ asset('template_new/images/resource/news-3.jpg') }}" alt="" />
                            <a class="overlay-link" href="blog-single.html"><span class="icon fa fa-link"></span></a>
                        </div>
                        <div class="lower-box">
                            <div class="post-date">05 <br> Jun</div>
                            <div class="content">
                                <div class="author">By Lee Philipson</div>
                                <h3><a href="blog-single.html">High quality cars only we selling to our customers.</a></h3>
                                <div class="text">Which toil and pain can procure him some great pleasure to take a trivial.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!--End News Section-->

@stop

@section('script')
  <script type="text/javascript" src="{{ asset('js/paginador.js') }}"></script>
@endsection