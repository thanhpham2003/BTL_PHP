@inject('storage', 'Illuminate\Support\Facades\Storage')
@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Tên sản phẩm</th>
                <th>Ảnh</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Giá khuyến mãi</th>
                <th>Size và số lượng</th>
                <th>Trạng thái</th>
                <th style="width: 120px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $key => $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>
                    @if ($product->thumb)
                    <img src="{{ asset($product->thumb) }}"
                         alt="{{ $product->name }}"
                         width="60px" 
                         height="60px"
                         style="object-fit: cover; border-radius: 5px;"
                         onerror="this.onerror=null; this.src='{{ asset('/image/no-image.png') }}'">
                    @else
                    <img src="{{ asset("/image/no-image.png") }}"
                         alt="No image"
                         width="60px" 
                         height="60px"
                         style="object-fit: cover; border-radius: 5px;">
                    @endif
                </td>
                <td>{{ $product->menu->name }}</td>
                <td>{{ number_format($product->price)}}đ</td>
                <td>{{ !empty($product->price_sale) ? number_format($product->price_sale) .'đ' : 'Không áp dụng'}}</td>
                <td>
                    @foreach($product->sizes as $size)
                    <div>
                        {{ $size->name }}:
                        {{ $size->pivot->quantity }} cái
                    </div>
                    @endforeach
                </td>
                <td>{!! \App\Helpers\Helper::active($product->active) !!}</td>
                <td style="width: 100px">
                    <a class="btn btn-primary btn-sm" href="{{ url('admin/products/edit/' . $product->id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="removeRow({{ $product->id}}, '/admin/products/destroy')"> 
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $products->links() !!}
    <script>
        function removeRow(id, url) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                $.ajax({
                    type: 'DELETE',
                    datatype: 'JSON',
                    data: { id },
                    url: url,
                    success: function(result) {
                        if (result.error === false) {
                            alert(result.message);
                            location.reload();
                        } else {
                            alert('Xóa sản phẩm thất bại');
                        }
                    }
                });
            }
        }
    </script>
@endsection
