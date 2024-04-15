@extends('layouts.home')
@section('content')
    <div class="container">
        <div class="flex p-3 bg-white" >
            <div class="flex-auto mr-3 relative p-3">
                <script src="{{Request::root()}}/js/ckeditor/ckeditor.js" type="text/javascript"></script>
                <div class="text-center w-100 absolute">
                    @if(Session::has('success'))
                        <span class="alert alert-success py-2 top-3 ">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </span>
                    @endif
                </div>
                <h1 class="text-xl text-cyan-700 px-3 dark:text-white bg-white border-2 border-cyan-700 absolute top-0 left-[30px] font-bold uppercase text-center">Liên hệ</h1>
                <div class="border-2 border-cyan-700">
                    <form class="bg-gradient-to-r from-blue-100 to-cyan-100 shadow form-horizontal p-4"
                              method="post" action="{{route('lien-he')}}">
                            @csrf
                            <div class="mt-2 flex flex-col">
                                <span class="font-bold">Tên liên hệ <span class="ml-1 text-red-600">*</span></span>
                                <span class="mt-1">
                                    <input class="form-control inline-block py-3 text-sm text-gray-900 shadow border-gray-300
                bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nhập vào tên" name="name" type="text" autocomplete="off">
                                </span>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="mt-2 flex flex-col">
                                <span class="font-bold">Điện thoại hoặc Email<span class="ml-1 text-red-600">*</span></span>
                                <span class="mt-1">
                                    <input class="form-control inline-block py-3 text-sm text-gray-900 shadow border-gray-300
                bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nhập vào số điện thoại hoặc Email"
                                           name="contact" type="text" autocomplete="off">
                                </span>
                                @if ($errors->has('contact'))
                                    <span class="text-danger">{{ $errors->first('contact') }}</span>
                                @endif
                            </div>
                            <div class="mt-2 flex flex-col">
                                <span class="font-bold">Lời nhắn <span class="ml-1 text-red-600">*</span></span>
                                <span class="mt-1">
                                    <textarea id="content-area" class="form-control inline-block py-3 text-sm text-gray-900 shadow border-gray-300
                bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Lời nhắn" name="content" cols="50" rows="10">
                                        {{request('noi-dung')}}
                                    </textarea>
                                </span>
                                <script>
                                    CKEDITOR.replace( 'content-area',{customConfig: 'myconfig.js'});
                                </script>
                                @if ($errors->has('content'))
                                    <span class="text-danger">{{ $errors->first('content') }}</span>
                                @endif
                            </div>
                            <div class="form-group mt-2">
                                <div class="control-label col-sm-3"></div>
                                <div class="text-center">
                                    <input class="px-5 py-2 bg-cyan-700 text-white font-bold text-center shadow" type="submit" id="submit" name="submit" value="Gửi">
                                </div>
                            </div>
                        </form>
                </div>
            </div>
            <div class="flex-auto p-3 prose prose-sm prose-p:m-0 bg-white">
                @if(!empty($pages))
                    <div class="description"> {!! $pages->description !!}</div>
                    <div class="content"> {!! $pages->content !!}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

