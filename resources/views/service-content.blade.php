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
                    <div class="w-full py-2 font-bold"><span class="text-red-600 text-sm "> Liên hệ </span></div>
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
        <div class="basis-5/12">
            <div class="py-2">
            <h4 class="font-bold text-xl text-uppercase">Đánh giá</h4>
            <div class="my-1 bg-white p-3  border-1">
                <div class="flex flex-col space-y-4">
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h5 class="text-lg font-bold">Hương</h5>
                        <p class="text-gray-700 text-sm mb-2">Mua ngày 15 - 04 - 2024</p>
                        <p class="text-gray-700">Sản phẩm tốt lắp đặt nhanh</p>
                    </div>
                    <form class="bg-white p-4 rounded-lg shadow-md">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="name">
                                Tên
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   id="name" type="text" placeholder="Nhập tên">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="comment">
                                Đánh giá
                            </label>
                            <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="comment" rows="3" placeholder="Nhập đánh giá của bạn"></textarea>
                        </div>
                        <button
                            class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Đăng
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <div class="basis-7/12">
            <div class="py-2 px-3">
                <h4 class="font-bold text-xl text-uppercase">Thông tin chi tiết</h4>
                <article class="my-1 p-3 prose prose-sm prose-p:m-0 bg-gray-100">
                    {!! $service->content !!}
                </article >
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

