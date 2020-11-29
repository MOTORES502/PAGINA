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
                    <div class="row clearfix">

                        <!--Car Block-->
                        <div class="car-option-block col-md-6 col-sm-6 col-xs-12">
                            <div class="inner-box">
                                <h2>Seleccionar carro</h2>
                                <div class="icon-box">
                                    <span class="icon flaticon-cabriolet"></span>
                                </div>

                                <!--Calculate Form-->
                                <div class="default-form">
                                    <form method="post" action="http://t.commonsupport.com/motores502/calculater-form">
                                        <div class="form-group">
                                            <select class="custom-select-box">
                                                <option>BMW</option>
                                                <option>Ferari</option>
                                                <option>Honda</option>
                                                <option>Toyota</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="custom-select-box">
                                                <option>BMW F12 6 Series</option>
                                                <option>Ferari F12 6 Series</option>
                                                <option>Honda F12 6 Series</option>
                                                <option>Toyota F12 6 Series</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="custom-select-box">
                                                <option>Varient</option>
                                                <option>Varient One</option>
                                                <option>Varient Two</option>
                                                <option>Varient Three</option>
                                                <option>Varient Four</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <!--Car Block-->
                        <div class="car-option-block col-md-6 col-sm-6 col-xs-12">
                            <div class="inner-box">
                                <h2>Seleccionar carro</h2>
                                <div class="icon-box">
                                    <span class="icon flaticon-cabriolet"></span>
                                </div>

                                <!--Calculate Form-->
                                <div class="default-form">
                                    <form method="post" action="http://t.commonsupport.com/motores502/calculater-form">
                                        <div class="form-group">
                                            <select class="custom-select-box">
                                                <option>Hyndai</option>
                                                <option>Ferari</option>
                                                <option>Honda</option>
                                                <option>Toyota</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="custom-select-box">
                                                <option>Coupe 1.0FL</option>
                                                <option>Coupe 2.0FL</option>
                                                <option>Coupe 3.0FL</option>
                                                <option>Coupe 4.0FL</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="custom-select-box">
                                                <option>Varient</option>
                                                <option>Varient One</option>
                                                <option>Varient Two</option>
                                                <option>Varient Three</option>
                                                <option>Varient Four</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="javascript:" class="theme-btn btn-style-one compare-btn">compare Cars</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Cars Compare Section-->    
@stop