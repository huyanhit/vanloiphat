<?php

// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('home'));
});

Breadcrumbs::for('dat-hang', function ($trail) {
    $trail->parent('home');
    $trail->push('Đặt hàng', route('dat-hang'));
});

Breadcrumbs::for('thanh-toan', function ($trail, $data) {
    $trail->parent('home');
    $trail->push('Thanh toán', route('thanh-toan', $data['order_id']));
});

Breadcrumbs::for('tra-cuu-don-hang', function ($trail) {
    $trail->parent('home');
    $trail->push('Tra cứu đơn hàng', route('tra-cuu-don-hang'));
});

Breadcrumbs::for('xem-trang', function ($trail, $data) {
    $trail->parent('home');
    $trail->push($data['page_title'], route('xem-trang', $data['page_router']));
});

Breadcrumbs::for('tim-kiem', function ($trail) {
    $trail->parent('home');
    $trail->push('Tìm kiếm', route('tim-kiem'));
});

Breadcrumbs::for('lien-he', function ($trail) {
    $trail->parent('home');
    $trail->push('Liên hệ', route('lien-he'));
});

Breadcrumbs::for('dich-vu', function ($trail, $data) {
    $trail->parent('home');
    $trail->push($data['service_title'], route('dich-vu', $data['service_title']));
});

Breadcrumbs::for('hang-san-xuat', function ($trail, $data) {
    $trail->parent('home');
    $trail->push($data['producer_title'], route('hang-san-xuat', $data['producer_name']));
});


Breadcrumbs::for('phan-loai', function ($trail, $data) {
    $trail->parent('home');
    $trail->push($data['category_title'], route('phan-loai', $data['category_name']));
});

Breadcrumbs::for('san-pham', function ($trail, $data) {
    $trail->parent('phan-loai', $data);
    $trail->push($data['product_title'], route('san-pham', $data['product_title']));
});

Breadcrumbs::for('so-sanh', function ($trail, $data) {
    $trail->parent('phan-loai', $data);
    $trail->push($data['product_title'], route('so-sanh', $data['product_title']));
});
