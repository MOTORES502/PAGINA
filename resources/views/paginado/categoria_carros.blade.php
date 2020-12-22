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
                                <img alt="{{ $vehiculo->alt }}" src="{{ Storage::disk('images')->url($vehiculo->image) }}" />
                            </a>
                        </div>
                    </div>
                    <div class="content-column col-md-8 col-sm-8 col-xs-12">
                        <h3>
                            <a href="{{ route('vehiculo', ['slug' => $vehiculo->slug, 'value' => base64_encode($vehiculo->codigo)]) }}" title="{{ $vehiculo->completo }}">
                                {{ $vehiculo->completo }}
                            </a>
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
                                        <a href="{{ route('marca', ['slug' => str_replace(' ', '_', mb_strtolower($vehiculo->brands_id)), 'value' => base64_encode($vehiculo->brands_id)]) }}" title="{{ $vehiculo->brands_name }}">
                                            <img width="25%" src="{{ Storage::disk('images')->url($vehiculo->brands_image) }}" alt="{{  $vehiculo->brands_name }}" />
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