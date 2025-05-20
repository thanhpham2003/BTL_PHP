@extends('admin.main')

@section('content')
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tiêu Đề</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Đường Dẫn</label>
                        <input type="text" name="url" value="{{ old('url') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Mô Tả </label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
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
                <label for="menu">Sắp Xếp</label>
                <input type="number" name="sort_by" value="1" class="form-control" >
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
            <button type="submit" class="btn btn-primary">Thêm Slider</button>
        </div>
        @csrf
    </form>
@endsection