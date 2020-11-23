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