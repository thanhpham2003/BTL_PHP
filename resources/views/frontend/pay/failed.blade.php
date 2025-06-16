<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán thành công</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      background-color: #f2f2f2;
    }
    .success-box {
      background-color: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      margin: 80px auto;
      text-align: center;
    }
    .momo-icon {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: #a50064; /* màu tím MoMo */
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      box-shadow: 0 0 10px rgba(165, 0, 100, 0.5);
    }
    .momo-icon i {
      font-size: 40px;
      color: white;
    }
    .btn-momo {
      background-color: #a50064;
      color: #fff;
      border: none;
    }
    .btn-momo:hover {
      background-color: #88004f;
    }
  </style>
  <!-- Font Awesome để có icon check -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

  <div class="success-box">
    <div class="momo-icon">
        <i class="fa-solid fa-check"></i>
    </div>
    <h2 class="text-success">Thanh toán thành công</h2>
    <p class="mt-3 mb-4">Cảm ơn bạn đã sử dụng dịch vụ. Giao dịch đã được xử lý thành công.</p>

    <a href="/" class="btn btn-momo px-4">Quay về trang chủ</a>
  </div>

</body>
</html>
