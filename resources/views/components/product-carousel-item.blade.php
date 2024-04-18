@props(['item' => null])
<div class="p-2">
    <div class="shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)]">
        <a class="image" href="{{route('san-pham', $item->slug)}}" title="{{ $item->title }}">
            <img class="min-h-[300px] w-full" onerror="this.src='/images/no-image.png'"  src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}">
        </a>
        <div class="bg-gray-100 h-[100px] relative">
            <h3 class="text-sm px-2">
                <a href="{{route('san-pham', $item->slug)}}" title="{{ $item->title }}">
                    <strong>{{ $item->title }}</strong>
                </a>
            </h3>
            @if($item->price > 0)
            <div class="font-bold px-2">
                <div class="text-red-600 mr-2">
                    <span class="text-sm"> Giá: </span>{{ number_format($item->price, 0, ',', '.') }}đ</div>
                <div>
                    @if($item->price_pro > $item->price)
                        <span class="text-gray-600 line-through mr-2">{{ number_format($item->price_pro, 0, ',', '.') }}đ </span>
                        <span class="bg-red-500 px-2 rounded-2 text-white text-sm"> {{(int)((($item->price_pro-$item->price)/$item->price)*100)}}% </span>
                    @endif
                </div>
            </div>
            <div class="absolute bottom-1 w-full p-2">
                <a class="btn add-cart float-right px-3 rounded-2 bg-red-500 text-white hover:bg-red-600 text-sm"
                   onclick="addCart(this, {id: {{$item->id}}})"
                   href="javascript:void(0)"><i class="bi bi-cart"></i> Add cart </a>
            </div>
            @else
            <div class="absolute bottom-1 w-full p-2"><span class="text-red-600 text-sm "> Liên hệ </span></div>
            @endif
        </div>
    </div>
</div>
