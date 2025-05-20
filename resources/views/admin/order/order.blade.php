@extends('admin.main')

@section('content')
    <style>
        .tab-link {
            color: black;
            text-decoration: none;
            font-size: 16px;
            margin-left: 20px;
        }

        .active-tab {
            font-weight: bold;
            text-decoration: underline;
            color: #007bff;
        }

        a {
            color: black;
            text-decoration: none;
            font-size: 16px;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .admin-reply {
            margin-left: 20px;
            font-style: italic;
            color: #007bff;
        }
    </style>

    <div class="mb-3">
        <a href="{{ route('admin.order.pending') }}"
            class="tab-link {{ request()->routeIs('admin.order.pending') ? 'active-tab' : '' }}">
            Đang duyệt ({{ \App\Models\Order::where('status', 'pending')->count() }})
        </a> |
        <a href="{{ route('admin.order.processing') }}"
            class="tab-link {{ request()->routeIs('admin.order.processing') ? 'active-tab' : '' }}">
            Đang đóng hàng ({{ \App\Models\Order::where('status', 'processing')->count() }})
        </a> |
        <a href="{{ route('admin.order.shipped') }}"
            class="tab-link {{ request()->routeIs('admin.order.shipped') ? 'active-tab' : '' }}">
            Đang giao ({{ \App\Models\Order::where('status', 'shipped')->count() }})
        </a> |
        <a href="{{ route('admin.order.completed') }}"
            class="tab-link {{ request()->routeIs('admin.order.completed') ? 'active-tab' : '' }}">
            Giao thành công ({{ \App\Models\Order::where('status', 'completed')->count() }})
        </a> |
        <a href="{{ route('admin.order.canceled') }}"
            class="tab-link {{ request()->routeIs('admin.order.canceled') ? 'active-tab' : '' }}">
            Đã hủy ({{ \App\Models\Order::where('status', 'canceled')->count() }})
        </a>

    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th style="width: 150px">Tên khách hàng</th>
                <th style="width: 150px">Số điện thoại</th>
                <th style="width: 150px">Địa chỉ</th>
                <th style="width: 100px">Sản phẩm</th>
                <th style="width: 150px">Tổng tiền</th>
                <th style="width: 150px">Thanh toán</th>
                <th>Thời gian</th>
                <th style="width: 200px">Hành động</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_phone }}</td>
                    <td>{{ $order->customer_address }}</td>
                    <td>
                        @foreach ($order->orderItems as $item)
                            <span>{{ $item->product->name }} - {{ $item->quantity }} -
                                {{ optional($item->size)->name ?? 'Không có size' }}</span>
                        @endforeach
                    </td>
                    <td>{{ $order->total_price }} VND</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->updated_at }}</td>
                    <td>
                        @if ($order->status == 'pending')
                            <form action="{{ route('admin.order.markAsProcessing', $order->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Chuẩn bị</button>
                            </form>
                            <form action="{{ route('admin.order.markAsCanceled', $order->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="fa-solid fa-xmark"></i></button>
                            </form>
                        @elseif ($order->status == 'processing')
                            <form action="{{ route('admin.order.markAsShipped', $order->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Giao hàng</button>
                            </form>
                            <form action="{{ route('admin.order.markAsCanceled', $order->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="fa-solid fa-xmark"></i></button>
                            </form>
                        @elseif ($order->status == 'shipped')
                            <form action="{{ route('admin.order.markAsCompleted', $order->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Đã giao</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $orders->links() !!}
@endsection
