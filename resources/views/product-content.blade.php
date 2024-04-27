@extends('layouts.home')
@section('content')
<div class="container">
    <x-breadcrumb name="san-pham" :data="['category_name' => $product->category->name,
        'category_title' => $product->category->title, 'product_title' => $product->title]">
    </x-breadcrumb>
    <div class="mt-2 block lg:flex flex-row">
        <div class="basis-5/12 relative mr-3 w-full lg:w-[40%] bg-white">
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
                    <h3 class="mr-2 inline-block">
                        <span class="font-bold">Mã sản phẩm:</span>
                        <span class="text-uppercase font-bold text-red-600"><a href="{{route('san-pham', $product->slug)}}"> {{ $product->sku }}</a></span>
                    </h3>
                    <h3 class="mr-2 inline-block">
                        <span class="font-bold">Thương hiệu:
                        </span><a class="text-uppercase font-bold text-cyan-600" href="{{route('hang-san-xuat', $product->producer->name)}}">{{ $product->producer->title }}</a>
                    </h3>
                    <span class="mr-2 font-bold pt-[6px]">Bảo hành:
                        <span class="text-cyan-600">{{$product->warning_time}} Tháng</span>
                    </span>
                </div>
                <div class="flex mb-2">
                    <span class="font-bold pt-[6px] mr-3">Đánh giá:</span>
                    @if(!$product->comment->isEmpty())
                        <span class="flex items-center mr-1 pt-[2px]">
                            @php
                                $avg = $product->comment->pluck('rating')->avg();
                            @endphp
                            @for($i = 0; $i<5; $i++)
                                <i class="bi bi-star-fill {{($i < round($avg))? 'text-yellow-500': ''}} mr-1"></i>
                            @endfor
                        </span>
                        <span class="mr-2 pt-[7px] cursor-pointer text-cyan-600" onclick="scrollComment()">{{$avg}}/{{$product->comment->count()}}</span>
                    @else
                        <span class="mr-2 pt-[6px]">Chưa có</span>
                    @endif
                    <span class="px-2 pt-[5px]">
                        <span onclick="scrollComment()" class="cursor-pointer text-cyan-600"><i class="bi bi-chat-dots text-lg"></i></span>
                        <span class="mr-2 text-lg text-cyan-600">{{$product->comment->count()}} </span>
                        <span><i class="bi bi-eye text-lg"></i> </span><span class="mr-2 text-lg">{{ $product->view }}</span>
                    </span>
                </div>
                <hr/>
                @if($product->price > 0)
                    <div class="my-3">
                        <div class="w-full my-2">
                            @if(isset($product->product_option[0]))
                                <div>
                                    <span class="font-bold text-capitalize"> {{$product->product_option[0]->group_title }}:</span>
                                    <span class="cursor-pointer">
                                    @foreach($product->product_option as $item)
                                        @php $item->price = $item->price?? $product->price @endphp
                                        <span class="border-1 px-2 bg-cyan-50 pt-1 pb-2 mx-2 inline-block text-center options-items"
                                            onclick="updateCartOptions(this, {{'{id:'.$item->id.', price:'. $item->price .'}'}})">
                                            <div class="font-bold"> {{ $item->title }} </div>
                                            @if($item->price > 0)
                                                <div> Giá: {{ number_format($item->price, 0, ',', '.')}} ₫</div>
                                            @endif
                                        </span>
                                    @endforeach
                                    </span>
                                </div>
                            @endif
                        </div>

                        @if($product->price_pro > $product->price)
                        <div class="mr-3">
                            <span class="font-bold">Giá niêm yết: </span>
                            <span class="text-gray-700 line-through text-xl">{{ number_format($product->price_pro, 0, ',', '.')}} ₫ </span>
                        </div>
                        <span>
                            <span class="mr-2">
                                <span class="font-bold">Giá bán: </span>
                                <span class="text-red-600 text-2xl font-bold" id="price_product"> {{ number_format($product->price, 0, ',', '.') }} ₫</span>
                            </span>
                            <span>
                                <span class="font-bold">Tiết kiệm: </span>
                                <span class="text-xl mr-1"> {{number_format($product->price_pro - $product->price, 0, ',', '.')}} ₫ </span>
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
                                    <span class="text-red-600 text-3xl font-bold" id="price_product"> {{ number_format($product->price, 0, ',', '.') }} ₫</span>
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
                        <a class="inline-block text-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 text-sm
                       px-5 py-3 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"
                           onclick="addCart(this, {id: {{$product->id}}},'dat-hang')">
                            <i class="bi bi-bag-check mr-2 relative -top-[1px]"></i><span class="font-bold uppercase">Đặt hàng ngay</span></a>
                        <button class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 text-sm
                        px-5 py-3 me-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-cyan-800"
                                onclick="addCart(this, {id: {{$product->id}}})"> <i class="bi bi-cart mr-1 relative -top-[1px]"></i>
                            <span class="inline-block font-bold uppercase">Thêm vào giỏ</span>
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
    </div>
    <div class="block lg:flex my-3">
        <div class="w-full lg:w-[60%] mr-0 lg:mr-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-gray-400 hover:text-gray-700 active" id="ct-tab" data-bs-toggle="tab" data-bs-target="#ct-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                        <h3 class="font-bold text-sm lg:text-lg uppercase">Chi tiết</h3>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-gray-400 hover:text-gray-700" id="ts-tab" data-bs-toggle="tab" data-bs-target="#ts-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                        <h3 class="font-bold text-sm lg:text-lg uppercase">Thông số</h3>
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
                <div class="tab-pane fade show active" id="ct-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <article class="p-3 prose prose-sm prose-p:m-0 bg-white ">
                        {!! $product->content !!}
                    </article >
                </div>
                <div class="tab-pane fade" id="ts-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <article class="p-3 prose prose-sm prose-p:m-0 bg-white ">
                        {!! $product->description !!}
                    </article >
                </div>
                <div class="tab-pane fade" id="bh-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <article class="p-3 prose prose-sm prose-p:m-0 bg-white ">
                        {!! $product->warning !!}
                    </article >
                </div>
                <div class="tab-pane fade" id="cn-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                    <article class="p-3 prose prose-sm prose-p:m-0 bg-white ">
                        {!! $product->certificate !!}
                    </article >
                </div>
            </div>
            <x-comment-block :data="['product_id' => $product->id]"></x-comment-block>
        </div>
        <div class="w-full lg:w-[40%] p-3 relative" id="box-contain">
            <div class="px-3 py-4 bg-white shadow-md border-2 border-cyan-700 relative" id="box-tv">
                <h3 class="text-xl text-cyan-700 px-3 dark:text-white bg-white border-2 border-cyan-700 absolute -top-5 font-bold uppercase text-center">Tư vấn</h3>
                <div class="text-sm font-bold uppercase">{{ $product->title }}</div>
                <div class="mr-2 mb-2">
                    <span class="mr-2">
                        <span class="mr-2">Thương hiệu:</span><a class="text-uppercase text-cyan-600" href="{{route('hang-san-xuat', $product->producer->name)}}">{{ $product->producer->title }}</a>
                    </span>
                    <span class="mr-2">
                        <span class="mr-2">Mã sản phẩm</span><span class="text-uppercase text-red-600"><a href="{{route('san-pham', $product->slug)}}"> {{ $product->sku }}</a></span>
                    </span><br/>
                    <span> Giá bán: </span>
                    <span class="text-red-600 text-2xl mr-3"> {{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    @if($product->instalment)
                        <span class="bg-gray-500 px-2 py-1 text-white rounded-1 text-sm relative -top-1">Trả góp 0%</span>
                    @endif
                </div>
                <hr/>
                <div class="mt-2 font-bold text-sm text-gray-700">
                    Bạn còn  ₫iều gì chưa rõ về sản phẩm? <br/>Hãy gửi thông tin cho chúng tôi, Chúng tôi sẻ tư vấn cho Bạn.
                </div>
                <div class="p-2 border-1 my-2 h-[200px] overflow-y-auto">
                    <div class="flex mt-1">
                        <input type="checkbox" name="box_content" value="1"  class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                               id="box-cv-1">
                        <label for="box-cv-1" class="text-sm ms-2 text-gray-700 dark:text-gray-400">
                            Sản phẩm này có phù hợp với nguồn nước mà tôi  ₫ang dùng không?
                        </label>
                    </div>
                    <div class="flex mt-1">
                        <input type="checkbox" name="box_content" value="2" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                               id="box-cv-2" >
                        <label for="box-cv-2" class="text-sm text-gray-700 ms-2 dark:text-gray-400">
                            Tôi Sử dụng bao lâu thì phải thay lại lõi lọc?
                        </label>
                    </div>
                    <div class="flex mt-1">
                        <input type="checkbox" name="box_content" value="3"
                               class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                               id="box-cv-3" >
                        <label for="box-cv-3" class="text-sm text-gray-700 ms-2 dark:text-gray-400">
                            Sản phẩm có nâng cấp khả năng lọc  ₫ược không?
                        </label>
                    </div>
                    <div class="flex mt-1">
                        <input type="checkbox" name="box_content" value="4" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                               id="box-cv-4" >
                        <label for="box-cv-4" class="text-sm text-gray-700 ms-2 dark:text-gray-400">
                            Khi lắp  ₫ặt xong thì có kiểm tra lại nước  ₫ã  ₫ủ chất lượng sử dụng không?
                        </label>
                    </div>
                    <div class="flex mt-1">
                        <input type="checkbox" name="box_content" value="5" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700
                                dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                               id="box-cv-5" >
                        <label for="box-cv-5" class="text-sm text-gray-700 ms-2 dark:text-gray-400">
                            Mua trả góp tôi cần chuẩn bị giấy tờ gì?
                        </label>
                    </div>
                    <div class="flex mt-1">
                        <input type="checkbox" name="box_content" onclick="showOrder(this)"  class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                               id="box-cv-order" value='order'>
                        <label for="box-cv-order" class="w-full text-sm text-gray-700 ms-2 dark:text-gray-400">
                            Một số vấn  ₫ề khác.
                            <textarea id="order-area" name="box_area" class="block w-full my-2 border-1 border-gray-300 hidden" rows="1"></textarea>
                        </label>
                    </div>
                </div>
                <div class="flex">
                    <span class="basis-2/3"><input id="box_email_phone" class="w-full appearance-none h-[40px] text-sm"
                                 type="text" placeholder="Nhập số  ₫iện thoại hoặc email của bạn." autocomplete="off"></span>
                    <button class="ml-2 basis-1/3 text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 text-sm
                            py-2.5  mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-blue-800"
                            onclick="sendMessage()">Tư vấn cho tôi </button>
                </div>
                <div class="flex">
                    <a href="tel:{{$sites->hotline}}" class="text-center basis-1/2 w-full text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 text-sm
                        px-2 py-2.5 me-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-cyan-800 uppercase">
                        Hotline tư vấn <br/> <span class="font-bold text-lg leading-[16px]">{{$sites->hotline}} </span>
                    </a>
                    <a class="text-center basis-1/2 w-full text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 text-sm
                        px-2 py-2.5 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:outline-none dark:focus:ring-cyan-800 uppercase"
                        href="/lien-he?noi-dung=Thông báo cho tôi khi có ưu  ₫ãi sản phẩm: {{$product->title}}">
                        Thông báo cho tôi <br><span class="font-bold uppercase">Khi có ưu đãi.</span></a>
                </div>
                <div class="flex">
                    <a href="{{route('so-sanh', Str::slug($product->title).'-'.$product->id )}}" class="text-center basis-1/2 w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 text-sm
                       px-2 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800 uppercase">
                        So sánh với <br> <span class="font-bold">Sản phẩm khác</span></a>
                    <button class="basis-1/2 w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-green-300 text-sm
                        px-2 py-2.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 uppercase"
                        onclick="addCart(this, {id: {{$product->id}}},'dat-hang')">
                        <span class="font-bold">Đặt hàng ngay</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <x-title-block title="Sản phẩm cùng loại"></x-title-block>
    <div class="mx-0 lg:-mx-2 product-carousel owl-carousel owl-theme mb-3 bg-white">
        @foreach ($c_product as $item)
            <x-product-carousel-item :item="$item"/>
        @endforeach
    </div>
    <script>
        function sendMessage(){
            let name = $('h1').text();
            let contact = $('#box_email_phone').val();
            let content = '';
            $('[name="box_content"]:checked').each((e, item) => {
                if($(item).val() === 'order'){
                    content += $('#order-area').val().trim() + '<br\>';
                }else {
                    content += $(item).next().text().trim()+ '<br\>';
                }
            });

            if(contact.trim() === ''){
                $('#box_email_phone').addClass('border-1 border-red-700 text-red-700');
                $('#box_email_phone').attr('placeholder','Bạn chưa nhập số ₫iện thoai hoặc Email');
            }else {
                ajaxUpdateMessage(name, contact, content);
            }
        }

        function ajaxUpdateMessage(name, contact, content){
            $.ajax({
                type: 'post',
                url: '/lien-he',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    'name': name,
                    'contact': contact,
                    'content': content
                }
            }).done(function(){
                alert('Gửi thành công, Chúng tôi sẻ liên hệ lại sớm.')
            });
        }

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

