@extends('layouts.master')

@section('content')
    <!--Error Section-->
    <section class="error-section" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
    	<div class="auto-container">
        	<div class="inner-section">
            	<h1>404</h1>
                <h2>Hubo un problema, ya estamos trabajando para solucionarlo.</h2>
                <div class="text">Te invitamos a que sigas navegando en nuestra página</div>
            </div>
        </div>
    </section>
    <!--End Error Section-->
@stop