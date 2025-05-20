@extends('admin.main')

@section('head')
@endsection

@section('content')
<form action="{{ route("admin.info.update", $info->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label>Địa chỉ</label>
            <textarea name="address" id="content" class="form-control">{{ $info->address }}</textarea>
        </div>

        <div class="form-group">
            <label>Số điện thoại</label>
            <textarea name="phone" id="content" class="form-control">{{ $info->phone }}</textarea>
        </div>

        <div class="form-group">
            <label>Email</label>
            <textarea name="email" id="content" class="form-control">{{ $info->email }}</textarea>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
    @csrf
</form>

@endsection

@section('footer')
@endsection