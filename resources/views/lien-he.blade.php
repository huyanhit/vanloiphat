@extends('layouts.home')
@section('content')
    <div class="container">
        <div class="flex p-3 bg-white" >
            <div class="flex-auto mr-3">
                <script src="{{Request::root()}}/js/ckeditor/ckeditor.js" type="text/javascript"></script>
                <h3 class="font-bold text-xl mb-2">Liên hệ</h3>
                <div class="p-3 border-1 rounded-2">
                    <div class="">
                        @if(Session::get('success'))
                            <span class="success">
                        <p>Đã gửi thành công.</p>
                        <p>Chúng tôi sẻ phản hồi lại trong thời gian sớm nhất.</p>
                        <span class="thanks"> Cảm ơn bạn đã quan tâm đến sản phẩm và dịch vụ của chúng tôi</span>
                    </span>
                        @endif
                        @if(!empty(Session::get('errors')))
                            <span class="fail">
                        <p> Có lỗi xãy ra nguyên nhân:</p>
                        <p> {{$errors}} </p>
                        <p> Bạn vui lòng gửi lại hoặc gọi: {{ $sites->hotline }} để được giúp đỡ </p></span>
                        @endif
                    </div>
                    <div class="">
                        <form class="form-horizontal" method="post" action="{{route('page.contact')}}" enctype="multipart/form-data" novalidate="novalidate">
                            @csrf
                            <div class="mt-2 form-group">
                                <label class="control-label col-sm-3">Tên liên hệ</label>
                                <div class="col-sm-9">
                                    <input class="form-control text" placeholder="Tên liên hệ" name="name" type="text">
                                </div>
                            </div>
                            <div class="mt-2 form-group">
                                <label class="control-label col-sm-3">Điện thoại</label>
                                <div class="col-sm-9">
                                    <input class="form-control text" placeholder="Điện thoại" name="phone" type="text">
                                </div>
                            </div>
                            <div class="mt-2 form-group">
                                <label class="control-label col-sm-3">Email</label>
                                <div class="col-sm-9">
                                    <input class="form-control text" placeholder="Email" name="email" type="text">
                                </div>
                            </div>
                            <div class="mt-2 form-group">
                                <label class="control-label col-sm-3">Địa chỉ</label>
                                <div class="col-sm-9">
                                    <input class="form-control text" placeholder="Địa chỉ" name="address" type="text">
                                </div>
                            </div>
                            <div class="mt-2 form-group">
                                <label class="control-label col-sm-3">Lời nhắn</label>
                                <div class="col-sm-9">
                                    <textarea id="content-area" class="form-control" placeholder="Lời nhắn" name="content" cols="50" rows="10" ></textarea>
                                </div>
                                <script>
                                    CKEDITOR.replace( 'content-area',{customConfig: 'myconfig.js'});
                                </script>
                            </div>
                            <div class="form-group mt-2">
                                <div class="control-label col-sm-3"></div>
                                <div class="text-left">
                                    <input class="px-3 py-2 bg-cyan-700 rounded-2 text-white font-bold" type="submit" id="submit" name="submit" value="Gửi lời nhắn">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex-auto p-3 border-1 bg-gray-100 rounded-2">
                @if(!empty($pages))
                    <div class="description"> {!! $pages->description !!}</div>
                    <div class="content"> {!! $pages->content !!}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

