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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editInfoModal">
                                    Sửa thông tin cá nhân
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('user.update', ['id' => $user->id])}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editInfoModalLabel">Sửa thông tin cá nhân</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Họ tên</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                                                    </div>
                                                    <div class = "mb-3">
                                                        <label for="address" class = "form-label">Địa chỉ</label>
                                                        <input type = "text" class = "form-control" name = "address" value = "{{ old('address', $user->address) }}">
                                                    </div>
                                                    <div class = "mb-3">
                                                        <label for="phone_number" class = "form-label">Số điện thoại</label>
                                                        <input type = "text" class = "form-control" name = "phone_number" value = "{{ old('phone_number', $user->phone_number) }}">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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