@extends('frontend.layout')
@section('content')
    <div>
        @include('frontend.homepage.sections.slide', [
            "sliders" => $sliders
        ])
        @include('frontend.homepage.sections.banner')
        @include('frontend.homepage.sections.product')
    </div>
@endsection
