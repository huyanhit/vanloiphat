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
        <h3 class="p-title"><span>Sản phẩm Tiêu Biểu</span></h3>
        <div class="p-product">
            @foreach ($product as $item)
                <div class="item">
                    <a class="image" href="{{route('product.show', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}">
                        <img src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}"> 
                    </a>
                    <div class="p-content">
                        <h3 class="p-name">
                            <a href="{{route('product.show', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}"> 
                                {{ $item->title }}
                            </a>
                        </h3>
                        <div class="p-desc">{!! $item->description !!}</div>
                        <div class="p-price"> {!! $item->prime_sale > 0 ? $item->prime_sale: '<span class="special-price"> Liên hệ </span>' !!} </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h3 class="p-title"><span>Sản phẩm mới</span></h3>
        <div class="p-product">
            @foreach ($new as $item)
                <div class="item">
                    <a class="image" href="{{route('product.show', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}">
                        <img src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}"> 
                    </a>
                    <div class="p-content">
                        <h3 class="p-name">
                            <a href="{{route('product.show', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}"> 
                                {{ $item->title }}
                            </a>
                        </h3>
                        <div class="p-desc">{!! $item->description !!}</div>
                        <div class="p-price"> {!! $item->prime_sale > 0 ? $item->prime_sale: '<span class="special-price"> Liên hệ </span>' !!} </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <h3 class="p-title"><span>Sản phẩm bán chạy</span></h3>
        <div class="p-product">
            @foreach ($hot as $item)
                <div class="item">
                    <a class="image" href="{{route('product.show', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}">
                        <img src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}"> 
                    </a>
                    <div class="p-content">
                        <h3 class="p-name">
                            <a href="{{route('product.show', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}"> 
                                {{ $item->title }}
                            </a>
                        </h3>
                        <div class="p-desc">{!! $item->description !!}</div>
                        <div class="p-price"> {!! $item->prime_sale > 0 ? $item->prime_sale: '<span class="special-price"> Liên hệ </span>' !!} </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h3 class="p-title"><span>Sản phẩm đang có khuyến mãi</span></h3>
        <div class="p-product">
            @foreach ($promotion as $item)
                <div class="item">
                    <a class="image" href="{{route('product.show', Str::slug($item->title))}}-{{$item->id}}-{{$item->id}}" title="{{ $item->title }}">
                        <img src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}"> 
                    </a>
                    <div class="p-content">
                        <h3 class="p-name">
                            <a href="{{route('product.show', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}"> 
                                {{ $item->title }}
                            </a>
                        </h3>
                        <div class="p-desc">{!! $item->description !!}</div>
                        <div class="p-price"> {!! $item->prime_sale > 0 ? $item->prime_sale: '<span class="special-price"> Liên hệ </span>' !!} </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h3 class="p-title"> <span> Dịch vụ </span></h3>
        <div class="service-carousel owl-carousel owl-theme">
            @foreach ($service as $item)
                <div class="item"><a href="{{route('service.show', Str::slug($item->title).'-'.$item->id)}}-{{$item->id}}">
                    <img src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}"></a>
                    <div class="s-content">
                        <h3 class="p-name">
                            <a href="{{route('service.show', Str::slug($item->title).'-'.$item->id)}}-{{$item->id}}" title="{{ $item->title }}"> 
                                {{ $item->title }}
                            </a>
                        </h3>
                        <div class="p-desc">{!! $item->description !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
       
        <h3 class="p-title"> <span> Đối tác </span></h3>
            <div class="customer-carousel owl-carousel owl-theme">
                @foreach ($partner as $item)
                <div class="item">
                    <a href="{{$item->link}}"><img src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}"></a>
                </div>
                @endforeach
            </div>
        </div>

        <script>
            // Can also be used with $(document).ready()
            $(window).load(function() {
                $('.service-carousel').owlCarousel({
                    loop:true,
                    margin:10,
                    nav:true,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:2
                        },
                        1000:{
                            items:4
                        }
                    }
                })

                $('.customer-carousel').owlCarousel({
                    loop:true,
                    margin:0,
                    nav:true,
                    responsive:{
                        0:{
                            items:2
                        },
                        600:{
                            items:4
                        },
                        1000:{
                            items:5
                        }
                    }
                })
                
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

