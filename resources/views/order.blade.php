@extends('layouts.home')
@section('content')
    <div class="container">
        <x-breadcrumb name="tra-cuu-don-hang"></x-breadcrumb>
        <div class="mt-2 mb-5">
            <form method="get" action="{{route('tra-cuu-don-hang')}}"
                  class="my-2 flex">
                <div class="flex mr-2">
                    <div class="flex flex-auto">
                        <input  type="text" id="sku" name="phone" placeholder="Nhập số điện thoại đặt hàng" value="{{request('phone')}}"
                               class="min-w-[350px] px-3 flex-auto block bg-gray-100 outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                </div>
                <div class="">
                    <input type="submit" class="h-[48px] bg-cyan-500 px-8 text-white border-1 border-cyan-700 outline-none hover:bg-cyan-700 focus:ring float-right" value="Tìm"/>
                </div>
            </form>

            @if(empty($orders))
            <div class="p-3 border-1 bg-gray-100">
                Không có thông tin hợp lệ
            </div>
            @else
            @foreach($orders as $order)
                <div class="p-2 py-2 border-1 bg-gray-100 mt-3">
                    <div class="bg-gray-200 p-2 mb-1">
                        <span class="mr-3"><span class="font-bold">Đơn hàng số:</span> <span class="text-red-600">{{$order->id}}</span></span>
                        <span class="mr-3"><span class="font-bold">Ngày mua:</span> <span class="text-red-600">{{$order->created_at->format('d/m/Y')}}</span></span>
                        <span class="mr-3"><span class="font-bold">Ngày giao (Dự kiến):</span> <span class="text-red-600">{{$order->date_ship->format('d/m/Y')}}</span></span>
                    </div>
                    <div class="flex relative">
                        <span class="absolute bg-gray-100 right-[10%] left-[10%] top-[48px] border-5"></span>
                        <span class="flex-auto inline-block text-center ">
                            <span class="w-[100px] h-[100px] inline-block relative z-2 {{$order->order_status_id >= 1? "bg-cyan-600":'bg-gray-100'}}  border-3 rounded-full text-center leading-[90px]">
                                <i class="bi bi-cart-check align-middle {{$order->order_status_id >= 1? "text-white":''}} text-3xl"></i>
                            </span>
                            <p class="font-bold
                            {{$order->order_status_id >= 1? "text-cyan-600":''}}">Chưa thanh toán</p>
                        </span>
                        @if($order->payment == 1)
                        <span class="flex-auto inline-block text-center">
                            <span class="w-[100px] h-[100px] inline-block relative z-2
                            {{$order->order_status_id >= 3? "bg-cyan-600":'bg-gray-100'}}
                            border-3 rounded-full text-center leading-[90px]">
                                <i class="bi bi-people align-middle text-3xl
                                {{$order->order_status_id >= 3? "text-white":''}}"></i>
                            </span>
                            <p class="font-bold
                            {{$order->order_status_id >= 3? "text-cyan-600":''}}">Xác nhận thông tin (COD)</p>
                        </span>
                        @else
                        <span class="flex-auto inline-block text-center">
                            <span class="w-[100px] h-[100px] inline-block relative z-2
                            {{$order->order_status_id >= 2? "bg-cyan-600":'bg-gray-100'}}
                            border-3 rounded-full text-center leading-[90px]">
                                <i class="bi bi-credit-card-2-front align-middle text-3xl
                                {{$order->order_status_id >= 2? "text-white":''}}"></i>
                            </span>
                            <p class="font-bold
                            {{$order->order_status_id >= 2? "text-cyan-600":''}}">Chờ xác nhận thanh toán</p>
                        </span>
                        @endif
                        <span class="flex-auto inline-block text-center">
                             <span class="w-[100px] h-[100px] inline-block relative z-2
                             {{$order->order_status_id >= 4? "bg-cyan-600":'bg-gray-100'}}
                             bg-gray-100 border-3 rounded-full text-center leading-[90px]">
                                <i class="bi bi-box-seam align-middle text-3xl
                                {{$order->order_status_id >= 4? "text-white":''}}
                                "></i>
                            </span>
                            <p class="font-bold
                            {{$order->order_status_id >= 4? "text-cyan-600":''}}">Đang đóng gói hàng</p>
                        </span>
                        <span class="flex-auto inline-block text-center">
                            <span class="w-[100px] h-[100px] inline-block relative z-2
                            {{$order->order_status_id >= 5? "bg-cyan-600":'bg-gray-100'}}
                            bg-gray-100 border-3 rounded-full text-center leading-[90px]">
                                <i class="bi bi-truck align-middle text-3xl
                                 {{$order->order_status_id >= 5? "text-white":''}}
                                "></i>
                            </span>
                            <p class="font-bold
                            {{$order->order_status_id >= 5? "text-cyan-600":''}}">Đang giao hàng</p>
                        </span>
                        <span class="flex-auto inline-block text-center">
                        <span class="w-[100px] h-[100px] inline-block relative z-2
                            {{$order->order_status_id >= 6? "bg-cyan-600":'bg-gray-100'}}
                            bg-gray-100 border-3 rounded-full text-center leading-[90px]">
                                <i class="bi bi-house-check align-middle text-3xl
                                 {{$order->order_status_id >= 6? "text-white":''}}
                                "></i>
                            </span>
                            <p class="font-bold
                            {{$order->order_status_id >= 6? "text-cyan-600":''}}">Hoàn thành</p>
                        </span>
                    </div>
                    <div>
                        <button class="border-1 bg-cyan-700 text-white px-2 py-1 mt-2 cursor-pointer" onclick="hideInfo(this)">Xem đơn hàng</button>
                        <table class="table border-1 mt-2" style="display: none">
                            <tr class="bg-cyan-700 text-white">
                                <th width="15%" class="text-center">Hinh ảnh</th>
                                <th width="30%">Tên sản phẩm</th>
                                <th width="10%" class="text-center">Số lượng</th>
                                <th width="10%" class="text-center">Giá</th>
                                <th width="20%" class="text-center">Tùy chọn</th>
                            </tr>
                            @foreach($order->products as $item)
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <a href="{{route('san-pham', $item->slug)}}">
                                        <img class="inline-block w-[100px]" alt="No name" onerror="this.src='/images/no-image.png'"
                                             src="{{route('get-image-thumbnail', $item->image_id)}}" /> </a>
                                    </td>
                                    <td> <a class="text-cyan-600" href="{{route('san-pham', $item->slug)}}">{{$item->title}} </a></td>
                                    <td class="text-center">{{$item->pivot->quantity}}</td>
                                    <td class="text-center"> <span class="font-bold text-red-600">{{number_format($item->pivot->price, 0, ',', '.') }}đ </span></td>
                                    <td class="text-center">
                                    @if(!empty(json_decode($item->pivot->options)))
                                        {{json_decode($item->pivot->options)->group_title.': '. json_decode($item->pivot->options)->title }}
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="font-bold bg-cyan-700 text-white">
                                <td class="text-center">Tổng tiền</td>
                                <td></td>
                                <td class="text-center"></td>
                                <td class="text-center "><span class="text-red-600">{{number_format($order->price, 0, ',', '.')}}đ</span></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
                <div class="clear-both text-center my-3">
                    {!! $orders->appends($_GET) !!}
                </div>
            @endif
        </div>
    </div>
    <script>
        function hideInfo(e){
            $(e).next().toggle();
        }
    </script>
@endsection
