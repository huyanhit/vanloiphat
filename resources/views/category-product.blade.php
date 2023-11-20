@extends('layouts.home')
@section('content')
    <div class="container">
        <ul class="p-category">
            <li  class="{{request()->routeIs('list-product.index')? 'active': ''}}"><a href="{{ route('list-product.index') }}"> TẤT CẢ </a></li>
            @foreach ($categores as $item)
                <li class=" {{(request()->segment(2) == $item->name)? 'active': ''}}"><a href="{{ route('category-product.show', $item->name) }}"> {{$item->title}} </a></li>
            @endforeach
        </ul>
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
                        <div class="p-desc">{{ $item->description }}</div>
                        <div class="p-price"> {!! $item->prime_sale > 0 ? $item->prime_sale: '<span class="special-price"> Liên hệ </span>' !!} </div>
                    </div>
                </div>
            @endforeach
            <div class="pagin-product"> 
                {!! $product->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
        
        <h3 class="p-title"> <span> Đối tác </span></h3>
        <div class="customer-carousel owl-carousel owl-theme">
            @foreach ($partner as $item)
            <div class="item">
                <a href="{{$item->link}}"><img src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}"></a>
            </div>
            @endforeach
        </div>

        <script>
            // Can also be used with $(document).ready()
            $(window).load(function() {
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
            });
        </script>
    </div>
@endsection

