@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Tiêu Đề</th>
            <th>Mô tả</th>
            <th>Ảnh</th>
            <th>Trang Thái</th>
            <th>Cập Nhật</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($abouts as $key => $about)
            <tr>
                <td>{{ $about->id }}</td>
                <td>{{ $about->name }}</td>
                <td>{!! $about->content !!}</td>
                <td><a href="{{ $about->thumb }}" target="_blank">
                        <img src="{{ $about->thumb }}" height="40px">
                    </a>
                </td>
                <td>{!! \App\Helpers\Helper::active($about->active) !!}</td>
                <td>{{ $about->updated_at }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ url('admin/abouts/edit/' . $about->id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow({{ $about->id }}, '/admin/abouts/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $abouts->links() !!}
@endsection