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
    <a href="{{ route('admin.review.pending') }}" class="tab-link {{ request()->routeIs('admin.review.pending') ? 'active-tab' : '' }}">
        Chưa phản hồi ({{ $reviewCount }})
    </a> |
    <a href="{{ route('admin.review.replied') }}" class="tab-link {{ request()->routeIs('admin.review.replied') ? 'active-tab' : '' }}">
        Đã phản hồi
    </a>
</div>

<table class="table">
    <thead>
    <tr>
        <th style="width: 50px">ID</th>
        <th style="width: 100px">Tên</th>
        <th style="width: 300px">Đánh giá</th>
        <th>Thời gian</th>
        <th style="width: 200px">Phản hồi</th>
        <th style="width: 200px">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reviews as $review)
        <tr>
            <td>{{ $review->id }}</td>
            <td>{{ $review?->user?->name }}</td>
            <td>{{ $review->rating }} <i class="fa-solid fa-star" style="color: gold"></i> - {{ $review->comment }}</td>
            <td>{{ $review->updated_at }}</td>
            <td>
                @if($review->status == 'pending')
                    <form action="{{ route('admin.review.markAsReplied', $review->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <textarea name="admin_reply" rows="3" class="form-control" placeholder="Nhập phản hồi của admin..."></textarea>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa-solid fa-check"></i></button>
                    </form>
                @endif

                @if($review->admin_reply)
                    <p class="admin-reply">Phản hồi: {{ $review->admin_reply }} - <em>Admin</em></p>
                @endif
            </td>
            <td>
                <form action="{{ route('admin.review.destroy') }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow({{ $review->id }}, '/admin/reviews/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{!! $reviews->links() !!}
@endsection
