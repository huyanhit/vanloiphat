@extends('Admin::Layouts.admin')
    @section('content')
    <div class="container">
        <div class="row justify-content-center dashboard">
            <div class="col-md-12">
                <div class="row">
                    @foreach($data as $value)
                    <div class="col-3 col-sm-3">
                        <div class="area-manager">
                            <a href="{{$value['link']}}">
                                {!!$value['icon']!!}  <span class="name">{{$value['title']}}</span>
                                <span class="count"><span class="title">Số lượng:</span ><span class="font-weight-bold"> {{$value['page']}} </span></span>
                                @if(isset($value['active']))
                                    <span class="active"><span class="title">Hoạt động:</span> <span class="font-weight-bold"> {{$value['active']}} </span> </span>
                                @endif
                                @if(isset($value['process']))
                                    <span class="active"><span class="title">Đã xử lý:</span> <span class="font-weight-bold"> {{$value['process']}} </span> </span>
                                @endif
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="area-analytics red">
                            <p class="name">Lượt truy cập</p>
                            <p class="count"><span class="title">hiên tại:</span> <span>{{$counter['online']}}</span> </p>
                            <p class="count"><span class="title">hôm nay:</span> <span>{{$counter['today']}}</span> </p>
                            <p class="count"><span class="title">tóng số:</span> <span>{{$counter['total']}}</span>  </p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="area-analytics red">
                            <p class="name">Dung lượng</p>
                            <p class="count"><span class="title">upload:</span> <span>{{ number_format($size['upload'] / 1048576, 2) }} MB </span></p>
                            <p class="refesh">
                                <form method="POST" action="{{ route('images-destroy') }}" style="display: inline-block;">
                                    @csrf
                                    <span class="title pull-left">xóa file không còn sử dụng: </span>
                                    <a class="btn" onclick="event.preventDefault(); if(confirm('Bạn muốn xóa file không còn sử dụng.')) this.closest('form').submit()" style="margin: -5px 10px;"> Xóa </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
