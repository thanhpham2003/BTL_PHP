@extends('admin.main')

@section('content')
<style>
    .tab-link {
    color: black;
    text-decoration: none;
    font-size: 16px;
    margin-left: 20px; /* Cách lề trái */
}
    .active-tab {
    font-weight: bold;
    text-decoration: underline;
    color: #007bff; /* Màu xanh */
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

</style>
<div class="mb-3">
    <a href="{{ route('admin.contact.pending') }}" class="tab-link {{ request()->routeIs('admin.contact.pending') ? 'active-tab' : '' }}">
        Chưa phản hồi ({{ $messageCount }})
    </a> |
    <a href="{{ route('admin.contact.replied') }}" class="tab-link {{ request()->routeIs('admin.contact.replied') ? 'active-tab' : '' }}">
        Đã phản hồi
    </a>
</div>




<table class="table">
    <thead>
    <tr>
        <th style="width: 50px">ID</th>
        <th style="width: 200px">Email</th>
        <th style="width: 500px">Tin nhắn</th>
        <th>Thời gian</th>
        <th style="width: 200px">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contacts as $contact)
        <tr>
            <td>{{ $contact->id }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->message }}</td>
            <td>{{ $contact->updated_at }}</td>
            <td>
                @if($contact->status == 'pending')
                    <form action="{{ route('admin.contact.markAsReplied', $contact->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa-solid fa-check"></i></button>
                    </form>
                @endif
                <form action="{{ route('admin.contact.destroy') }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow({{ $contact->id }}, '/admin/contacts/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{!! $contacts->links() !!}
@endsection
