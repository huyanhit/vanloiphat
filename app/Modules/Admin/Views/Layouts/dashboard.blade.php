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
                                <span class="count"><span class="title">Số lượng:</span> {{$value['page']}} </span>
                                <span class="active"><span class="title">hoạt động:</span> {{$value['active']}} </span>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
