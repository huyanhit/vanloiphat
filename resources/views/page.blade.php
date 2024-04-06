@extends('layouts.home')
@section('content')
    <div class="container mb-3 ">
        @if(!empty($pages))
        <x-breadcrumb name="xem-trang" :data="['page_router' => $pages->router, 'page_title' => $pages->title]"></x-breadcrumb>
        @endif
        <div class="flex">
            <div class="basis-2/12">
                @foreach ($product_categories as $item)
                    <div class="p-3 bg-gray-100 border-1 rounded my-2 text-sm hover:bg-cyan-600 hover:text-white">
                        <a href="{{Request::root()}}/phan-loai/{{$item->name}}" class="font-bold"> {{ $item->title }}</a>
                    </div>
                @endforeach
            </div>

            <div class="basis-7/12 mx-3">
                @if(!empty($pages))
                    <h1 class="px-2 block w-full text-center font-bold text-xl">
                        <span class="ml-2 text-center text-uppercase">{!! $pages->title !!}</span>
                    </h1>
                    <div class="description p-3 border-1 inline-block mt-2 bg-gray-50 font-semibold">
                        {!! $pages->description !!}
                    </div>
                    <article class="my-3 p-3 prose prose-sm prose-p:m-0 border-1 bg-gray-100">
                        {!! $pages->content !!}
                    </article >

                    <div class="my-3 text-center">
                        <a class="px-2 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded text-decoration-none" href="/">Quay lại trang chủ</a>
                    </div>
                @else
                    <article class="my-1 p-3 prose prose-sm prose-p:m-0 text-center text-uppercase">
                        Trang đang hoàn thiện. Cảm ơn quý khách đã ghé thăm.
                        <div class="my-3">
                            <a class="px-2 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded text-decoration-none" href="/">Quay lại trang chủ</a>
                        </div>
                    </article >
                @endif
            </div>
            <div class="basis-3/12">
                <div class="p-3 bg-gray-100 border-1 rounded my-2">
                    <a href="#"><img onerror="this.src='/images/logo.png'" src="{{route('get-image', $sites->image_id)}}"></a>
                </div>
            </div>
        </div>
    </div>
@endsection

