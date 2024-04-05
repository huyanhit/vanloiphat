@props(['item' => null])
<div class="m-2 shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)]">
    <a href="{{route('dich-vu', Str::slug($item->title).'-'.$item->id)}}-{{$item->id}}">
        <img onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $item->image_id)}}" alt="{{ $item->title }}">
    </a>
    <div class="bg-gray-100 h-[60px] relative">
        <h3 class="p-2 text-sm font-bold">
            <a class="px-2" href="{{route('dich-vu', Str::slug($item->title).'-'.$item->id)}}-{{$item->id}}" title="{{ $item->title }}">
                {{ $item->title }}
            </a>
        </h3>
    </div>
</div>
