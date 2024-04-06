@extends('layouts.home')
@section('content')
    <div class="container">
        <div class="flex">
            <div class="basis-1/3">
                <x-breadcrumb name="phan-loai" :data="['category_title' => $category->title, 'category_name' => $category->name]"></x-breadcrumb>
            </div>
            <h1 class="basis-1/3 p-2 block w-full text-center font-bold text-xl">
                {!! $category->icon !!}<span class="ml-2 text-center text-uppercase">{{$category->title}}</span>
            </h1>
            <div class="basis-1/3">
            </div>
        </div>
        <div class="mt-2">
            <form method="get" action="{{route('phan-loai', $category->name)}}" class="bg-white my-2 flex block border-1 p-1 px-2 shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)]">
                <div class="basis-1/12">
                    <label class="p-2 text-center font-bold"><i class="bi bi-funnel mr-2 text-xl"></i>Bộ lọc</label>
                </div>
                <div class="basis-10/12 flex">
                    <div class="flex flex-auto">
                        <label for="sku" class="flex-auto text-sm font-medium text-stone-600 text-right p-2 leading-8">Mã SP</label>
                        <input type="text" id="sku" name="sku" placeholder=""  value="{{request('sku')}}"
                               class="flex-auto block bg-gray-100 px-2 outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                    <div class="flex flex-auto">
                        <label for="title" class="flex-auto text-sm font-medium text-stone-600 text-right p-2 leading-8">Tên SP</label>
                        <input type="text" name="title" id="title" placeholder="Máy lọc nước" value="{{request('title')}}"
                               class="flex-auto block bg-gray-100 px-2 outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                    <div class="flex flex-auto">
                        <label for="producer" class="flex-auto text-sm font-medium text-stone-600 text-right p-2 leading-8">Nhà sản xuất</label>
                        <select id="producer" name="producer"
                                class="flex-auto block bg-gray-100 px-2 outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option selected></option>
                            @foreach($category->producers as $value)
                                <option value="{{$value->id}}" {{$value->id == request('producer')?'selected':''}}>{{ $value->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-auto">
                        <label for="price" class="flex-auto text-sm font-medium text-stone-600 text-right p-2 leading-8">Mức giá</label>
                        <select id="price" name="price" class="flex-auto block cursor-pointer bg-gray-100 px-2  outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option selected></option>
                            <option value="1" {{request('price') == '1'?'selected':''}}> Dưới 1.000.000đ</option>
                            <option value="2" {{request('price') == '2'?'selected':''}}> 1.000.000đ đến 5.000.000đ</option>
                            <option value="3" {{request('price') == '3'?'selected':''}}> 5.000.000đ đến 10.000.000đ</option>
                            <option value="4" {{request('price') == '4'?'selected':''}}> Trên 10.000.000đ</option>
                            <option value="5" {{request('price') == '5'?'selected':''}}> Liên hệ </option>
                        </select>
                    </div>
                </div>
                <div class="basis-1/12">
                    <input type="submit" class="h-[48px] bg-cyan-500 px-8 text-white border-1 border-cyan-700 outline-none hover:bg-cyan-700 focus:ring float-right" value="Lọc"/>
                </div>
            </form>
        </div>
        <div class="-mx-2">
            @foreach ($product as $item)
                <x-product-item :item="$item"></x-product-item>
            @endforeach
        </div>
        <div class="clear-both text-center my-3">
            {!! $product !!}
        </div>
        @if($category->banner !== '')
            <div class="my-2 shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)]">
                <img onerror="this.src='/images/category.jpg'" src="{{route('get-image-resource', $category->banner)}} alt='{{$category->title}}">
            </div>
        @endif
        @if(strip_tags($category->content) != '')
            <x-title-block title="Thông tin thêm"></x-title-block>
            <div class="my-2 p-3 shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)] prose prose-sm prose-p:m-0 bg-gray-100">
                {!! $category->content !!}
            </div>
        @endif
    </div>
@endsection

