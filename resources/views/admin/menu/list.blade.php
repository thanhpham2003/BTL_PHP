@extends('admin.main')

@section('content')
    

    <table class="table mt-2">
        <thead>
            <tr>
                <th style="width: 50px">Mã</th>
                <th>Tên</th>
                <th>Trạng thái</th>
                <th>Cập nhật</th>
                <th style="width:100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {!! \App\Helpers\Helper::menu($menus) !!}
        </tbody>
    </table>
@endsection
