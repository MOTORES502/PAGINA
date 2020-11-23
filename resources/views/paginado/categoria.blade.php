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
{{ $subs->appends(['carros' => $carros->currentPage()])->render() }}
<!--End Styled Pagination-->