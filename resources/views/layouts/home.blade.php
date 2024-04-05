<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>{{isset($meta)?$meta['title']:$sites->meta}}</title>
        <meta name="description" content="{!!isset($meta)?$meta['description']:$sites->description!!}"/>
        <meta name="keywords" content="{!!isset($meta)?$meta['keyword']:$sites->keyword!!}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta HTTP-EQUIV="Content-Language" CONTENT="vi">
        <meta property="og:locale" content="vi_VN">
        <meta property="og:type" content="article">
        <meta property="og:title" content="Vạn Lợi Phát cung cấp lắp đặt sửa chữa các thiết bị lọc nước">
        <meta property="og:site_name" content="Công ty TNHH vạn lợi phát - www.vanloiphat.com - www.vafa.vn">
        <meta property="og:description" content="Chuyên cung cấp mua bán sửa chữa máy linh kiện các thiết bị lọc xử lý nước sạch">
        <meta itemprop="name" content="Vạn Lợi Phát cung cấp lắp đặt sửa chữa các thiết bị lọc nước">
        <meta itemprop="description" content="Chuyên cung cấp mua bán sửa chữa máy linh kiện các thiết bị lọc xử lý nước sạch">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-S537FWM4HT"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-S537FWM4HT');
        </script>
        <script src="{{Request::root()}}/js/jquery-1.10.2.min.js" type="text/javascript"></script>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <header>
            {{-- Header Top --}}
            <div class="h-[50px] bg-gray-100"
                 style="background: url({{empty($sites->banner_top)? '/images/banner.png': $sites->banner_top}}); background-position: center;"></div>
            <div id="header-fixed" class="h-[65px] bg-blue-100 leading-[58px]">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-2">
                            <a href="{{ route('home') }}" rel="trang chu">
                                <img class="py-2 max-h-[65px]" onerror="this.src='/images/logo.png'" src="{{route('get-image', $sites->image_id)}}">
                            </a>
                        </div>
                        <div class="col-lg-6 col-xl-5 flex">
                            <form class="inline-block pt-1 flex-auto" method="post" action="{{route('product.search')}}">
                                {{csrf_field()}}
                                <input class="2xl:w-[260px] xl:w-[200px] lg:w-[150px] " type="text" name="keyword"
                                       value="{{request()->keyword}}" placeholder="Tìm sản phẩm"/>
                                <button>
                                    <i class="bi bi-search relative right-[30px]"></i>
                                </button>
                            </form>
                            <span title="Giỏ hàng" class="mr-3 flex-auto">
                                <button class="pt-2"
                                        data-toggle="popover"
                                        data-bs-placement="bottom">
                                    <i class="bi bi-cart relative xl:text-3xl lg:text-2xl md:text-xl cart_anchor">
                                        <span id="cart-number" class="absolute top-0 right-0 h-[20px] border-1 w-[20px]
                                            rounded-full bg-red-600 text-white text-xs font-bold">0</span>
                                    </i>
                                    <span class="inline-block text-xs font-bold relative -top-1">Giỏ Hàng</span>
                                </button>
                            </span>
                            <span title="Tra cứu đơn hàng" class="flex-auto md:hidden lg:inline-block">
                                <a class="inline-block pt-2" href="/tra-cuu-don-hang">
                                    <i class="bi bi-clipboard-check xl:text-3xl lg:text-2xl md:text-xl"></i>
                                    <span class="inline-block text-xs font-bold relative top-1 w-50 text-left">Tra Cứu Đơn Hàng</span>
                                </a>
                            </span>
                        </div>
                        <div class="col-lg-4 col-xl-5 flex">
                            <span class="mr-2 flex flex-auto table-cell">
                                <i class="bi bi-telephone mr-1 align-middle xl:text-4xl lg:text-3xl md:text-xl"></i>
                                <span class="inline-block text-xs align-middle lg:w-[100px] md:w-[80px]">
                                    <span class="font-bold">Hotline bán hàng</span>
                                    <a class="font-bold text-red-600 text-sm">{{ $sites->hotline }}</a>
                                </span>
                            </span>
                            <span class="mr-2 flex flex-auto table-cell">
                                <i class="bi bi-house-gear mr-1 align-middle xl:text-4xl lg:text-3xl md:text-xl"></i>
                                <span class="inline-block text-xs align-middle lg:w-[90px] md:w-[80px]" >
                                    <span class="font-bold">Hổ trợ kỹ thuật</span>
                                    <a class="font-bold text-red-600 text-sm">{{ $sites->technique }}</a>
                                </span>
                            </span>
                            <span class="mr-2 table-cell flex-auto border-white rounded">
                                 @if(Auth::check())
                                     <i class="align-middle bi bi-person-circle mr-1 xl:text-4xl lg:text-3xl"></i>
                                     <span class="inline-block align-middle text-nowrap hover:text-cyan-800 md:w-[60px]">
                                        <span class="lg:hidden xl:inline-block">Chào: </span><strong>{{ Auth::user()->name }}</strong>
                                     </span>
                                 @else
                                     <i class="align-middle bi bi-pencil-square mr-1 xl:text-4xl lg:text-3xl"></i>
                                     <span class="inline-block align-middle text-xs text-left md:w-[60px]" >
                                         <a class="font-bold text-nowrap block hover:text-cyan-800 text-uppercase" href="/dang-nhap">Đăng nhập</a>
                                     </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="cart-container relative w-50"></div>
			</div>
            {{-- Header Navigation --}}
            <div id="navigation" class="mb-1">
                <div class="container">
                    <div class="flex relative">
                        <!-- Navigation Links -->
                        <div class="xl:basis-1/4 lg:basis-2/6">
                            <div onclick="showNavigation()" class="cursor-pointer mr-1 mt-2 bg-gray-100 hover:bg-cyan-700 hover:text-white flex-auto nav-item px-3 py-2">
                                <i class="bi bi-menu-button-wide-fill mr-2"></i>
                                <span> Danh Mục Sản Phẩm </span>
                                <i class="bi bi-chevron-down float-right"></i>
                            </div>
                            <ul id="menus" class="nav flex flex-col mt-1 absolute h-[340px] z-50 hidden w-full">
                                @foreach ($product_categories as $item)
                                    @if (empty($item->parent_id))
                                        <li class="w-full flex-auto h-[40px]" onmousemove="openSubMenu(this)" onmouseout="closeSubMenu()">
                                            <div class="sub-menu-title xl:w-1/4 lg:w-2/6 relative ">
                                                <span class="bg-white absolute -top-[3px] h-[3px] left-0 right-1"></span>
                                                <div class="mr-1 bg-gray-100 hover:bg-cyan-700 hover:text-white nav-item px-3 py-2
                                                    overflow-hidden text-nowrap overflow-ellipsis
                                                {{(request()->path() == $item->router)? 'bg-blue-300': ''}}">
                                                    <span class="mr-2 pt-1">{!!$item->icon!!}</span>
                                                    <a href="{{Request::root()}}/phan-loai/{{$item->name}}"> {{ $item->title }}</a>
                                                    <i class="bi bi-chevron-right float-right lg:hidden xl:inline-block"></i>
                                                </div>
                                            </div>
                                            <div class="sub-menu-content xl:w-3/4 lg:w-4/6 opacity-95 bg-gray-100 flex flex-row absolute top-0 z-50 bottom-0 right-0">
                                                @if(count($item->subCategories))
                                                <div class="px-3 border-r-2 basis-1/3">
                                                    <h4 class="font-bold text-sm text-uppercase mt-2">Loại sản phẩm</h4>
                                                    <ul class="flex flex-col p-2 border-1 mt-2">
                                                        @foreach ($item->subCategories as $sub)
                                                            <li class="hover:bg-cyan-700 hover:text-white px-2">
                                                                <span class="mr-1 pt-1">{!!$sub->icon!!}</span>
                                                                <a href="{{Request::root()}}/phan-loai/{{$sub->name}}"> {{ $sub->title }} </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                                @if(count($item->producers))
                                                <div class="px-3 border-r-2 basis-1/3">
                                                    <h4 class="font-bold text-sm text-uppercase  mt-2">Hãng sản xuất</h4>
                                                    <ul class="flex flex-col p-2 border-1 mt-2">
                                                        @foreach ($item->producers as $sub)
                                                            <li class="hover:bg-cyan-700 hover:text-white px-2">
                                                                <span class="mr-1 pt-1">{!!$sub->icon!!}</span>
                                                                <a href="{{Request::root()}}/hang-san-xuat/{{$sub->name}}">{{ $sub->title }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                                @if($item->image_id)
                                                    <div class="p-3 basis-1/3">
                                                        <img class="rounded" src="{{route('get-image', $item->image_id)}}">
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="xl:basis-3/4 lg:basis-4/6">
                            <ul class="nav flex mt-2">
                                @foreach ($menus as $item)
                                    @if (empty($item->parent_id))
                                        <li class="bg-gray-100 hover:bg-cyan-700 hover:text-white flex-auto nav-item text-center px-3 py-2
                                        md:px-1 md:max-w-[150px]:
                                        {{(request()->path() == $item->router)? 'bg-blue-300': ''}}">
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
        <div class="zalo-chat-widget" data-oaid="2922010709793722622"
            data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="300" data-height="300">
        </div>
        <script src="https://sp.zalo.me/plugins/sdk.js"> </script>

        <!-- Page footer -->
        <footer class="bg-cyan-700 text-white py-3">
            <!-- Logo -->
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <h3><strong class="text-uppercase text-cyan-100">{{$sites->company}}</strong></h3>
                        <ul class="mt-2 text-sm">
                            <li><strong>Địa chỉ: </strong>{{$sites->address}}</li>
                            <li><strong>Kho vận: </strong>{{$sites->warehouse}}</li>
                            <li><strong>Điện thoại: </strong>{{$sites->phone}}</li>
                            <li><strong>Email: </strong>{{$sites->email}}</li>
                            <li><strong>Website: </strong>{{$sites->sites}}</li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <strong class="text-uppercase mb-2 text-cyan-100">Lĩnh vực hoạt động</strong>
                        <ul class="mt-2 text-sm">
                            <li> <a href="/gioi-thieu-cong-ty" title="Giới thiêu công ty">Giới thiêu công ty</a></li>
                            <li> <a href="/giao-hang-lap-dat" title="Dịch vụ giao hàng và lắp đặt">Dịch vụ giao hàng và lắp đặt</a></li>
                            <li> <a href="/ban-hang-doanh-nghiep" title="Dịch vụ cho doanh nghiệp">Dịch vụ cho doanh nghiệp</a></li>
                            <li> <a href="/tuyen-dung" title="Tuyển dụng">Tuyển dụng</a></li>
                            <li> <a href="/lien-he" title="Liên hệ">Liên hệ</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <strong class="text-uppercase mb-2 text-cyan-100">Quy định kinh doanh</strong>
                        <ul class="mt-2 text-sm">
                            <li> <a href="/hoan-tien" rel="nofollow" title="Quy định hoàn tiền">Quy định hoàn tiền</a></li>
                            <li> <a href="/giao-hang" rel="nofollow" title="Quy định giao hàng">Quy định giao hàng</a></li>
                            <li> <a href="/doi-tra" rel="nofollow" title="Quy định đổi trả">Quy định đổi trả</a></li>
                            <li> <a href="/bao-hanh" rel="nofollow" title="Quy định bảo hành">Quy định bảo hành</a></li>
                            <li> <a href="/bao-ve-nguoi-dung" rel="nofollow" title="Bảo vệ thông tin người dùng">Bảo vệ thông tin người dùng</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <strong class="text-uppercase mb-2 text-cyan-100">Hỗ trợ khách hàng</strong>
                        <ul class="mt-2 text-sm">
                            <li> <a href="/huong-dan-mua-hang" rel="nofollow" title="Hướng dẫn mua hàng">Hướng dẫn mua hàng</a></li>
                            <li> <a href="/huong-dan-thanh-toan" rel="nofollow" title="Hướng dẫn thanh toán">Hướng dẫn thanh toán</a></li>
                            <li> <a href="/hoa-don-dien-tu" rel="nofollow" title="Hóa đơn điện tử">Hóa đơn điện tử</a></li>
                            <li> <a href="/bang-gia-lap-dat" title="Bảng giá dịch vụ lắp đặt">Bảng giá dịch vụ lắp đặt</a></li>
                            <li> <a href="/cau-hoi-thuong-gap" title="Câu hỏi thường gặp">Câu hỏi thường gặp</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <strong class="text-uppercase mb-2 text-cyan-100">Mạng xã hội</strong>
                        {!!$sites->facebook!!}
                    </div>
                    <div class="clear"></div>
                </div>
             </div>
        </footer>
    </body>

    <script>
        counter();
        getCart();
        window.onscroll = function() { mySticky() };
        const VND = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        });
        function getCart(){
            $.ajax({
                type: 'GET',
                url: '/cart',
                contentType: "application/json",
                headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
            }).done(function(response){
                updateCartDom(response);
            });

            return '<div> ' +
                        '<div class="text-lg font-bold text-center mb-2">Giỏ hàng</div>' +
                        '<div class="my-cart">Loading...</div>' +
                        '<div class="text-right">' +
                            '<a id="close-cart" class="btn px-2 mr-2 rounded-2 bg-cyan-500 text-white hover:bg-cyan-700 text-sm">' +
                            '<i class="bi bi-x-circle"></i> Close </a>'+
                            '<a class="btn px-2 rounded-2 bg-red-500 text-white hover:bg-red-600 text-sm" href="/dat-hang">' +
                            '<i class="bi bi-cart"></i> Đặt hàng </a>'+
                        '</div>'+
                   '</div>';
        }
        function updateCartDom(response){
            let html =
                '<table class="table border-1">'+
                '<tr class="bg-cyan-700 text-white">'+
                '<th width="20%" class="text-center">Hinh ảnh</th>' +
                '<th width="30%">Tên sản phẩm</th>' +
                '<th width="10%" class="text-center">Số lượng</th>' +
                '<th width="10%" class="text-center">Giá</th>' +
                '<th width="10%" class="text-center">Lựa chọn</th>' +
                '<th width="10%" class="text-center">Xoá</th>' +
                '</tr>';
            let items = response.items;
            for (const index in items) {
                html +=
                    '<tr class="align-middle">'+
                    '<td class="text-center"><a href="'+items[index].extra_info.link+'"><img class="inline-block w-[100px]" alt="'+items[index].title+'" ' +
                    'onerror="this.src=\'/images/no-image.png\'" ' +
                    'src="/admin/get-image-thumbnail/'+items[index].extra_info.image_id+'"/><a></td>' +
                    '<td><a class="text-cyan-600" href="'+items[index].extra_info.link+'">'+ items[index].title +'<a></td>' +
                    '<td class="text-center"><input onblur="updateCart(this, \''+items[index].hash+'\')" type="number" value="'+ items[index].quantity +'"></td>' +
                    '<td class="text-center">'+ VND.format(items[index].price) +' </td>' +
                    '<td class="text-center">'+ items[index].options +'</td>' +
                    '<td class="text-center"><a class="flex-auto cursor-pointer" ' +
                    'onclick="removeCart(\''+items[index].hash+'\',\''+items[index].title+'\')">' +
                    '<i class="bi bi-x-circle text-red-600"></i> </a></td>'+
                    '</tr>'
            }
            html +=
                '<tr class="font-bold bg-cyan-700 text-white">'+
                '<td class="text-center"> Tổng cộng </td>' +
                '<td></td>' +
                '<td class="text-center">'+ response.quantities_sum +'</td>' +
                '<td class="text-center"><span class="text-red-600">'+ VND.format(response.subtotal) +'</span></td>' +
                '<td></td>' +
                '<td></td>' +
                '</tr>';

            html += '</table>';

            $('.my-cart').html(html);
            $('#cart-number').html(response.quantities_sum);
            $('#total-pill').html(VND.format(response.subtotal - parseInt($('#coupon-down').text())));
        }

        function counter(){
            $.ajax({
                type: 'get',
                url: '/counter'
            });
        }

        function mySticky() {
            const header = document.getElementById("header-fixed");
            const sticky = header.offsetTop;
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
        function showNavigation() {
            const menus = document.getElementById("menus");
            if (menus.classList.contains("hidden")) {
                menus.classList.remove("hidden");
            } else {
                menus.classList.add("hidden");
            }
        }
        function closeSubMenu(){
            $('#menus li').each((index, elem) =>{
                $(elem).removeClass("active");
            })
        }
        function openSubMenu(e){
            closeSubMenu();
            if (e.classList.contains("active")) {
                e.classList.remove("active");
            } else {
                e.classList.add("active");
            }
        }

        function updateCart(e, id) {
            $.ajax({
                type: 'PUT',
                url: '/cart/'+ id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    "quantity": $(e).val(),
                }
            }).done(function(response){
                updateCartDom(response);
            });
        }

        function removeCart(id, title){
            if(confirm('Xóa sản phẩm '+ title +' khỏi giỏ hàng?')){
                $.ajax({
                    type: 'DELETE',
                    url: '/cart/'+id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                }).done(function(response){
                    updateCartDom(response);
                });
            }
        }

        function addCart(e, item, link = ''){
            let html = $(e).html();
            $(e).html('<div class="spinner-border h-[15px] w-[15px]"></div>');
            $.ajax({
                type: 'POST',
                url: '/cart',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    "id": item.id,
                    "quantity": item.quantity,
                }
            }).done(function(response){
                $(e).html(html);
                updateCartDom(response);
                if(link !== ''){
                    window.location.href = '/'+link;
                }
            }).error(function(){
                $(e).html(html);
            });
        }
        $(document).ready(function() {
            $('.add-cart').on('click', function() {
                    var itemImg = $(this).parents('.product_item').find('img').eq(0);
                    flyToElement($(itemImg), $('.cart_anchor'));
                });
            });

            // take in other js page
            function flyToElement(flyer, flyingTo) {
                var divider = 6;
                var flyerClone = $(flyer).clone();
                $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
                $('body').append($(flyerClone));
                var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
                var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;

                $(flyerClone).animate({
                        opacity: 0.4,
                        left: gotoX,
                        top: gotoY,
                        width: $(flyer).width()/divider,
                        height: $(flyer).height()/divider
                    }, 700,
                function () {
                    $(flyingTo).fadeOut('fast', function () {
                        $(flyingTo).fadeIn('fast', function () {
                            $(flyerClone).fadeOut('fast', function () {
                                $(flyerClone).remove();
                            });
                        });
                    });
                });
        }
    </script>
</html>
