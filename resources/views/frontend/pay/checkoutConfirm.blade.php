@extends('frontend.layout')
@section('content')
    <div class="container py-5" style = "margin-top: 100px">
        <h3 class="mb-4 text-center">🛒 Thông tin đơn hàng</h3>
        <form action = "{{route('user.createPayment')}}" method = "POST" class="p-4 shadow rounded bg-light" style="max-width: 800px; margin: auto;">
            @csrf
            <input type = "hidden" name = "user_id" value = "{{$customer['user_id']}}">
            <div class = "mb-3">
                <label class = "form-label">Tên người nhận</label>
                <input type = "text" class = "form-control" name = "name" value="{{$customer['name']}}">
            </div>
            <div class = "mb-3">
                <label class = "form-label">Số điện thoại</label>
                <input type = "text" class = "form-control" name = "phone" value = "{{$customer['phone']}}">
            </div>
            <div class = "mb-3">
                <label class = "form-label">Địa chỉ</label>
                <input type = "text" class = "form-control" name = "address" value="{{$customer['address']}}">
            </div>
            <div class = "mb-3">
                <label class = "form-label">Ghi chú</label>
                <input type = "text" class = "form-control" name = "note">
            </div>
            {{-- Hiển thị sản phẩm trong đơn hàng --}}
            <h5 class="mt-4">Chi tiết đơn hàng:</h5>
                @foreach ($cart as $item)
                    {{-- <div class="border rounded p-3 mb-3 bg-white">
                        <p><strong>Sản phẩm:</strong> {{ $item['product_name'] }}</p>
                        <p><strong>Kích cỡ:</strong> {{ $item['size'] }}</p>
                        <p><strong>Số lượng:</strong> {{ $item['quantity'] }}</p>
                        <p><strong>Đơn giá:</strong> {{ number_format($item['price'], 0, ',', '.') }}₫</p>
                        <p><strong>Thành tiền:</strong> {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫</p>
                    </div> --}}
                    <div class = "mb-3">
                        <label class = "form-label">Tên sản phẩm</label>
                        <input type = "text" class = "form-control" name="product_name" value="{{$item->product->name}}" readonly>
                    </div>
                    <div class = "mb-3">
                        <label class = "form-label">Kích cỡ</label>
                        <input type = "text" class = "form-control" name = "size" value="{{$product_size}}" readonly>
                    </div>
                    <div class = "mb-3">
                        <label class = "form-label">Số lượng</label>
                        <input type = "text" class = "form-control" name = "quantity" value="{{$item->quantity}}" readonly>
                    </div>
                    <div class = "mb-3">
                        <label class = "form-label">Đơn giá</label>
                        <input type = "text" class = "form-control" name = "price" value="{{$item->product->price}}" readonly>
                    </div>
                    <div class = "mb-3">
                        <label class = "form-label">Thành tiền</label>
                        <input type = "text" class = "form-control" name = "total" value="{{$item->product->price * $item->quantity}}" readonly>
                    </div>
                @endforeach
            <div class = "mb-3">
                <button type = "submit" class = "btn btn-outline-danger">THANH TOÁN MOMO</button>
            </div>
        </form>
    </div>
@endsection