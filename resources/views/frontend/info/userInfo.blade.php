@extends('frontend.layout')
@section('content')
    <section class = "bg-light" style = "height: auto;">
        <div class = "container-xl">
            <div class = "row d-flex" style = "padding-top: 150px; padding-bottom: 100px;">
                <div class = "m-4">
                    <a href = "{{ route('fr.homepage') }}">Trang chủ</a>
                    >
                    <span class = "text-secondary">Thông tin cá nhân</span>
                </div>
                <div class = "col-4">
                    <div class = "card">
                        <div class = "card-body">
                            <img src = "{{ asset('image/default-avatar.jpg') }}" class = "img-fluid" alt = "Ảnh đại diện">
                            <h4 class = "text-center mt-4 mb-4 text-primary">{{$user->name}}</h4>
                            <div class="d-flex align-items-center justify-content-center" role="group">
                                <button type="button" class="btn btn-primary me-2">Sửa ảnh đại diện</button>
                                <button type="button" class="btn btn-primary">Sửa thông tin cá nhân</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-8">
                    <div class = "card">
                        <div class = "card-body">
                            <h4 class = "text-primary text-center mb-4">Thông tin cá nhân</h4>
                            <div class = "info-box">
                                <div class = "mb-3">
                                    <label class = "form-label">Họ và tên</label>
                                    <input type = "text" class = "form-control" value="{{$user->name}}" readonly>
                                </div>
                                <div class = "mb-3">
                                    <label class = "form-label">Địa chỉ</label>
                                    <input type = "text" class = "form-control" value="{{$user->address}}" readonly>
                                </div>
                                <div class = "mb-3">
                                    <label class = "form-label">Email</label>
                                    <input type = "text" class = "form-control" value="{{$user->email}}" readonly>
                                </div>
                                <div class = "mb-3">
                                    <label class = "form-label">Số điện thoại</label>
                                    <input type = "text" class = "form-control" value="{{$user->phone_number}}" readonly>
                                </div>
                                <div class = "mb-3">
                                    <label class = "form-label">Số đơn hàng đã đặt</label>
                                    <input type = "text" class = "form-control" value="{{$user->total_order}}" readonly>
                                </div>
                                <div class = "mb-3">
                                    <label class = "form-label">Tổng chi tiêu</label>
                                    <input type = "text" class = "form-control" value="{{$user->total_price}} VNĐ" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection