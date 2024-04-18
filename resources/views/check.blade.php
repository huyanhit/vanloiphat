@extends('layouts.home')
@section('content')
    <div class="container">
        <x-breadcrumb name="dat-hang"></x-breadcrumb>
        <div class="flex flex-row">
            <div class="basis-7/12 mr-3">
                <h2 class="font-bold text-center text-uppercase">Thông tin đơn hàng</h2>
                <div class="my-cart py-2"></div>
                <div class="border-1 px-3 py-1 mb-3 bg-white">
                    <div class="text-sm form-group">
                        <label class="text-sm font-bold mr-3">Mã giảm giá:</label>
                        <input class="mr-2" type="text" name="coupon" placeholder="Mã giảm giá"/>
                        <button class="relative -top-[2px] btn bg-cyan-500 text-white hover:bg-cyan-600 text-sm">Áp dụng</button>
                        <label class="pt-1 float-right text-xl font-bold mr-3 text-red-600">
                            <span class="text-sm text-gray-700"> Giảm:</span>
                            <span> -</span><span id="coupon-down">0</span><span>đ</span>
                            <span class="ml-2 text-sm text-gray-700"> Còn lại:
                            </span><span id="total-pill">0đ</span>
                       </label>
                    </div>
                </div>
                <div class="border-1 px-3 py-1 mb-3 bg-white">
                    <div class="text-sm"><span class="text-sm text-red-600 font-bold">Lưu ý </span>: Giá chưa bao gồm phí vận chuyển và công lắp đặt tại nhà</div>
                    <div class="text-sm">
                        <span class="text-sm font-bold"> Phí vận chuyển và công lắp đặt xem: </span><a href="/bang-gia-lap-dat">tại đây</a>
                    </div>
                </div>
            </div>
            <div class="basis-5/12">
                <h2 class="font-bold text-center text-uppercase">Thông tin khách hàng</h2>
                <form action="{{route('mua-hang')}}" method="POST" class="py-2 px-3 border-1 my-2 bg-gray-100">
                    {{ csrf_field() }}
                    <input type="hidden" name="coupon" value=""/>
                    <div class="form-group mt-2">
                        <span class="mr-2">
                            <input class="relative -top-[1px]" {{request()->sex == 1?'checked':''}} type="radio" checked value="1" name="sex" id="male"/>
                            <label class="ml-1" for="male">Anh</label>
                        </span>
                        <span>
                            <input class="relative -top-[1px]" {{request()->sex == 2?'checked':''}} type="radio" value="2" name="sex" id="gender" />
                            <label class="ml-1" for="gender">Chị</label>
                        </span>
                        @if ($errors->has('sex'))
                            <span class="text-danger">{{ $errors->first('sex') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-2">
                        <label>Họ & Tên <span class="ml-1 text-red-600">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Họ & Tên" value="{{request()->name}}" />
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-2">
                        <label>Số điện thoại <span class="ml-1 text-red-600">*</span></label>
                        <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" value="{{request()->phone}}"/>
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-2">
                        <label>Ghi chú</label>
                        <textarea class="form-control" name="note"
                                  cols="30" rows="3" placeholder="Ghi chú thêm (Không bắt buộc)">{{request()->note}}</textarea>
                    </div>
                    <div class="mt-2">
                        <label class="mr-3">Nhận hàng: </label>
                        <span class="mr-2">
                            <input class="relative -top-[1px]" {{request()->ship_type == 1?'checked':''}}  checked id="delivery_home" type="radio" value="1" name="ship_type"/>
                            <label for="delivery_home">Nhận hàng tại nhà</label>
                        </span>
                        <span class="mr-2">
                            <input class="relative -top-[1px]" {{request()->ship_type == 2?'checked':''}} id="delivery_setup" type="radio" value="2" name="ship_type"/>
                            <label for="delivery_setup">Lắp đặt tại nhà</label>
                        </span>
                        <span class="">
                            <input class="relative -top-[1px]" {{request()->ship_type == 3?'checked':''}} id="delivery_store" type="radio" value="3" name="ship_type"/>
                            <label for="delivery_store">Đến cửa hàng</label>
                        </span>
                        <div id="delivery_home_form" class="mt-2">
                            <div class="form-group">
                                <textarea class="form-control" name="address" cols="30" rows="2" placeholder="Địa chỉ">{{request()->address}}</textarea>
                            </div>
                        </div>
                        <div id="delivery_store_form" class="mt-2" style="display: none">
                            <div class="border-1 px-3 py-2 bg-white h-[62px]">
                                <div class="text-sm"><span class="font-bold">Địa chỉ:</span> {{$sites->address}}</div>
                                <div class="text-sm"><span class="font-bold">Điện thoại:</span> {{$sites->hotline}}</div>
                            </div>
                        </div>
                        <div class="text-right mt-3 mb-2">
                            <button class="btn px-2 rounded-2 bg-red-500 text-white hover:bg-red-600 text-sm"><i class="bi bi-credit-card-2-front mr-1"></i>Thanh toán</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#delivery_home').click(function () {
            $('#delivery_home_form').show();
            $('#delivery_setup_form').hide();
        })
        $('#delivery_setup').click(function () {
            $('#delivery_home_form').show();
            $('#delivery_store_form').hide();
        })
        $('#delivery_store').click(function () {
            $('#delivery_home_form').hide();
            $('#delivery_store_form').show();
        })
    </script>
@endsection
