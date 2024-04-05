@extends('layouts.home')
@section('content')
<div class="container">
    <x-breadcrumb name="san-pham" :data="['category_name' => $product->category->name,
        'category_title' => $product->category->title, 'product_title' => $product->title]">
    </x-breadcrumb>
    <div class="mt-2 flex flex-row">
        <div class="border-1 basis-5/12 relative w-[40%] bg-white">
            <div id="p-carousel" class="owl-carousel owl-theme p-3">
                <a class="item" data-lightbox="roadtrip" href="{{route('get-image', $product->image_id)}}">
                    <img onerror="this.src='/images/no-image.png'"
                          src="{{route('get-image', $product->image_id)}}"
                          alt="{{$product->keywords}}" />
                </a>
                @if($product->images)
                    @foreach(explode(',',$product->images) as $item)
                        <a class="item" data-lightbox="roadtrip" href="{{route('get-image', $item)}}">
                            <img onerror="this.src='/images/no-image.png'" src="{{route('get-image', $item)}}" />
                        </a>
                    @endforeach
                @endif
            </div>
            @if(count(explode(',', $product->images)) >= 2)
            <div class="flex bg-gray-100">
                @foreach(explode(',', $product->images) as $index => $item)
                    <a class="py-1 px-1">
                        <img onerror="this.src='/images/no-image.png'"
                             src="{{route('get-image-thumbnail', $item)}}"
                             class="flex-none change_image_carousel max-h-[100px]" index="{{$index + 1}}" />
                    </a>
                @endforeach
            </div>
            @endif
        </div>
        <div class="basis-7/12 px-3 ">
            <div class="bg-white p-3">
                <h1 class="text-2xl font-bold">{{ $product->title }}</h1>
                <div class="my-2">
                <h3 class="mr-5 inline-block">
                    <span class="mr-2">Thương hiệu:</span><a class="text-uppercase font-bold text-cyan-600" href="{{route('hang-san-xuat', $product->producer->name)}}">{{ $product->producer->title }}</a>
                </h3>
                <h3 class="inline-block">
                    <span class="mr-2">Mã sản phẩm</span><span class="text-uppercase font-bold text-red-600">{{ $product->sku }}</span>
                </h3>
                </div>
                <hr/>
                @if($product->price > 0)
                    <div class="my-3">
                        <div class="w-full my-4">
                            @if(isset($product->product_option[0]))
                                <div>
                                    <span class="font-bold   text-capitalize"> {{$product->product_option[0]->group_title }}:</span>
                                    <span>
                                    @foreach($product->product_option as $item)
                                        <span class="border-1 px-2 bg-gray-100 pt-1 pb-2 mx-2 rounded">{{ $item->title }} </span>
                                    @endforeach
                                </span>
                                </div>
                            @endif
                        </div>
                        <div class="mr-3">
                            <span class="font-bold"> Giá hãng: </span>
                            <span class="text-gray-700 line-through text-xl">{{ number_format($product->price_pro, 0, ',', '.')}}đ </span>
                        </div>
                        @if($product->price_pro > $product->price)
                        <span>
                            <span class="mr-2">
                                <span class="font-bold">Giá bán:</span>
                                <span class="text-red-600 text-2xl"> {{ number_format($product->price, 0, ',', '.') }}đ</span>
                            </span>
                            <span>
                                <span class="font-bold">Rẽ hơn: </span>
                                <span class="text-xl mr-1"> {{number_format($product->price_pro - $product->price, 0, ',', '.')}}đ </span>
                                <span class="bg-red-500 px-2 py-1 text-white rounded-1 text-sm relative -top-1 mr-1"> {{(int)((($product->price_pro-$product->price)/$product->price)*100)}}%</span>
                                @if($product->instalment)
                                    <span class="bg-gray-500 px-2 py-1 text-white rounded-1 text-sm relative -top-1">Trả góp 0%</span>
                                @endif
                            </span>
                        </span>
                        @endif

                        <div class="my-3">
                            <span class="text-sm font-bold">Hổ trợ từ Công Ty</span>
                            <div class="w-full mt-1 p-2 bg-gray-100 rounded border-1">{!! $product->company_offer !!}</div>
                        </div>
                        <div class="my-3">
                            <span class="text-sm font-bold">Hổ trợ từ Hãng</span>
                            <div class="w-full mt-1 p-2 bg-gray-100 rounded border-1">{!! $product->producer_offer !!}</div>
                        </div>
                    </div>
                    <div class="w-full my-4">
                        <a class="px-3 py-2 rounded-2 bg-red-500 text-white hover:bg-red-600 mr-3"
                           onclick="addCart(this, {id: {{$product->id}}, quantity: 1},'dat-hang')"
                           href="javascript:void(0)" ><i class="bi bi-bag-check"></i>
                            <span>Mua ngay</span>
                        </a>
                        <a class="px-3 py-2 rounded-2 bg-yellow-500 text-white hover:bg-yellow-700"
                           onclick="addCart(this, {id: {{$product->id}}, quantity: 1})"
                           href="javascript:void(0)"><i class="bi bi-cart mr-1"></i>Add cart</a>
                    </div>

                @else
                    <div class="my-3">
                        <h3 class="text-sm font-bold">Hổ trợ từ Công Ty</h3>
                        <div class="w-full mt-1 p-2 bg-gray-100 rounded border-1">{!! $product->company_offer !!}</div>
                    </div>
                    <div class="my-3">
                        <h3 class="text-sm font-bold">Hổ trợ từ Hãng</h3>
                        <div class="w-full mt-1 p-2 bg-gray-100 rounded border-1">{!! $product->producer_offer !!}</div>
                    </div>
                    <div class="w-full py-2 font-bold"><span class="text-red-600 text-sm "> Liên hệ </span></div>
                @endif
            </div>

        </div>
    </div>
    <div class="flex mt-3">
        <div class="basis-7/12 mr-3">
            <div class="py-2">
                <h3 class="font-bold text-xl text-uppercase">Chi tiết sản phẩm</h3>
                <article class="my-1 p-3 prose prose-sm prose-p:m-0 bg-white border-1">
                    {!! $product->content !!}
                </article >
            </div>
        </div>
        <div class="basis-5/12">
            <div class="py-2">
                <h3 class="font-bold text-xl text-uppercase">Thông số kỹ thuật</h3>
                <div class="p-3 text-sm border-1 my-1 prose m-auto prose-p:m-0 bg-white">
                    {!! $product->description !!}
                </div>
            </div>
            <div class="py-2 ">
                <h4 class="font-bold text-xl text-uppercase">Đánh giá</h4>
                <div class="my-1 bg-white p-3 border-1">
                    <div class="flex flex-col space-y-4">
                        <div class="bg-white p-3 rounded-lg shadow-md">
                            <h5 class="font-bold inline-block">Hương</h5>
                            <span class="float-right text-gray-700 text-xs mb-2 p-2">Mua ngày 15 - 04 - 2024</span>
                            <p class="clear-both text-gray-700 text-sm pl-2">Sản phẩm tốt lắp đặt nhanh</p>
                        </div>
                        <form class="bg-white p-3 rounded-lg shadow-md">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="name">
                                    Tên
                                </label>
                                <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="name" type="text" placeholder="Nhập tên">
                            </div>
                            <div class="mb-3">
                                <label class="block text-gray-700 font-bold mb-2" for="comment">
                                    Đánh giá
                                </label>
                                <textarea
                                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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
    </div>
    <x-title-block title="Sản phẩm cùng loại"></x-title-block>
    <div class="-mx-2 product-carousel owl-carousel owl-theme mb-3">
        @foreach ($c_product as $item)
            <x-product-carousel-item :item="$item"/>
        @endforeach
    </div>
    <script>
        $(window).load(function() {
            var owl = $('#p-carousel').owlCarousel({
                loop:true,
                margin:10,
                responsive:{
                    1000:{
                        items:1
                    },
                }
            })
            $('.change_image_carousel').on('click', function(e) {
                owl.trigger('to.owl.carousel', $(e.target).attr('index'));
                $('.change_image_carousel').parent().removeClass('bg-gray-300')
                $(e.target).parent().addClass('bg-gray-300')
            })
        });
    </script>
</div>

@endsection

