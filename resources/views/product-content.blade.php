@extends('layouts.home')
@section('content')
<div class="container">
    <!-- product -->
    <div class="product-content product-wrap clearfix product-detail">
        <div class="row">
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="product-image">
                    <div id="p-carousel" class="owl-carousel owl-theme">
                        <div class="item">
                            <img src="{{route('get-image', $product->image_id)}}" class="img-responsive" alt="{{$product->keywords}}" />
                        </div>
                        @if(!empty($product->images))
                            @foreach (explode(',',$product->images) as $item)
                                <div class="item">
                                    <img src="{{route('get-image', $item)}}" class="img-responsive"/>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <script>
                    // Can also be used with $(document).ready()
                    $(window).load(function() {
                        $('#p-carousel').owlCarousel({
                            loop:true,
                            margin:10,
                            nav:true,
                            lazyLoad:true,
                            responsive:{
                                1000:{
                                    items:1
                                },
                            }
                        })
                    });
                </script>
            </div>

            <div class="col-md-7 col-sm-12 col-xs-12">
                <h2 class="name">
                    {{ $product->title }}
                </h2>
                <div class="description"> {!! $product->description !!}</div>
                <hr />
                <h3 class="price-container">
                    <span> Giá bán: </span>
                    @if ($product->price > $product->price_sale)
                        <span class="price"> {{number_format($product->price)}}</span>
                        <span class="price-sale"> {{number_format($product->price_sale)}}</span>
                    @elseif($product->price_sale > 0)    
                        <span class="price-sale"> {{number_format($product->price_sale)}}</span>
                    @else
                        <a href="{{route('page.show','lien-he')}}"><span class="price-sale"> Liên hệ: {{$sites->hotline}}</span></a>
                    @endif
                </h3>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 pro-content">
                <h3 class="p-title"> <span> Chi tiết sản phẩm </span></h3>
                <div class="content">
                    {!! $product->content !!}
                </div>

                <h3 class="p-title"><span>Sản phẩm cùng loại</span></h3>
                <div class="p-product">
                    @foreach ($c_product as $item)
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
            </div>
        </div>
    </div>
    <!-- end product -->
</div>

@endsection

