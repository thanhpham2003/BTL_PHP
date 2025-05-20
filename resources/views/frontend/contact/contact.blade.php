@extends('frontend.layout')
@section('content')
    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('template/images/bg-01.jpg'); margin-top:120px">
        <h2 class="ltext-105 cl0 txt-center">
            Liên hệ
        </h2>
    </section>


    <!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif


                    <form id="contact-form">
                        @csrf
                        <h4 class="mtext-105 cl2 txt-center p-b-30">
                            Trao đổi
                        </h4>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="email"
                                placeholder="Email của bạn">
                            <img class="how-pos4 pointer-none" src="template/images/icons/icon-email.png" alt="ICON">
                        </div>

                        <div class="bor8 m-b-30">
                            <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="message" placeholder="Bạn cần giúp gì?"></textarea>
                        </div>

                        <button type="submit"
                            class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                            Gửi
                        </button>
                    </form>
                </div>

                @foreach ($infos as $info)
                    <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                        <div class="flex-w w-full p-b-42">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-map-marker"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">
                                    Đỉa chỉ
                                </span>

                                <p class="stext-115 cl1 size-213 p-t-18">
                                    {{ $info->address }}
                            </div>
                        </div>

                        <div class="flex-w w-full p-b-42">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-phone-handset"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">
                                    Số điện thoại
                                </span>

                                <p class="stext-115 cl1 size-213 p-t-18">
                                    {{ $info->phone }}
                                </p>
                            </div>
                        </div>

                        <div class="flex-w w-full">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-envelope"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">
                                    Email
                                </span>

                                <p class="stext-115 cl1 size-213 p-t-18">
                                    {{ $info->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

	
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
	<script>
	$(document).ready(function() {
		$('#contact-form').submit(function(event) {
			event.preventDefault(); // Chặn tải lại trang
	
			let formData = $(this).serialize(); // Lấy dữ liệu form
	
			$.ajax({
				url: "{{ route('fr.contact.send') }}",
				type: "POST",
				data: formData,
				dataType: "json",
				success: function(response) {
					if (response.status === "success") {
						Swal.fire({
							title: "Thành công!",
							text: response.message,
							icon: "success",
							confirmButtonText: "OK"
						});
						$('#contact-form')[0].reset(); // Xóa dữ liệu form sau khi gửi
					} else {
						Swal.fire({
							title: "Lỗi!",
							text: response.message,
							icon: "error",
							confirmButtonText: "OK"
						});
					}
				},
				error: function(xhr) {
					let errorMessage = "Có lỗi xảy ra!";
					if (xhr.responseJSON && xhr.responseJSON.errors) {
						errorMessage = Object.values(xhr.responseJSON.errors).join("\n");
					}
					Swal.fire({
						title: "Lỗi!",
						text: errorMessage,
						icon: "error",
						confirmButtonText: "OK"
					});
				}
			});
		});
	});
	</script>
	
@endsection
