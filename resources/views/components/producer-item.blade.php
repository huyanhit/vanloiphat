@props(['item' => null])
<div class="m-2 shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)]">
    <a href="{{Request::root()}}/hang-san-xuat/{{$item->name}}">
        <img onerror="this.src='/images/no-image.png'"
           src="{{route('get-image-thumbnail', $item->image_id)}}"
           alt="{{ $item->title }}"/>
    </a>
</div>
