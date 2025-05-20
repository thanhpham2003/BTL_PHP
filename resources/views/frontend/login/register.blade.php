<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center text-gray-700">Đăng ký tài khoản</h2>
        <!-- Form Đăng ký -->
        <form action="{{ route('fr.post.register') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-600">Tên</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-600">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-600">Mật khẩu</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Đăng
                ký</button>
        </form>

    </div>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Đăng ký thành công!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Đăng nhập'
        }).then(() => {
            window.location.href = "{{ route('fr.login') }}";
        });
    </script>
@endif

</body>


</html>
