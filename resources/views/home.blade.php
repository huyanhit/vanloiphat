@extends('layouts.home')
@section('content')
    <div class="container">
        <div class="flex">
            <div class="xl:basis-1/4 lg:basis-2/6"></div>
            <div class="xl:basis-3/4 lg:basis-4/6 sm:hidden lg:block">
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
        </div>

        <x-title-block title="Sản phẩm mới"></x-title-block>
        <div class="-mx-2">
            @foreach ($new as $item)
                <x-product-item :item="$item" />
            @endforeach
        </div>

        <x-title-block title="Sản phẩm bán chạy"></x-title-block>
        <div class="-mx-2">
            @foreach ($hot as $item)
                <x-product-item :item="$item" />
            @endforeach
        </div>

        <x-title-block title="Dịch vụ"></x-title-block>
        <div class="service-carousel owl-carousel owl-theme bg-white shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)] my-2 p-2  clear-both">
            @foreach ($service as $item)
                <x-service-item :item="$item" />
            @endforeach
        </div>

        <x-title-block title="Sản phẩm đang khuyến mãi"></x-title-block>
        <div class="-mx-2">
            @foreach ($promotion as $item)
                <x-product-item :item="$item" />
            @endforeach
        </div>

        <x-title-block title="Đối tác"></x-title-block>
        <div class="customer-carousel owl-carousel owl-theme bg-white shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)] my-2 p-2 clear-both">
            @foreach ($partner as $item)
                <x-producer-item :item="$item" />
            @endforeach
        </div>
    </div>
    <script>
        document.getElementById("menus").classList.remove("lg:hidden");
    </script>
@endsection

