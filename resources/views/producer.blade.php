@extends('layouts.home')
@section('content')
    <div class="container">
        <x-breadcrumb name="hang-san-xuat" :data="['producer_title' => $producer->title, 'producer_name' => $producer->name]"></x-breadcrumb>
        <div class="-mx-2">
            @foreach ($product as $item)
                <x-product-item :item="$item"></x-product-item>
            @endforeach
        </div>
        <div class="clear-both text-center my-3">
            {!! $product !!}
        </div>
    </div>
@endsection

