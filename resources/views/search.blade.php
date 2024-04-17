@extends('layouts.home')
@section('content')
    <div class="container">
        <x-breadcrumb name="tim-kiem"></x-breadcrumb>
        <div class="mb-3">
            @if(!$products->isEmpty())
                @foreach ($products as $item)
                    <div class="-mx-2">
                        <x-product-item :item="$item" />
                    </div>
                @endforeach
            @else
                <div class="my-1 p-3 prose prose-sm prose-p:m-0 text-center text-uppercase border-1">
                    Không tìm thấy sản phẩm nào hợp lệ.
                </div>
            @endif
        </div>
        @if(!$products->isEmpty())
            <div class="my-2  clear-both"> <span>{{ $products->appends(['tu_khoa' => Request::get('tu_khoa')]) }}</span></div>
        @endif
    </div>
@endsection

