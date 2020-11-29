<div class="auto-container">
    <div class="row clearfix">
        @foreach ($data as $item)
            <!--News Block-->
            <div class="news-block col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="inner-box">
                    <div class="image">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}" />
                        <a class="overlay-link" href="blog-single.html"><span class="icon fa fa-link"></span></a>
                    </div>
                    <div class="lower-box">
                        <div class="post-date">{{ date('d', strtotime($item->created_at)) }} <br> {{ date('M', strtotime($item->created_at)) }}</div>
                        <div class="content">
                            <div class="author">{{ $item->usuario }}</div>
                            <h3><a href="blog-single.html">{{ $item->name }}</a></h3>
                            <div class="text">{{ $item->description }}</div>
                        </div>
                    </div>
                </div>
            </div>   
        @endforeach             
    </div>
</div>
    
<!--Styled Pagination-->
{{ $data->links() }}
<!--End Styled Pagination-->