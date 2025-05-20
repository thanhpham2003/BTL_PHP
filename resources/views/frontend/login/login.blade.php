<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - PmouShop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-96">

        <!-- Hiển thị lỗi từ session (ví dụ đăng nhập thất bại) -->
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Đăng nhập thất bại!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Thử lại'
                });
            </script>
        @endif

        <h2 class="text-2xl font-bold text-center mb-6">Đăng nhập</h2>

        <!-- Form đăng nhập -->
        <form id="login-form">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập email" required>
                <p id="email-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <!-- Mật khẩu -->
            <div class="mb-4">
                <label class="block text-gray-700">Mật khẩu</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập mật khẩu" required>
                <p id="password-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <!-- Nút đăng nhập -->
            <button type="submit" id="submit-btn"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Đăng nhập</button>
        </form>

        <!-- Link tới trang đăng ký -->
        <p class="text-center text-sm text-gray-600 mt-4">Chưa có tài khoản?
            <a href="{{ route('fr.register') }}" class="text-blue-500">Đăng ký</a>
        </p>

    </div>

    <!-- Xử lý AJAX đăng nhập -->
    <script>
        $(document).ready(function () {
            $('#login-form').submit(function (event) {
                event.preventDefault(); // Chặn tải lại trang

                // Xóa lỗi cũ
                $('#email-error').addClass('hidden');
                $('#password-error').addClass('hidden');

                // Lấy dữ liệu form
                let formData = $(this).serialize();
                let submitBtn = $('#submit-btn');

                // Hiệu ứng loading
                submitBtn.prop('disabled', true).text('Đang xử lý...');

                $.ajax({
                    url: "{{ route('fr.post.login') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        // Nếu đăng nhập thành công
                        if (response.status === "success") {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function (xhr) {
                        submitBtn.prop('disabled', false).text('Đăng nhập');

                        if (xhr.status === 422) {
                            // Hiển thị lỗi validation
                            let errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('#email-error').text(errors.email[0]).removeClass('hidden');
                            }
                            if (errors.password) {
                                $('#password-error').text(errors.password[0]).removeClass('hidden');
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: xhr.responseJSON.message || 'Có lỗi xảy ra, vui lòng thử lại!',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Thử lại'
                            });
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>
