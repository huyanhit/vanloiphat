@extends('layouts.home')
@section('content')
<div class="container">
    <x-breadcrumb name="san-pham" :data="['category_name' => $product->category->name,
        'category_title' => $product->category->title, 'product_title' => $product->title]">
    </x-breadcrumb>
    <div class="mt-2 block lg:flex flex-row">
        <div class="border-1 basis-5/12 relative w-full lg:w-[40%] bg-white">
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
        <div class="basis-7/12 px-0 lg:px-3">
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

                        @if($product->price_pro > $product->price)
                        <div class="mr-3">
                            <span class="font-bold"> Giá hãng: </span>
                            <span class="text-gray-700 line-through text-xl">{{ number_format($product->price_pro, 0, ',', '.')}}đ </span>
                        </div>
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
                        @elseif($product->price > 0)
                            <span>
                                <span class="mr-2">
                                    <span class="font-bold">Giá bán:</span>
                                    <span class="text-red-600 text-2xl"> {{ number_format($product->price, 0, ',', '.') }}đ</span>
                                </span>
                                @if($product->instalment)
                                    <span class="bg-gray-500 px-2 py-1 text-white rounded-1 text-sm relative -top-1">Trả góp 0%</span>
                                @endif
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
                        <a class="px-3 py-2 rounded-2 bg-yellow-500 text-white hover:bg-red-600 mr-3"
                           onclick="addCart(this, {id: {{$product->id}}, quantity: 1},'dat-hang')"
                           href="javascript:void(0)"><i class="bi bi-bag-check mr-1 relative -top-[1px]"></i><span>Mua ngay</span>
                        </a>
                        <a class="px-3 py-2 add-cart rounded-2 bg-red-500 text-white hover:bg-yellow-700"
                           onclick="addCart(this, {id: {{$product->id}}, quantity: 1})"
                           href="javascript:void(0)"><i class="bi bi-cart mr-1  relative -top-[1px]"></i><span>Thêm vào giỏ</span>
                        </a>
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
    <div class="block lg:flex mt-3">
        <div class="basis-7/12 mr-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-gray-400 hover:text-gray-700 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                        <h3 class="font-bold text-sm lg:text-xl text-uppercase">Chi tiết</h3>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-gray-400 hover:text-gray-700" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        <h3 class="font-bold text-sm lg:text-xl text-uppercase">Bảo hành</h3>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-gray-400 hover:text-gray-700" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                        <h3 class="font-bold text-sm lg:text-xl text-uppercase">Chứng nhận</h3>
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                        {!! $product->content !!}
                    </article >
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                        {!! $product->warning !!}
                    </article >
                </div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                    <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                        {!! $product->certificate !!}
                    </article >
                </div>
            </div>
        </div>
        <div class="basis-5/12">
            <div class="py-2">
                <h3 class="font-bold text-xl text-uppercase">Thông số kỹ thuật</h3>
                <div class="p-3 text-sm border-1 my-1 prose m-auto prose-p:m-0 bg-white">
                    {!! $product->description !!}
                </div>
            </div>
            <x-comment-block comment=""></x-comment-block>
        </div>
    </div>
    <x-title-block title="Sản phẩm cùng loại"></x-title-block>
    <div class="mx-0 lg:-mx-2 product-carousel owl-carousel owl-theme mb-3">
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
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
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

