@extends('frontend.layout')
@section('content')
	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('template/images/bg-02.jpg'); margin-top:120px">
		<h2 class="ltext-105 cl0 txt-center">
			Giới thiệu
		</h2>
	</section>	

	<!-- Content page -->
    @forEach($abouts as $index => $about)
	<section class="bg0 p-t-75 p-b-120">
		<div class="container">
			<div class="row p-b-148">
                @if($index % 2 == 0)
				<div class="col-md-7 col-lg-8">
					<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
						<h3 class="mtext-111 cl2 p-b-16" align="center">
							{{ $about->name }}
						</h3>
						<p class="stext-113 cl6 p-b-26">
                            {!! $about->content !!}
                        </p>
					</div>
				</div>

				<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
					<div class="how-bor1 ">
						<div class="hov-img0">
							<img src="{{ asset($about->thumb) }}" alt="IMG">
						</div>
					</div>
				</div>
                @else
                <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                    <div class="how-bor1">
                        <div class="hov-img0">
                            <img src="{{ asset($about->thumb) }}" alt="IMG">
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">
                    <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                        <h3 class="mtext-111 cl2 p-b-16" align="center">
                            {{ $about->name }}
                        </h3>
                        <p class="stext-113 cl6 p-b-26">
                            {!! $about->content !!}
                        </p>
                    </div>
                </div>
                @endif
			</div>
		</div>
	</section>	
    @endforeach
@endsection
