@extends('layouts.home')
@section('content')
    <div class="container">
        <h3 class="p-title"> <span> Tất cả các dịch vụ </span></h3>
        <div class="services">
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
        <h3 class="p-title"> <span> Dịch vụ hàng đầu</span></h3>
        <div class="service-carousel owl-carousel owl-theme">
            @foreach ($top as $item)
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
            });
        </script>
    </div>
@endsection

