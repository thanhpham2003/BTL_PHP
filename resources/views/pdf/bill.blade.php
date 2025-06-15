<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn - {{$bill->id}}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.5; }
    </style>
</head>
<body>
    <h1 style = "text-align: center;">Hóa đơn #{{ $bill->id }}</h1>
    <p><strong>Khách hàng:</strong> {{ $bill->customer_name }}</p>
    <p><strong>Điện thoại:</strong> {{ $bill->phone }}</p>
    <p><strong>Địa chỉ:</strong> {{ $bill->address }}</p>
    @if($bill->payment_method === 'online')
    <p><strong>Phương thức thanh toán: </strong>Đã thanh toán</p>
    @else
    <p><strong>Phương thức thanh toán:</strong> {{ $bill->payment_method }}</p>
    @endif
    <p><strong>Tổng tiền:</strong> {{ number_format($bill->total_amount, 0, ',', '.') }} VNĐ</p>
    <p><strong>Thời gian đặt hàng: </strong>{{$bill->created_at}}</p>
    <hr>

    <h2>Thông tin sản phẩm:</h2>
    @php
        $product = is_array($bill->products) ? $bill->products : json_decode($bill->products, true);
    @endphp
    <ul>
        <li><strong>Tên sản phẩm:</strong> {{ $product['product_name'] ?? 'N/A' }}</li>
        <li><strong>Kích cỡ:</strong> {{ $product['size'] ?? 'N/A' }}</strong></li>
        <li><strong>Số lượng:</strong> {{ $product['quantity'] ?? 'N/A' }}</li>
        <li><strong>Giá:</strong> {{ isset($product['price']) ? number_format($product['price'], 0, ',', '.') . ' VNĐ' : 'N/A' }}</li>
    </ul>

    <p><strong>Ghi chú:</strong> {{ $bill->note ?? 'Không có' }}</p>
</body>
</html>
