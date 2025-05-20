@extends('admin.main')

@section('head')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
@endsection

@section('content')
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Sản Phẩm</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Nhập tên sản phẩm">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Danh Mục</label>
                        <select class="form-control" name="menu_id">
                            @foreach($menus as $menu)
                                @php
                                    // Lấy danh mục cha
                                    $parentMenu = $menu->parent_id ? \App\Models\Menu::find($menu->parent_id) : null;
                                    $displayName = $parentMenu ? "{$menu->name} ({$parentMenu->name})" : $menu->name;
                                @endphp
                                <option value="{{ $menu->id }}">{{ $displayName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Sizes</label>
                <div class="size-container d-flex flex-wrap">
                    @foreach($sizes as $key => $size)
                    <div class="size-item mb-3 mr-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" 
                                   name="sizes[{{ $size->id }}][size]" 
                                   value="{{ 1 }}"
                                   class="custom-control-input size-checkbox" 
                                   id="size{{ $size->id }}"
                                   {{ old('sizes.'.$size->id.'.active') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="size{{ $size->id }}">{{ $size->name }}</label>
                        </div>
                        <div class="mt-2">
                            <input type="number" 
                                name="sizes[{{ $size->id }}][quantity]" 
                                class="form-control quantity-input" 
                                placeholder="Số lượng"
                                style="width: 200px;"
                                min="1"
                                value="{{ old('sizes.'.$size->id.'.quantity') }}"
                                {{ !old('sizes.'.$size->id.'.active') ? 'disabled' : '' }}>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giá Gốc</label>
                        <input type="number" name="price" onkeyup="formatNumber(this)" value="{{ old('price') }}"  class="form-control" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giá Giảm</label>
                        <input type="number" name="price_sale" onkeyup="formatNumber(this)" value="{{ old('price_sale') }}"  class="form-control" >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Mô Tả </label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Mô Tả Chi Tiết</label>
                <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="thumb">Chọn hình ảnh</label>
                <input type="file" id="imageInput" name="thumb" accept="image/*" onchange="previewImage(this);">
                <img id="preview" src="{{ Session::get('temp_image') ? asset(Session::get('temp_image')) : '#' }}" alt="Preview" style="max-width: 100px; {{ Session::get('temp_image') ? '' : 'display: none;' }}">
                @if(Session::has('temp_image'))
                    <input type="hidden" name="temp_image" value="{{ Session::get('temp_image') }}">
                @endif
                @error('thumb')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <script>
            function previewImage(input) {
                var preview = document.getElementById('preview');
                
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                } else {
                    @if(Session::has('temp_image'))
                        preview.src = "{{ asset(Session::get('temp_image')) }}";
                        preview.style.display = 'block';
                    @else
                        preview.src = '#';
                        preview.style.display = 'none';
                    @endif
                }
            }
            </script>

            <div class="form-group">
                <label>Kích Hoạt</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active" checked="">
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" >
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
        </div>
        @csrf
    </form>
    
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
        function formatNumber(input) {
            var value = input.value.replace(/\D/g, "");
            var formatted = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            input.value = formatted;
        }  
        document.addEventListener('DOMContentLoaded', function() {
        // Disable tất cả các input số lượng ban đầu
            document.querySelectorAll('.size-checkbox').forEach(checkbox => {
                const quantityInput = checkbox.closest('.size-item').querySelector('.quantity-input');
                if (checkbox.checked) {
                    quantityInput.disabled = false;
                    quantityInput.required = true;
                } else {
                    quantityInput.disabled = true;
                    quantityInput.required = false;
                }
        });

        // Thêm event listener cho các checkbox size
            document.querySelectorAll('.size-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                // Tìm input số lượng tương ứng
                    const quantityInput = this.closest('.size-item').querySelector('.quantity-input');
                
                    if (this.checked) {
                    // Nếu size được chọn
                        quantityInput.disabled = false;
                        quantityInput.required = true;
                        if (!quantityInput.value) {
                            quantityInput.value = '1'; // Giá trị mặc định khi check
                        }
                    } else {
                    // Nếu size bị bỏ chọn
                        quantityInput.disabled = true;
                        quantityInput.required = false;
                        quantityInput.value = ''; // Xóa giá trị
                    }
                });
            });

        // Validate số lượng khi nhập
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                // Chỉ cho phép nhập số
                    this.value = this.value.replace(/[^0-9]/g, '');
                
                // Đảm bảo số lượng > 0
                    if (this.value < 0) {
                        this.value = 0;
                    }
                });
            });
        });
    </script>
@endsection