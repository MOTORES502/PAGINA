<div class="auto-container">
    @foreach($data->chunk(3) as $bloque)
        <div class="row clearfix">
        @foreach ($bloque as $item)
            <!--News Block-->
            <div class="news-block col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <div class="image">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}" />
                        <a class="overlay-link" href="{{ route('blog.seleccionado', ['slug' => $item->slug, 'value' => base64_encode($item->id)]) }}"><span class="icon fa fa-link"></span></a>
                    </div>
                    <div class="lower-box">
                        <div class="post-date">{{ date('d', strtotime($item->created_at)) }} <br> {{ date('M', strtotime($item->created_at)) }}</div>
                        <div class="content">
                            <div class="author">{{ $item->usuario }}</div>
                            <h3><a href="{{ route('blog.seleccionado', ['slug' => $item->slug, 'value' => base64_encode($item->id)]) }}">{{ $item->name }}</a></h3>
                            <div class="text">{{ $item->description }}</div>
                        </div>
                    </div>
                </div>
            </div>   
        @endforeach  
        </div>           
    @endforeach 
</div>
    
<!--Styled Pagination-->
{{ $data->links() }}
<!--End Styled Pagination-->