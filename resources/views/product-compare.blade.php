@extends('layouts.home')
@section('content')
<div class="container">
    <x-breadcrumb name="san-pham" :data="['category_name' => $product->category->name,
        'category_title' => $product->category->title, 'product_title' => $product->title]">
    </x-breadcrumb>
    <div class="row bg-white p-2">
        <div class="col-lg-5">
            <h1 class="text-2xl font-bold text-center p-2">{{ $product->title }}</h1>
        </div>
        <div class="col-lg-2">
            <h2 class="text-2xl font-bold text-center p-2 text-red-600">VS</h2>
        </div>
        <div class="col-lg-5 ">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Tìm</label>
            <div class="relative search-compare">
                <div class="inset-y-0 absolute start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" onkeyup="getProductCompare(this, {{$product->id}})" autocomplete="off"
                       value="{{ !empty($product2)?$product2->title:'' }}"
                       class="inline-block w-full pl-[40px] py-3 text-sm text-gray-900 border border-gray-300 rounded-lg
                bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nhập vào Tên sản phẩm cần tìm."  />
            </div>
            <div class="relative" id="list-compare"></div>
        </div>
        <div class="col-lg-6">
            <div class="px-0 mt-2">
                <div class="bg-white">
                    <div class="my-2">
                        <h3 class="mr-2 inline-block">
                            <span class="font-bold">Mã sản phẩm:</span>
                            <span class="text-uppercase font-bold text-red-600">{{ $product->sku }}</span>
                        </h3>
                        <h3 class="mr-2 inline-block">
                        <span class="font-bold">Thương hiệu:
                        </span><a class="text-uppercase font-bold text-cyan-600" href="{{route('hang-san-xuat', $product->producer->name)}}">{{ $product->producer->title }}</a>
                        </h3>
                        <span class="mr-2 font-bold pt-[6px]">Bảo hành:
                        <span class="text-cyan-600">36 tháng</span>
                    </span>
                    </div>
                    <div class="flex mb-2">
                        <span class="font-bold pt-[6px] mr-3"> Đánh giá </span>
                        <span class="flex items-center mr-2 pt-[2px]">
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                    </span>
                        <span class="px-2 pt-[5px]">
                        <span onclick="scrollComment()" class="cursor-pointer"><i class="bi bi-chat-dots text-lg"></i> </span>
                        <span class="mr-2 text-cyan-600"> 1 </span>
                        <span><i class="bi bi-eye text-lg"></i> </span><span class="mr-2">  1000 </span>
                    </span>
                    </div>
                    <hr/>
                    @if($product->price > 0)
                        <div class="my-3">
                            <div class="w-full my-2">
                                @if(isset($product->product_option[0]))
                                    <div>
                                        <span class="font-bold text-capitalize"> {{$product->product_option[0]->group_title }}:</span>
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
                                    <span class="font-bold">Giá niêm yết: </span>
                                    <span class="text-gray-700 line-through text-xl">{{ number_format($product->price_pro, 0, ',', '.')}}đ </span>
                                </div>
                                <span>
                            <span class="mr-2">
                                <span class="font-bold">Giá bán: </span>
                                <span class="text-red-600 text-2xl"> {{ number_format($product->price, 0, ',', '.') }}đ</span>
                            </span>
                            <span>
                                <span class="font-bold">Tiết kiệm: </span>
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
                                    <span class="text-red-600 text-3xl"> {{ number_format($product->price, 0, ',', '.') }}đ</span>
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
                            <a href="tel:{{$sites->hotline}}" class="inline-block text-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 text-sm
                       px-5 py-3 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"
                               onclick="addCart(this, {id: {{$product->id}}, quantity: 1},'dat-hang')">
                                <i class="bi bi-bag-check mr-2 relative -top-[1px]"></i><span class="font-bold">Đặt hàng ngay</span></a>
                            <button class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 text-sm
                        px-5 py-3 me-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-cyan-800"
                                    onclick="addCart(this, {id: {{$product->id}}, quantity: 1})"> <i class="bi bi-cart mr-1 relative -top-[1px]"></i>
                                <span class="inline-block font-bold">Thêm vào giỏ</span>
                            </button>
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
            <div class="mt-2 row">
                <div class="col-lg-2">
                    @if(count(explode(',', $product->images)) >= 2)
                        <div class="flex flex-col bg-gray-100 m-auto">
                            @foreach(explode(',', $product->images) as $index => $item)
                                <a class="py-1 px-1 block text-center">
                                    <img onerror="this.src='/images/no-image.png'"
                                         src="{{route('get-image-thumbnail', $item)}}"
                                         class="inline-block change_image_carousel max-h-[100px]" index="{{$index + 1}}" />
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-lg-10 bg-white text-center m-auto">
                    <div id="pc-carousel" class="owl-carousel owl-theme p-3 m-auto">
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
                </div>
            </div>
            <div class="mt-2 ">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-gray-400 hover:text-gray-700 active" id="ts-tab" data-bs-toggle="tab" data-bs-target="#ts-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                            <h3 class="font-bold text-sm lg:text-lg uppercase">Thông số</h3>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-gray-400 hover:text-gray-700" id="ct-tab" data-bs-toggle="tab" data-bs-target="#ct-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                            <h3 class="font-bold text-sm lg:text-lg uppercase">Chi tiết</h3>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-gray-400 hover:text-gray-700" id="bh-tab" data-bs-toggle="tab" data-bs-target="#bh-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                            <h3 class="font-bold text-sm lg:text-lg uppercase">Bảo hành</h3>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-gray-400 hover:text-gray-700" id="cn-tab" data-bs-toggle="tab" data-bs-target="#cn-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                            <h3 class="font-bold text-sm lg:text-lg uppercase">Chứng nhận</h3>
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="ts-tab-pane active" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                            {!! $product->description !!}
                        </article >
                    </div>
                    <div class="tab-pane fade show" id="ct-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                            {!! $product->content !!}
                        </article >
                    </div>
                    <div class="tab-pane fade" id="bh-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                            {!! $product->warning !!}
                        </article >
                    </div>
                    <div class="tab-pane fade" id="cn-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                            {!! $product->certificate !!}
                        </article >
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            @if(!empty($product2))
            <div class="px-0 mt-2">
                <div class="bg-white">
                    <div class="my-2">
                        <h3 class="mr-2 inline-block">
                            <span class="font-bold">Mã sản phẩm:</span>
                            <span class="text-uppercase font-bold text-red-600">{{ $product2->sku }}</span>
                        </h3>
                        <h3 class="mr-2 inline-block">
                        <span class="font-bold">Thương hiệu:
                        </span><a class="text-uppercase font-bold text-cyan-600" href="{{route('hang-san-xuat', $product2->producer->name)}}">{{ $product2->producer->title }}</a>
                        </h3>
                        <span class="mr-2 font-bold pt-[6px]">Bảo hành:
                        <span class="text-cyan-600">36 tháng</span>
                    </span>
                    </div>
                    <div class="flex mb-2">
                        <span class="font-bold pt-[6px] mr-3"> Đánh giá </span>
                        <span class="flex items-center mr-2 pt-[2px]">
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                        <i class="bi bi-star-fill text-yellow-500 mr-1"></i>
                    </span>
                        <span class="px-2 pt-[5px]">
                        <span onclick="scrollComment()" class="cursor-pointer"><i class="bi bi-chat-dots text-lg"></i> </span>
                        <span class="mr-2 text-cyan-600"> 1 </span>
                        <span><i class="bi bi-eye text-lg"></i> </span><span class="mr-2">  1000 </span>
                    </span>
                    </div>
                    <hr/>
                    @if($product2->price > 0)
                        <div class="my-3">
                            <div class="w-full my-2">
                                @if(isset($product2->product_option[0]))
                                    <div>
                                        <span class="font-bold text-capitalize"> {{$product2->product_option[0]->group_title }}:</span>
                                        <span>
                                    @foreach($product2->product_option as $item)
                                                <span class="border-1 px-2 bg-gray-100 pt-1 pb-2 mx-2 rounded">{{ $item->title }} </span>
                                            @endforeach
                                </span>
                                    </div>
                                @endif
                            </div>

                            @if($product2->price_pro > $product2->price)
                                <div class="mr-3">
                                    <span class="font-bold">Giá niêm yết: </span>
                                    <span class="text-gray-700 line-through text-xl">{{ number_format($product2->price_pro, 0, ',', '.')}}đ </span>
                                </div>
                                <span>
                            <span class="mr-2">
                                <span class="font-bold">Giá bán: </span>
                                <span class="text-red-600 text-2xl"> {{ number_format($product2->price, 0, ',', '.') }}đ</span>
                            </span>
                            <span>
                                <span class="font-bold">Tiết kiệm: </span>
                                <span class="text-xl mr-1"> {{number_format($product2->price_pro - $product2->price, 0, ',', '.')}}đ </span>
                                <span class="bg-red-500 px-2 py-1 text-white rounded-1 text-sm relative -top-1 mr-1"> {{(int)((($product2->price_pro-$product2->price)/$product2->price)*100)}}%</span>
                                @if($product2->instalment)
                                    <span class="bg-gray-500 px-2 py-1 text-white rounded-1 text-sm relative -top-1">Trả góp 0%</span>
                                @endif
                            </span>
                        </span>
                            @elseif($product2->price > 0)
                                <span>
                                <span class="mr-2">
                                    <span class="font-bold">Giá bán:</span>
                                    <span class="text-red-600 text-3xl"> {{ number_format($product2->price, 0, ',', '.') }}đ</span>
                                </span>
                                @if($product2->instalment)
                                        <span class="bg-gray-500 px-2 py-1 text-white rounded-1 text-sm relative -top-1">Trả góp 0%</span>
                                    @endif
                            </span>
                            @endif

                            <div class="my-3">
                                <span class="text-sm font-bold">Hổ trợ từ Công Ty</span>
                                <div class="w-full mt-1 p-2 bg-gray-100 rounded border-1">{!! $product2->company_offer !!}</div>
                            </div>
                            <div class="my-3">
                                <span class="text-sm font-bold">Hổ trợ từ Hãng</span>
                                <div class="w-full mt-1 p-2 bg-gray-100 rounded border-1">{!! $product2->producer_offer !!}</div>
                            </div>
                        </div>
                        <div class="w-full my-4">
                            <a href="tel:{{$sites->hotline}}" class="inline-block text-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 text-sm
                       px-5 py-3 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"
                               onclick="addCart(this, {id: {{$product2->id}}, quantity: 1},'dat-hang')">
                                <i class="bi bi-bag-check mr-2 relative -top-[1px]"></i><span class="font-bold">Đặt hàng ngay</span></a>
                            <button class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 text-sm
                        px-5 py-3 me-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-cyan-800"
                                    onclick="addCart(this, {id: {{$product2->id}}, quantity: 1})"> <i class="bi bi-cart mr-1 relative -top-[1px]"></i>
                                <span class="inline-block font-bold">Thêm vào giỏ</span>
                            </button>
                        </div>
                    @else
                        <div class="my-3">
                            <h3 class="text-sm font-bold">Hổ trợ từ Công Ty</h3>
                            <div class="w-full mt-1 p-2 bg-gray-100 rounded border-1">{!! $product2->company_offer !!}</div>
                        </div>
                        <div class="my-3">
                            <h3 class="text-sm font-bold">Hổ trợ từ Hãng</h3>
                            <div class="w-full mt-1 p-2 bg-gray-100 rounded border-1">{!! $product2->producer_offer !!}</div>
                        </div>
                        <div class="w-full py-2 font-bold"><span class="text-red-600 text-sm "> Liên hệ </span></div>
                    @endif
                </div>
            </div>
            <div class="mt-2 row">
                <div class="col-lg-2">
                    @if(count(explode(',', $product2->images)) >= 2)
                        <div class="flex flex-col bg-gray-100 m-auto">
                            @foreach(explode(',', $product2->images) as $index => $item)
                                <a class="py-1 px-1 block text-center">
                                    <img onerror="this.src='/images/no-image.png'"
                                         src="{{route('get-image-thumbnail', $item)}}"
                                         class="inline-block change_image_carousel2 max-h-[100px]" index="{{$index + 1}}" />
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-lg-10 bg-white text-center m-auto">
                    <div id="pc-carousel2" class="owl-carousel owl-theme p-3 m-auto">
                        <a class="item" data-lightbox="roadtrip" href="{{route('get-image', $product2->image_id)}}">
                            <img onerror="this.src='/images/no-image.png'"
                                 src="{{route('get-image', $product2->image_id)}}"
                                 alt="{{$product2->keywords}}" />
                        </a>
                        @if($product2->images)
                            @foreach(explode(',',$product2->images) as $item)
                                <a class="item" data-lightbox="roadtrip" href="{{route('get-image', $item)}}">
                                    <img onerror="this.src='/images/no-image.png'" src="{{route('get-image', $item)}}" />
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-2 ">
                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-gray-400 hover:text-gray-700 active" id="ts-tab2" data-bs-toggle="tab" data-bs-target="#ts-tab-pane2" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                            <h3 class="font-bold text-sm lg:text-lg uppercase">Thông số</h3>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-gray-400 hover:text-gray-700" id="ct-tab2" data-bs-toggle="tab" data-bs-target="#ct-tab-pane2" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                            <h3 class="font-bold text-sm lg:text-lg uppercase">Chi tiết</h3>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-gray-400 hover:text-gray-700" id="bh-tab2" data-bs-toggle="tab" data-bs-target="#bh-tab-pane2" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                            <h3 class="font-bold text-sm lg:text-lg uppercase">Bảo hành</h3>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-gray-400 hover:text-gray-700" id="cn-tab2" data-bs-toggle="tab" data-bs-target="#cn-tab-pane2" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                            <h3 class="font-bold text-sm lg:text-lg uppercase">Chứng nhận</h3>
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent2">
                    <div class="tab-pane fade" id="ts-tab-pane2 active" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                            {!! $product2->description !!}
                        </article >
                    </div>
                    <div class="tab-pane fade show" id="ct-tab-pane2" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                            {!! $product2->content !!}
                        </article >
                    </div>
                    <div class="tab-pane fade" id="bh-tab-pane2" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                            {!! $product2->warning !!}
                        </article >
                    </div>
                    <div class="tab-pane fade" id="cn-tab-pane2" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <article class="p-3 prose prose-sm prose-p:m-0 bg-white border-1 border-top-0">
                            {!! $product2->certificate !!}
                        </article >
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    function getProductCompare(elem, id){
        $.ajax({
            type: 'GET',
            url: '/tim-san-pham-cung-loai',
            contentType: "application/json",
            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
            data:{
                'id' : id,
                'search': $(elem).val()
            }
        }).done(function(response){
            updateSearchCompare(response);
        });
    }

    function updateSearchCompare(response){
        let products = response.list;
        let product  = response.product;
        let html = '<ul class="text-sm text-gray-700 dark:text-gray-200 w-full p-3 absolute top-1 border-1 bg-white z-50">';
        for (const key in products) {
            html += '<li>' +
                '<a type="button" href="/so-sanh/'+ product.slug + '/' + products[key].slug +'"' +
                'class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">'+
                    products[key].title
                '</a>' +
            '</li>' ;
        }

        if(Object.keys(products).length > 0){
            $('#list-compare').html(html +'</ul>');
        }else {
            $('#list-compare').html('');
        }
    }

    $(window).load(function() {
        $('#pc-carousel').owlCarousel({
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

        $('#pc-carousel2').owlCarousel({
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
        $('.change_image_carousel2').on('click', function(e) {
            owl.trigger('to.owl.carousel', $(e.target).attr('index'));
            $('.change_image_carousel2').parent().removeClass('bg-gray-300')
            $(e.target).parent().addClass('bg-gray-300')
        })
    });
</script>
@endsection

