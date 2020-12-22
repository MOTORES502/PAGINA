<!--Styled Pagination-->
{{ $data->links() }}
<!--End Styled Pagination-->

<br>
<!--Car Block-->
@foreach($data->chunk(4) as $bloque)
    <div class="row clearfix">
    @foreach ($bloque as $item)
        <div class="car-block col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="inner-box">
            <div class="image">
                @if ($item->estado != 'DISPONIBLE')
                    <div class="ribbon ribbon-top-left"><span>{{ $item->estado }}</span></div>
                @endif
                <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}" title="{{ $item->alt }}">
                    <img alt="{{ $item->alt }}" src="{{ Storage::disk('images')->url($item->image) }}" />
                </a>
                <div class="price">{{ $item->oferta ? $item->oferta : $item->precio }}</div>
            </div>
            <h3>
                {{ $item->completo }} <br> {{ $item->codigo }}
            </h3>
            <div class="lower-box">
                <ul class="car-info">
                    <li><span class="icon fa fa-road"></span>{{ number_format($item->kilometro, 0, '.', ',') }}</li>
                    <li><span class="icon fa fa-car"></span>{{ $item->combustible }}</li>
                    <li><span class="icon fa fa-clock-o"></span>{{ $item->modelo }}</li>
                    <li><span class="icon fa fa-gears"></span>{{ $item->transmision }}</li>
                </ul>
            </div>
            </div>
        </div>            
    @endforeach
    </div>
@endforeach

<!--Styled Pagination-->
{{ $data->links() }}
<!--End Styled Pagination-->