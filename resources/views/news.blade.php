@extends('layouts.home')
@section('content')
    <div class="container">
        <div id="wrapper" class="nivo-slider">
            <div class="slider-wrapper theme-default">
                <div id="slider" class="nivoSlider"> 
                    @foreach ($slider as $item)
                        <img src="{{route('get-image', $item->image_id)}}" 
                        data-thumb="{{route('get-image-thumbnail', $item->image_id)}}" 
                        alt="{{$item->title}}" 
                        title="#caption-{{$item->image_id}}"/> 
                    @endforeach
                </div>
                @foreach ($slider as $item)
                    <div id="caption-{{$item->image_id}}" class="nivo-html-caption"> <strong>{{$item->title}}</strong> </div>
                @endforeach
            </div>
        </div>
        <div class="news">
            @foreach ($news as $item)
                <div class="item"><a href="{{route('info.show', Str::slug($item->title).'-'.$item->id)}}-{{$item->id}}">
                    <img src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}"></a>
                    <div class="s-content">
                        <h3 class="p-name">
                            <a href="{{route('info.show', Str::slug($item->title).'-'.$item->id)}}-{{$item->id}}" title="{{ $item->title }}"> 
                                {{ $item->title }}
                            </a>
                        </h3>
                        <div class="p-desc">{!! $item->description !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            // Can also be used with $(document).ready()
            $(window).load(function() {
                $('#slider').nivoSlider({
                    effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
                    animSpeed: 500, // Slide transition speed
                    pauseTime: 4000, // How long each slide will show
                    startSlide: 0, // Set starting Slide (0 index)
                    directionNav: false, // Next & Prev navigation
                    controlNav: false, // 1,2,3... navigation
                    controlNavThumbs: false, // Use thumbnails for Control Nav
                    pauseOnHover: false // Stop animation while hovering      
                });
            });
        </script>
    </div>
@endsection

