@props(['item' => null])
<div class="2xl:w-[20%] xl:w-[25%] lg:w-[33.3%] md:w-[50%] inline-block float-left p-2">
    <div class="product_item shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)]">
        <a class="image text-center block" href="{{route('san-pham', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}">
            <img class="h-[300px] inline-block"
                 onerror="this.src='/images/no-image.png'"
                 src="{{ route('get-image-thumbnail', $item->image_id) }}"
                 alt="{{ $item->keywords }}">
        </a>
        <div class="bg-gray-100 h-[120px] relative">
            <h3 class="text-sm px-2">
                <a href="{{route('san-pham', Str::slug($item->title))}}-{{$item->id}}" title="{{ $item->title }}">
                    <strong>{{ $item->title }}</strong>
                </a>
            </h3>
            @if($item->price > 0)
            <div class="font-bold px-2">
                <div class="text-red-600 mr-2">
                    <span class="text-sm"> Giá: </span>{{ number_format($item->price, 0, ',', '.') }}đ</div>
                <div>
                    @if($item->price_pro > $item->price)
                        <del class="text-gray-600 mr-2">{{ number_format($item->price_pro, 0, ',', '.') }}đ </del>
                        <span class="bg-red-500 px-2 rounded-2 text-white text-sm"> {{(int)((($item->price_pro-$item->price)/$item->price)*100)}}% </span>
                    @endif
                </div>
            </div>
            <div class="absolute bottom-1 w-full p-2">
                <a class="btn add-cart float-right px-2 rounded-2 bg-red-500 text-white hover:bg-red-600 text-xs"
                   onclick="addCart(this, {id: {{$item->id}}, quantity: 1})"
                   href="javascript:void(0)"><i class="bi bi-cart relative -top-[1px]"></i><span> Thêm vào giỏ</span></a>
            </div>
            @else
            <div class="absolute bottom-1 w-full p-2"><span class="text-red-600 text-sm "> Liên hệ </span></div>
            @endif
        </div>
    </div>
</div>
