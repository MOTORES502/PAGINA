@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Publicación seleccionada</h1>
        </div>
    </section>
    <!--End Page Title-->

    <!--Sidebar Page Container-->
    <div class="sidebar-page-container">
    	<div class="auto-container">
        	<div class="row clearfix">
            	
                <!--Content Side-->
                <div class="content-side col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="blog-single">
                    	
                        <!--News Block-->
                        <div class="news-block-two">
                            <div class="inner-box">
                                <div class="image">
                                    <img src="{{ $blog->image }}" alt="{{ $blog->name }}" />
                                </div>
                                <div class="lower-box">
                                    <div class="post-date">{{ date('d', strtotime($blog->created_at)) }} <br> {{ date('M', strtotime($blog->created_at)) }}</div>
                                    <div class="content">
                                        <ul class="post-meta">
                                        	<li><span class="icon fa fa-user"></span>{{ $blog->usuario }}</li>
                                        </ul>
                                        <h3>{{ $blog->name }}</h3>
                                        <div class="text">
                                        	{{ $blog->description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!--Author Box-->
                    <div class="author-box">
                    	<h2>Autor de la Publicación</h2>
                        <div class="author-comment">
                            <div class="inner-box">
                                <div class="image"><img src="{{ is_null($blog->usuario_foto) ? asset('template_new/images/resource/author-4.jpg') : $blog->usuario_foto }}" alt="{{ $blog->usuario }}" /></div>
                                <h3>{{ $blog->usuario }}</h3>
                            </div>
                        </div>
                    </div>                    
                </div>
                
                <!--Sidebar Side-->
                <div class="sidebar-side col-lg-4 col-md-4 col-sm-12 col-xs-12">
                	<aside class="sidebar sidebar-padding with-border">
						                        <!-- Popular Posts -->
                        <div class="sidebar-widget popular-posts">
                            <div class="sidebar-title"><h2>Publicaciones recientes</h2></div>

                            @foreach ($publicaciones as $item)
                                <article class="post">
                                    <figure class="post-thumb"><img src="{{ $item->image }}" alt="{{ $item->name }}"><a class="overlay" href="{{ route('blog.seleccionado', ['slug' => $item->slug, 'value' => base64_encode($item->id)]) }}"><span class="icon flaticon-unlink"></span></a></figure>
                                    <div class="text"><a href="{{ route('blog.seleccionado', ['slug' => $item->slug, 'value' => base64_encode($item->id)]) }}">{{ $item->name }}</a></div>
                                    <ul class="post-meta">
                                        <li><span class="icon fa fa-user"></span>{{ $item->usuario }}</li>
                                    </ul>
                                </article>
                            @endforeach
    
						</div>
                    </aside>
                </div>
            </div>
        </div>
    </div>    
@stop