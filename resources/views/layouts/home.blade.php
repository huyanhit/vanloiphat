<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{$sites->company}}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta HTTP-EQUIV="Content-Language" CONTENT="vi">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      
        {!! $sites->meta !!}
        <meta name="keywords"  content=" {!! $sites->keyword !!}">
		<meta name="description" content=" {!! $sites->description !!}"/>
		
        <link rel="stylesheet" id="bootstrap-css" href="{{Request::root()}}/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" id="font-awesome-css" href="{{Request::root()}}/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" id="carousel-css" href="{{Request::root()}}/css/owl.carousel.css" type="text/css">
        <link rel="stylesheet" id="style-css" href="{{Request::root()}}/css/nivo-slider.css" type="text/css" media="all">
        <link rel="stylesheet" id="style-css" href="{{Request::root()}}/css/app.css" type="text/css" media="all">

        <script src="{{Request::root()}}/js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/jquery.nivo.slider.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/owl.carousel.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/ajax.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/main.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            {{-- Header Top --}}
            <div id="header-top" >
                <div class="container">
                    <div class="row">
                        <div class="hot-line col-6"><span>Tư vấn: </span><b> {{$sites->hotline}} </b></div>
                        <div class="search col-6">
                            <form class="frm_search pull-right" name="frm_header_search" method="post" action="{{route('product.search')}}">
                                {{csrf_field()}}
                                <input type="text" name="keyword" value="{{isset($keyword)?$keyword:''}}" placeholder="Tìm sản phẩm">
                                <button class="btn-search"><i class="fa fa-search"></i></div>
                            </form>
                        </div>
                    </div>
                </div>
			</div>
            {{-- Header Navigation --}}
            <div id="navigation" >
                <!-- Logo -->
                <div class="container">
                    <div class="row">
                        <div id="logo" class="col-3">
                            <a href="{{ route('home.index') }}" rel="trang chu"><img src="/images/logo.png"></a>
                        </div>
                        <!-- Navigation Links -->
                        <div id="menu" class="col-9">
                            <ul class="nav ">
                                @foreach ($menus as $item)
                                    @if (empty($item->parent_id))
                                        <li class="nav-item {{(request()->path() == $item->router)? 'active': ''}}">
                                            <a href="{{Request::root()}}/{{$item->router}}">{!!$item->icon!!} {{ $item->title }}</a>
                                            <ul class="sub-menu">
                                                @foreach ($menus as $sub)
                                                    @if($sub->parent_id == $item->id)
                                                        <li class="nav-item {{(request()->path() == $sub->router)? 'active': ''}}">
                                                            <a href="{{Request::root()}}/{{ $sub->router }}">{!!$sub->icon!!} {{ $sub->title }} </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page Content -->
        <main>
           @yield('content')
        </main>
        <div class="zalo-chat-widget" data-oaid="1488307458291278151" 
            data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="300" data-height="300"> 
        </div> 
        <script src="https://sp.zalo.me/plugins/sdk.js"> </script> 

        <!-- Page footer -->
        <footer id="footer" class="shadow">
            <!-- Logo -->
            <div class="container">
                <div class="row">
                    <div class="intro col-md-4 col-sm-12">
                        <div class="f-title">{{$sites->company}}</div>
                        <div class="info">
                            {!!$sites->address!!}
                            <span >Điện thoại: {{$sites->phone}}</span></span>
                            <br/><span >Hotline: {{$sites->hotline}}</span></span>
                            <br/><span >Email: {{$sites->email}}</span></span>
                            <br/><span >Website: {{$sites->sites}}</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="fan-page f-title">Fanpage Facebook</div>
                        {!!$sites->facebook!!}
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="map f-title">BẢN ĐỒ TRỤ SỞ CHÍNH</div>
                        {!!$sites->map!!}
                    </div>
                    <div class="clear"></div>
                </div>
            
             </div>
        </footer>
    </body>
    
    <script>
        window.onscroll = function() {myFunction()};
        var header = document.getElementById("navigation");
        var sticky = header.offsetTop;
        function myFunction() {
          if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
          } else {
            header.classList.remove("sticky");
          }
        }
    </script>
</html>
