@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Quienes somos</h1>
        </div>
    </section>
    <!--End Page Title-->  
    
    <!--About Section-->
    <section class="about-section">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title">
                <h2>About motores502</h2>
            </div>
            <div class="row clearfix">
                <!--Content Column-->
                <div class="content-column col-md-4 col-sm-12 col-xs-12">
                    <div class="inner-column">
                        <div class="bold-text">We Have The Right Products to Fit Your Needs.</div>
                        <div class="text">motores502 brings 41 years of interior designs experience right to home or office. Our design professionals are equipped to help you determine the products and design that work best for our customers within the colors and lighting of your we make more than your expectation and your dream designs.</div>
                        <div class="clearfix">
                            <div class="pull-left">
                                <div class="signature">
                                    <img src="{{ asset('template_new/images/resource/signature.png') }}" alt="" />
                                </div>
                            </div>
                            <div class="pull-right">
                                <h3>William Shocks,</h3>
                                <span class="designation">CEO & Founder</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Blocks Column-->
                <div class="blocks-column col-md-8 col-sm-12 col-xs-12">
                    <div class="row clearfix">
                        <!--About Block-->
                        <div class="about-block col-md-6 col-sm-6 col-xs-12">
                            <div class="inner-box">
                                <div class="image">
                                    <img src="{{ asset('template_new/images/resource/about-1.jpg') }}" alt="" />
                                </div>
                                <div class="lower-box">
                                    <h3><a href="javascript:">Our Mission</a></h3>
                                    <div class="text">To work in accordance with the clients’ requirement and exceed their expectations in terms of quality, cost control and time management.</div>
                                </div>
                            </div>
                        </div>
                        
                        <!--About Block-->
                        <div class="about-block col-md-6 col-sm-6 col-xs-12">
                            <div class="inner-box">
                                <div class="image">
                                    <img src="{{ asset('template_new/images/resource/about-2.jpg') }}" alt="" />
                                </div>
                                <div class="lower-box">
                                    <h3><a href="javascript:">Our Vision</a></h3>
                                    <div class="text">To consistently deliver eco-friendly world class finishes in our interior design concepts, execute & complete all projects in such a way.</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End About Section-->
    
    <!--Advantage Section-->
    <section class="advantage-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Blocks Column-->
            	<div class="blocks-column col-lg-8 col-md-12 col-sm-12 col-xs-12">
                	<div class="sec-title light">
                    	<h2>Our Advantages</h2>
                    </div>
                    <div class="row clearfix">
                    	<!--Services Block-->
                        <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-car-search"></span>
                                </div>
                                <h3><a href="javascript:">25 Years of Experience</a></h3>
                                <div class="sub-title">With Quality Service</div>
                                <div class="text">How all this mistakens idea off denouncing pleasures and praisings ut pain.</div>
                            </div>
                        </div>
                        
                        <!--Services Block-->
                        <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-steering-wheel"></span>
                                </div>
                                <h3><a href="javascript:">Quality Products</a></h3>
                                <div class="sub-title">At Low Prices</div>
                                <div class="text">Denouncing pleasures and praisings pains was born work will gives you.</div>
                            </div>
                        </div>
                        
                        <!--Services Block-->
                        <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-networking"></span>
                                </div>
                                <h3><a href="javascript:">Exclusive Partnership</a></h3>
                                <div class="sub-title">Easy Finance</div>
                                <div class="text">Idea of denouncing pleasure and praisings pain born and system and expound.</div>
                            </div>
                        </div>
                        
                        <!--Services Block-->
                        <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-support"></span>
                                </div>
                                <h3><a href="javascript:">Customer Support</a></h3>
                                <div class="sub-title">24/7 Online Support</div>
                                <div class="text">Idea of denouncing pleasure and praisings pain born and system and expound.</div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!--Customer Column-->
                <div class="customer-column col-lg-4 col-md-12 col-sm-12 col-xs-12">
                	<div class="inner-box">
                    	<div class="upper-box">
                        	<div class="icon flaticon-24-hours"></div>
                            <h3>Atención al cliente 24/7</h3>
                            <div class="title">Para servicio de emergencia</div>
                        </div>
                        <div class="lower-box">
                        	<div class="number">+(502) 6646-7000</div>
                            <div class="text">Podemos proporcionar un servicio experto de emergencia las 24 horas, ¡póngase en contacto cuando lo necesite!.</div>
                            <h4>Para consultas:</h4>
                            <ul>
                            	<li><span class="theme_color">Tel:</span> +(502) 6646-7000</li>
                                <li><span class="theme_color">Email:</span> info@motores502.com</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Advantage Section-->
    
    <!--Team Section-->
    <section class="team-section">
    	<div class="auto-container">
        	<!--Sec Title-->
            <div class="sec-title centered">
            	<h2>Meet Our team</h2>
            </div>
            <div class="two-item-carousel owl-carousel owl-theme">
            	
                <!--Team Block-->
            	<div class="team-block">
                	<div class="inner-box">
                    	<div class="clearfix">
                        	<div class="image-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<img src="{{ asset('template_new/images/resource/team-1.jpg') }}" alt="" />
                                    <div class="overlay-box">
                                    	<ul class="social-icon-one">
                                        	<li><a href="javascript:"><span class="fa fa-facebook"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-twitter"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-linkedin"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="content-inner">
                                	<h3><a href="javascript:">Michael Jeorge</a></h3>
                                    <div class="sub-title">CEO & Founder</div>
                                    <div class="text">Explain to you how this mistaken <br> idea of denouncing pleasure.</div>
                                    <ul class="list-style-three">
                                        <li><span class="icon fa fa-phone"></span>Ph: 900-789-0123</li>
                                        <li><span class="icon fa fa-envelope"></span>Email: Jeorge@motores502.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Team Block-->
            	<div class="team-block">
                	<div class="inner-box">
                    	<div class="clearfix">
                        	<div class="image-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<img src="{{ asset('template_new/images/resource/team-2.jpg') }}" alt="" />
                                    <div class="overlay-box">
                                    	<ul class="social-icon-one">
                                        	<li><a href="javascript:"><span class="fa fa-facebook"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-twitter"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-linkedin"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="content-inner">
                                	<h3><a href="javascript:">Stephen Fernando</a></h3>
                                    <div class="sub-title">VP Sales & Marketing</div>
                                    <div class="text">Actual teachings of  great explorer of the truth, the master.</div>
                                    <ul class="list-style-three">
                                        <li><span class="icon fa fa-phone"></span>Ph: 900-123-4567</li>
                                        <li><span class="icon fa fa-envelope"></span>Email: Stephen@motores502.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Team Block-->
            	<div class="team-block">
                	<div class="inner-box">
                    	<div class="clearfix">
                        	<div class="image-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<img src="images/resource/team-1.jpg" alt="" />
                                    <div class="overlay-box">
                                    	<ul class="social-icon-one">
                                        	<li><a href="javascript:"><span class="fa fa-facebook"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-twitter"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-linkedin"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="content-inner">
                                	<h3><a href="javascript:">Michael Jeorge</a></h3>
                                    <div class="sub-title">CEO & Founder</div>
                                    <div class="text">Explain to you how this mistaken <br> idea of denouncing pleasure.</div>
                                    <ul class="list-style-three">
                                        <li><span class="icon fa fa-phone"></span>Ph: 900-789-0123</li>
                                        <li><span class="icon fa fa-envelope"></span>Email: Jeorge@motores502.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Team Block-->
            	<div class="team-block">
                	<div class="inner-box">
                    	<div class="clearfix">
                        	<div class="image-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<img src="images/resource/team-2.jpg" alt="" />
                                    <div class="overlay-box">
                                    	<ul class="social-icon-one">
                                        	<li><a href="javascript:"><span class="fa fa-facebook"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-twitter"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-linkedin"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="content-inner">
                                	<h3><a href="javascript:">Stephen Fernando</a></h3>
                                    <div class="sub-title">VP Sales & Marketing</div>
                                    <div class="text">Actual teachings of  great explorer of the truth, the master.</div>
                                    <ul class="list-style-three">
                                        <li><span class="icon fa fa-phone"></span>Ph: 900-123-4567</li>
                                        <li><span class="icon fa fa-envelope"></span>Email: Stephen@motores502.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Team Block-->
            	<div class="team-block">
                	<div class="inner-box">
                    	<div class="clearfix">
                        	<div class="image-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<img src="images/resource/team-1.jpg" alt="" />
                                    <div class="overlay-box">
                                    	<ul class="social-icon-one">
                                        	<li><a href="javascript:"><span class="fa fa-facebook"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-twitter"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-linkedin"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="content-inner">
                                	<h3><a href="javascript:">Michael Jeorge</a></h3>
                                    <div class="sub-title">CEO & Founder</div>
                                    <div class="text">Explain to you how this mistaken <br> idea of denouncing pleasure.</div>
                                    <ul class="list-style-three">
                                        <li><span class="icon fa fa-phone"></span>Ph: 900-789-0123</li>
                                        <li><span class="icon fa fa-envelope"></span>Email: Jeorge@motores502.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Team Block-->
            	<div class="team-block">
                	<div class="inner-box">
                    	<div class="clearfix">
                        	<div class="image-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<img src="images/resource/team-2.jpg" alt="" />
                                    <div class="overlay-box">
                                    	<ul class="social-icon-one">
                                        	<li><a href="javascript:"><span class="fa fa-facebook"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-twitter"></span></a></li>
                                            <li><a href="javascript:"><span class="fa fa-linkedin"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="content-inner">
                                	<h3><a href="javascript:">Stephen Fernando</a></h3>
                                    <div class="sub-title">VP Sales & Marketing</div>
                                    <div class="text">Actual teachings of  great explorer of the truth, the master.</div>
                                    <ul class="list-style-three">
                                        <li><span class="icon fa fa-phone"></span>Ph: 900-123-4567</li>
                                        <li><span class="icon fa fa-envelope"></span>Email: Stephen@motores502.com</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!--End Team Section-->
    
    <!--Client Section-->
    <section class="client-section style-two">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Title Column-->
            	<div class="title-column col-md-4 col-sm-12 col-xs-12">
                	<div class="sec-title no-border">
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
                                	<a href="javascript:"><img src="{{ asset('template_new/images/clients/9.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<a href="javascript:"><img src="{{ asset('template_new/images/clients/10.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<a href="javascript:"><img src="{{ asset('template_new/images/clients/11.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<a href="javascript:"><img src="{{ asset('template_new/images/clients/12.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<a href="javascript:"><img src="{{ asset('template_new/images/clients/13.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<a href="javascript:"><img src="{{ asset('template_new/images/clients/14.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<a href="javascript:"><img src="{{ asset('template_new/images/clients/15.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                	<a href="javascript:"><img src="{{ asset('template_new/images/clients/16.png') }}" alt="" /></a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Client Section-->
@stop