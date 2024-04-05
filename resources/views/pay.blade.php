@extends('layouts.home')
@section('content')
    <div class="container">
        <x-breadcrumb name="thanh-toan" :data="['order_id' => $order->id]"></x-breadcrumb>
        <div class="flex flex-row">
            <div class="basis-2/3">
                <h3 class="font-bold text-center text-uppercase ">Chọn Hình thức thanh toán</h3>
                <form action="{{route('tat-toan', $order->id)}}" method="POST" class="py-2 px-3 border-1 my-2 bg-gray-100">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put"/>
                    <div class="mt-2 mb-5 border-1 bg-gray-100 p-3">
                        <div>
                            <input class="relative -top-[1px] mr-1" checked id="pay_cod" type="radio" value="1" name="payment">
                            <label for="pay_cod">Giao hàng (COD)</label>
                        </div>
                        <div id="pay_cod_form" class="mt-2" style="display: block;">
                            <div class="form-group py-2 px-3 border-1 bg-gray-100">
                                <div class="text-sm font-bold">Nhân viên giao hàng đem sản phẩm đến nhà để khách hàng kiểm tra và thanh toán</div>
                                <div class="text-sm"><span class="font-bold">Số tiền: </span><strong class="text-red-600">{{ number_format($order->price, 0, ',', '.') }}đ</strong></div>
                                <div class="text-sm"><span class="font-bold">Địa chỉ: </span> <strong class="text-red-600">{{ $order->address }}</strong></div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input class="relative -top-[1px] mr-1" id="pay_store" type="radio" value="2" name="payment">
                            <label for="pay_store">Thanh toán và nhận hàng ở cửa hàng</label>
                        </div>
                        <div id="pay_store_form" class="mt-2 mr-1" style="display: none;">
                            <div class="form-group py-2 px-3 border-1 bg-gray-100">
                                <div class="text-sm font-bold">Khách hàng tự đến của hàng xem sản phẩm và thanh toán</div>
                                <div class="text-sm"><span class="font-bold">Số tiền: </span><strong class="text-red-600">{{ number_format($order->price, 0, ',', '.') }}đ</strong></div>
                                <div class="text-sm"><span class="font-bold">Địa chỉ cửa hàng: </span><strong class="text-red-600">{{ $sites->address }}</strong></div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input class="relative -top-[1px] mr-1" id="pay_bank" type="radio" value="3" name="payment">
                            <label for="pay_bank">Chuyển khoản ngân hàng</label>
                        </div>
                        <div id="pay_bank_form" class="mt-2" style="display: none;">
                            <div class="form-group py-2 px-3 border-1 bg-gray-100">
                                <div class="text-sm font-bold">Khách hàng chuyển khoản qua ngân hàng</div>
                                <div class="text-sm"><span class="font-bold">Số tiền chuyển: </span>
                                    <strong class="text-red-600 text-xl">{{ number_format($order->price, 0, ',', '.') }}đ</strong>
                                </div>
                                <div class="text-sm p-3 bg-white my-2">
                                    <span class="font-bold">Thông tin chuyển khoản</span>
                                    <p><span class="text-sm font-bold">Số tài khoản</span>
                                        <span class="text-red-600 text-xl"> 0531000273343 </span>
                                    </p>
                                    <p><span class="text-sm font-bold">Ngân hàng:</span>
                                        <span class="text-sm"> Vietcombank - Chi Nhánh Bình Thạnh, TP-HCM</span>
                                    </p>
                                    <p><span class="text-sm font-bold">Chủ tài khoản:</span>
                                        <span class="text-sm">Nguyễn Thu Hương</span>
                                    </p>
                                    <p><span class="text-sm font-bold">Nội dung chuyển khoản:</span>
                                        <span class="text-sm">Thanh toán HĐ {{$order->id}} ĐT {{$order->phone}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="border-1 px-3 py-1 mb-3 bg-white mt-2">
                                <div class="text-sm">
                                    <span class="text-sm text-red-600 font-bold">Lưu ý:</span>
                                    Với hình thức chuyển khoản qua ngân hàng
                                </div>
                                <div class="text-sm">
                                    <span class="text-sm font-bold">Đơn hàng sẻ được giao sau khi cửa hàng nhận chuyển khoản thành công</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-3 mb-2">
                            <button class="btn px-2 rounded-2 bg-red-500 text-white hover:bg-red-600 text-sm"><i class="bi bi-ui-radios-grid"></i> Hoàn tất </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="basis-1/3">
                <h3 class="font-bold text-center text-uppercase">Thông tin đơn hàng</h3>
                <table class="table border-1 mt-2 m-3">
                    <tr class="bg-cyan-700 text-white">
                        <th  class="text-center text-sm">Mã</th>
                        <td class="text-left">{{$order->id}}</td>
                    </tr>
                    <tr class="bg-cyan-700 text-white">
                        <th class="text-center text-sm">Tên KH</th>
                        <td class="text-left">{{$order->name}}</td>
                    </tr>
                    <tr class="bg-cyan-700 text-white">
                        <th class="text-center text-sm">Điện thoại</th>
                        <td class="text-left">{{$order->phone}}</td>
                    </tr>
                    <tr class="bg-cyan-700 text-white">
                        <th class="text-center text-sm">Địa chỉ</th>
                        <td class="text-left">{{$order->address}}</td>
                    </tr>
                    <tr class="bg-cyan-700 text-white">
                        <th class="text-center text-sm">Ghi chú</th>
                        <td class="text-left">{{$order->note}}</td>
                    </tr>
                    <tr class="align-middle">
                        <th class="text-center">Giá tiền</th>
                        <td class="text-left"><strong class="text-red-600">{{ number_format($order->price, 0, ',', '.') }}đ</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        <script>
            $('#pay_cod').click(function () {
                $('#pay_store_form').hide();
                $('#pay_bank_form').hide();
                $('#pay_cod_form').show();
            })
            $('#pay_store').click(function () {
                $('#pay_cod_form').hide();
                $('#pay_bank_form').hide();
                $('#pay_store_form').show();
            })
            $('#pay_bank').click(function () {
                $('#pay_cod_form').hide();
                $('#pay_store_form').hide();
                $('#pay_bank_form').show();
            })
        </script>
    </div>
@endsection
