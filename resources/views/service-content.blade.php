@extends('layouts.home')
@section('content')
<div class="container">
    <x-breadcrumb name="dich-vu" :data="['service_title' => $service->title]">
    </x-breadcrumb>
    <div class="mt-2 flex flex-row">
        <div class="border-1 basis-5/12 relative w-[40%] bg-white">
            <div id="s-carousel" class="owl-carousel owl-theme p-3">
                <div class="item">
                    <img  onerror="this.src='/images/no-image.png'"
                          src="{{route('get-image', $service->image_id)}}"
                          class="img-responsive"
                          alt="{{$service->keywords}}" />
                </div>
                @if(!empty($service->images))
                    @foreach (explode(',',$service->images) as $item)
                        <div class="item">
                            <img onerror="this.src='/images/no-image.png'"
                                 src="{{route('get-image', $item)}}"
                                 class="img-responsive"/>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="basis-7/12 px-3 ">
            <div class="bg-white p-3">
                <h2 class="text-2xl font-bold">{{ $service->title }}</h2>
                @if($service->price > 0)
                    <div class="my-3">
                        <div class="mr-3">
                            <span class="font-bold"> Giá hãng: </span>
                            <span class="text-gray-700 line-through text-xl">{{ number_format($product->price, 0, ',', '.')}}đ </span>
                        </div>
                    </div>
                @else
                    <div class="w-full py-2 font-bold"><span class="text-sm">Liên hệ: </span> <a class="font-bold text-red-600 xl:text-lg lg:text-sm">0908.334.314</a></div>
                @endif
                <div class="">
                    <div class="py-2">
                        <h4 class="font-bold text-xl text-uppercase">Mô tả</h4>
                        <div class="p-3 text-sm border-1 my-1 prose m-auto prose-p:m-0 bg-white">
                            {!! $service->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 flex">
        <div class="basis-7/12">
            <div class="py-2">
                <h4 class="font-bold text-xl text-uppercase">Thông tin chi tiết</h4>
                <article class="my-1 p-3 prose prose-sm prose-p:m-0 bg-gray-100">
                    {!! $service->content !!}
                </article >
            </div>
        </div>
        <div class="basis-5/12">
            <div class="px-3">
                <x-comment-block :data="['service_id' => $service->id]"></x-comment-block>
            </div>
        </div>
    </div>
    <script>
        $(window).load(function() {
            $('#s-carousel').owlCarousel({
                loop:true,
                margin:10,
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

@endsection

