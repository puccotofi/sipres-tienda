@extends('layouts.app')

@section('title','Inicio')

@section('content')
<!-- home section start -->
@include('partials.home')
<!-- Home Section End -->

<!-- Value Section Start 
include('partials.value')
Value Section End -->

<!-- Banner Section Start 
include('partials.banner1')
Banner Section End -->

<!-- Banner Section Start
include('partials.banner2')
Banner Section End -->

<!-- Product Section Start -->
@include('partials.homeproductos')
<!-- Product Section End -->

<!-- Newsletter Section Start -->
@include('partials.newsletter')
<!-- Newsletter Section End -->
<!-- vista rápida -->
@include('partials.productovistarapida')
<!-- vista rápida -->

@endsection
