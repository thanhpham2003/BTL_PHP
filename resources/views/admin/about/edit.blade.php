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
                        <label for="menu">Tiêu đề</label>
                        <input type="text" name="name" value="{{ $about->name }}" class="form-control"  placeholder="Nhập tên tiêu đề">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Mô Tả Chi Tiết</label>
                <textarea name="content" id="content" class="form-control">{{ $about->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="thumb">Ảnh giới thiệu</label>
                <div class="mt-2">
                    @if ($about->thumb)
                        <div class="current-image mb-2">
                            <img id="preview" src="{{ asset($about->thumb) }}" alt="Preview"
                                style="max-width: 100px; margin-top: 10px;">
                        </div>
                        <input type="hidden" name="current_thumb" value="{{ $about->thumb }}">
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
            <button type="submit" class="btn btn-primary">Cập nhật giới thiệu</button>
        </div>
        @csrf
    </form>
    
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection