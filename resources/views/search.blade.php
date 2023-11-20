@extends('layouts.home')
@section('content')
    <div class="container">
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
            <div class="pagin-product"> 
                {!! $product->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
    </div>
@endsection

