@extends('frontend.layout')

@section('content')
<section class="bg-light" style="height: auto;">
    <div class="container-xl">
        <div class="row d-flex" style="padding-top: 150px; padding-bottom: 100px;">
            <div class="m-4">
                <a href="{{ route('fr.homepage') }}">Trang chủ</a> > <span class="text-secondary">Đơn hàng của tôi</span>
            </div>

            <!-- Bảng Đơn hàng chưa hoàn tất -->
            <div class="table-responsive mt-4">
                <h4 class="mb-3 text-danger">Đơn hàng đang xử lý</h4>
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên hàng</th>
                            <th>Giá tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thời gian đặt hàng</th>
                            <th>Hủy đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $incompleteOrders = $orders->filter(function ($order) {
                                return !in_array($order->status, ['completed', 'canceled']);
                            });
                        @endphp

                        @if($incompleteOrders->count())
                            @foreach ($incompleteOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        @foreach ($order->orderItems as $item)
                                            {{ $item->product->name ?? 'Sản phẩm đã xoá' }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>
                                        @if ($order->status === 'pending')
                                            <span class="badge bg-secondary">Đã đặt đơn</span>
                                        @elseif ($order->status === 'processing')
                                            <span class="badge bg-warning">Đang chuẩn bị hàng</span>
                                        @elseif ($order->status === 'shipped')
                                            <span class="badge bg-primary">Đang giao hàng</span>
                                        @elseif ($order->status === 'canceled')
                                            <span class="badge bg-danger">Đã huỷ</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if (in_array($order->status, ['pending', 'processing']))
                                            <form action="{{ route('user.cancelOrder', $order->id)}}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đơn này không?');">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm btn-outline-danger">Hủy đơn</button>
                                            </form>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">Không có đơn hàng nào.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Bảng Đơn hàng đã giao -->
            <div class="table-responsive mt-5">
                <h4 class="mb-3 text-success">Đơn hàng đã giao thành công</h4>
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên hàng</th>
                            <th>Giá tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thời gian nhận hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $completedOrders = $orders->where('status', 'completed');
                        @endphp

                        @if($completedOrders->count())
                            @foreach ($completedOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        @foreach ($order->orderItems as $item)
                                            {{ $item->product->name ?? 'Sản phẩm đã xoá' }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td><span class="badge bg-success">Giao hàng thành công</span></td>
                                    <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">Không có đơn hàng nào.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>
@endsection
