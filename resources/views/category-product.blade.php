@extends('layouts.home')
@section('content')
    <div class="container">
        <div class="lg:flex block">
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
            <form method="get" action="{{route('phan-loai', $category->name)}}" class="bg-white my-2 block border-1 p-1 px-2 shadow-[1px_0_5px_1px_rgba(6,6,6,0.3)]">
                <div class="lg:flex inline-block text-center">
                    <div class="xl:flex inline-block">
                        <label class="p-2 text-center font-bold text-nowrap"><i class="bi bi-funnel mr-2 text-xl"></i></label>
                    </div>
                    <div class="flex-auto lg:flex hidden text-nowrap">
                        <label for="sku" class="flex-auto text-sm font-medium text-stone-600 text-right p-2 leading-8 text-nowrap">Mã SP</label>
                        <input type="text" id="sku" name="sku" placeholder="Mã sản phẩm" value="{{request('sku')}}"
                               class="min-w-[100px] max-w-[150px] xl:max-w-[250px] flex-auto inline-block
                               bg-gray-100 px-2 outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                    <div class="flex-auto lg:flex inline-block text-nowrap">
                        <label for="title" class="flex-auto text-sm font-medium text-stone-600 text-right p-2 leading-8 text-nowrap" >Tên SP</label>
                        <input type="text" name="title" id="title" placeholder="Tên sản phẩm" value="{{request('title')}}"
                               class="min-w-[200px] max-w-[150px] xl:max-w-[250px] inline-block bg-gray-100 px-2 outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                    <div class="flex-auto lg:flex inline-block">
                        <label for="price" class="flex-auto text-sm font-medium text-stone-600 text-right p-2 leading-8 text-nowrap">Mức giá</label>
                        <select id="price" name="price" class="min-w-[100px] max-w-[150px] xl:max-w-[250px] inline-block cursor-pointer bg-gray-100 px-2  outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option selected>Chọn mức giá</option>
                            <option value="1" {{request('price') == '1'?'selected':''}}> Dưới 1.000.000đ</option>
                            <option value="2" {{request('price') == '2'?'selected':''}}> 1.000.000đ đến 5.000.000đ</option>
                            <option value="3" {{request('price') == '3'?'selected':''}}> 5.000.000đ đến 10.000.000đ</option>
                            <option value="4" {{request('price') == '4'?'selected':''}}> Trên 10.000.000đ</option>
                            <option value="5" {{request('price') == '5'?'selected':''}}> Liên hệ </option>
                        </select>
                    </div>
                    <div class="flex-auto lg:flex hidden">
                        <label for="producer" class="text-sm font-medium text-stone-600 text-right p-2 leading-8 text-nowrap">Nhà sản xuất</label>
                        <select id="producer" name="producer"
                                class="min-w-[200px] max-w-[150px] xl:max-w-[250px] inline-block cursor-pointer bg-gray-100 px-2  outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option selected>Chọn hãng</option>
                            @foreach($category->producers as $value)
                                <option value="{{$value->id}}" {{$value->id == request('producer')?'selected':''}}>{{ $value->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" ml-2 inline-block">
                        <input type="submit" class="lg:h-[48px] h-[42px]  bg-cyan-500 px-8 text-white outline-none hover:bg-cyan-700 focus:ring shadow font-bold" value="LỌC"/>
                    </div>
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
                <img onerror="this.src='/images/category.jpg'" src="{{route('get-image-resource', $category->banner)}}" alt="{{$category->title}}">
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

