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
<form action="" method="post">
    <div class="row clearfix">
        <div class="column col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="row clearfix">

                <!--Form Group-->
                <div class="form-group col-md-6">
                    <select id="marca_id" name="marca_id" data-placeholder="Seleccionar marca" class="form-control js-example-basic-single">
                      @foreach ($marcas as $item)
                        <option value="{{ $item->id }}" {{ ($item->id == old('marca_id')) ? 'selected' : '' }}>{{ $item->name }}</option>
                      @endforeach
                    </select>
                </div>

                <!--Form Group-->
                <div class="form-group col-md-6">
                    <select class="custom-select-box">
                        <option>linea</option>
                        <option>linea One</option>
                        <option>linea Two</option>
                        <option>linea Three</option>
                        <option>linea Four</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="column col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="row clearfix">
                <!--Form Group-->
                <div class="form-group col-md-4">
                    <select class="custom-select-box">
                        <option>Precio Min</option>
                        <option>Generacion One</option>
                        <option>Generacion Two</option>
                        <option>Generacion Three</option>
                        <option>Generacion Four</option>
                    </select>
                </div>

                <!--Form Group-->
                <div class="form-group col-md-4">
                    <select class="custom-select-box">
                        <option>Precio Max</option>
                        <option>Price One</option>
                        <option>Price Two</option>
                        <option>Price Three</option>
                        <option>Price Four</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <button class="theme-btn search-btn" type="submit" name="submit-form">Search</button>
                </div>
            </div>

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
                                <a href="{{ route('categoria', ['slug' => mb_strtolower($sub->name), 'value' => base64_encode($sub->id)]) }}" class="link-box">
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
                                  <span class="count-text" data-speed="1000" data-stop="{{ $total_carros }}">0</span>
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
                                  <span class="count-text" data-speed="3000" data-stop="3685">0</span>
                              </div>
                              <h4 class="counter-title">Satisfied Customers</h4>
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

  <!--Main Footer-->
  <footer class="main-footer" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
      <div class="auto-container">
          <!--Widgets Section-->
          <div class="widgets-section">
              <div class="row clearfix">

                  <!--big column-->
                  <div class="big-column col-md-6 col-sm-12 col-xs-12">
                      <div class="row clearfix">

                          <!--Footer Column-->
                          <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                              <div class="footer-widget about-widget">
                                  <h2>About Us</h2>
                                  <div class="text">
                                      <p>Must explain to how all this mistaken idea of denouncing pleasure & praising pain was born and system.</p>
                                      <p>There anyone who loves or pursues or desires to obtain pain  itself, because it is pain, but because occasionally occur in whichgreat pleasure. </p>
                                  </div>
                                  <a href="about.html" class="theme-btn btn-style-three">Read More</a>
                              </div>
                          </div>

                          <!--Footer Column-->
                          <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                              <div class="footer-widget links-widget">
                                  <h2>Usefull Links</h2>
                                  <div class="widget-content">
                                      <ul class="footer-links">
                                          <li><a href="about.html">About Us</a></li>

                                          <li><a href="inventory-grid.html">Recent Tickets</a></li>
                                          <li><a href="vehicle-compare.html">Compare Cars</a></li>
                                          <li><a href="blog.html">Blog</a></li>
                                          <li><a href="faq.html">FAQs</a></li>
                                          <li><a href="contact.html">Contact</a></li>
                                      </ul>
                                  </div>
                              </div>
                          </div>

                      </div>
                  </div>

                  <!--big column-->
                  <div class="big-column col-md-6 col-sm-12 col-xs-12">
                      <div class="row clearfix">
                          <!--Footer Column-->
                          <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                              <div class="footer-widget links-widget">
                                  <h2>Contact Details</h2>
                                  <div class="widget-content">
                                      <ul class="list-style-one">
                                          <li><span class="icon flaticon-maps-and-flags"></span>motores502, Newyork 10012, USA</li>
                                          <li><span class="icon flaticon-telephone"></span>Phone: +92 123 456789</li>
                                          <li><span class="icon flaticon-fax"></span>Fax: +92 123 456789</li>
                                          <li><span class="icon flaticon-web"></span>Supportteam@motores502.com</li>
                                      </ul>
                                  </div>
                                  <h2>Follow Us</h2>
                                  <ul class="social-icon-four">
                                      <li><a href="javascript:"><span class="fa fa-facebook"></span></a></li>
                                      <li><a href="javascript:"><span class="fa fa-twitter"></span></a></li>
                                      <li><a href="javascript:"><span class="fa fa-youtube-play"></span></a></li>
                                  </ul>
                              </div>
                          </div>

                          <!--Footer Column-->
                          <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                              <div class="footer-widget offer-widget">
                                  <div class="column">
                                      <div class="hours-block">
                                          <div class="inner-box p-0">
                                              <h2>Working Hours</h2>
                                              <ul>
                                                  <li class="clearfix">Monday<span>9am - 8pm</span></li>
                                                  <li class="clearfix">Tuesday<span>9am - 6pm</span></li>
                                                  <li class="clearfix">Wednesday<span>10am - 8pm</span></li>
                                                  <li class="clearfix">Thursday<span>9am - 8pm</span></li>
                                                  <li class="clearfix">Friday<span>9am - 6pm</span></li>
                                                  <li class="clearfix">Saturday<span>10am - 2pm</span></li>
                                                  <li class="clearfix">Sunday<span class="closed">Close</span></li>
                                              </ul>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                      </div>
                  </div>

              </div>
          </div>
      </div>
      <!--Footer Bottom-->
      <div class="footer-bottom">
          <div class="auto-container">
              <div class="row clearfix">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="copyright">Copyrights © 2020 All Rights Reserved by Motores502.</div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <ul class="footer-nav">
                          <li><a href="http://www.xenialsolution.com" target="_blank">Powered By: Xenial Solution</a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </footer>
  <!--End Main Footer-->

@stop

@section('script')
  <script type="text/javascript" src="{{ asset('js/paginador.js') }}"></script>
@endsection