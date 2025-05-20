@extends('admin.main')

@section('content')
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tiêu Đề</label>
                        <input type="text" name="name" value="{{ $slider->name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Đường Dẫn</label>
                        <input type="text" name="url" value="{{ $slider->url }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Mô Tả </label>
                <textarea name="description" class="form-control">{{ $slider->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="thumb">Ảnh sản phẩm</label>
                <div class="mt-2">
                    @if ($slider->thumb)
                        <div class="current-image mb-2">
                            <img id="preview" src="{{ asset($slider->thumb) }}" alt="Preview"
                                style="max-width: 100px; margin-top: 10px;">
                        </div>
                        <input type="hidden" name="current_thumb" value="{{ $slider->thumb }}">
                    @else
                        <img id="preview" src="#" alt="Preview"
                            style="max-width: 200px; margin-top: 10px; display: none;">
                    @endif
                    <div class="mt-2">
                        <label class="btn btn-info">
                            <i class="fas fa-upload"></i> Thay đổi ảnh
                            <input type="file" id="imageInput" name="thumb" accept="image/*" 
                                class="form-control-file" onchange="previewImage(this);" style="display: none;">
                        </label>
                    </div>
                </div>
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
                <label for="menu">Sắp Xếp</label>
                <input type="number" name="sort_by" value="{{ $slider->sort_by }}" class="form-control" >
            </div>

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
            <button type="submit" class="btn btn-primary">Cập nhật Slider</button>
        </div>
        @csrf
    </form>
@endsection