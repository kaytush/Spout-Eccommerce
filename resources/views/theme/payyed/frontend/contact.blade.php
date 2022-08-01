@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

<!-- Page Header
============================================= -->
<section class="page-header page-header-text-light bg-dark-3 py-5">
  <div class="container">
    <div class="row text-center">
      <div class="col-12">
        <ul class="breadcrumb mb-0">
          <li><a href="{{route('main')}}">Home</a></li>
          <li class="active">Contact Us</li>
        </ul>
      </div>
      <div class="col-12">
        <h1>Contact Us</h1>
      </div>
    </div>
  </div>
</section>
<!-- Page Header End -->

<!-- Content
  ============================================= -->
<div id="content">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="bg-white shadow-md rounded h-100 p-3">
          <div class="featured-box text-center">
            <div class="featured-box-icon text-primary mt-4"> <i class="fas fa-map-marker-alt"></i></div>
            <h3>Address</h3>
            <p>{{$basic->address}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="bg-white shadow-md rounded h-100 p-3">
          <div class="featured-box text-center">
            <div class="featured-box-icon text-primary mt-4"> <i class="fas fa-phone"></i> </div>
            <h3>Telephone</h3>
            <p class="mb-0">{{$basic->phone}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="bg-white shadow-md rounded h-100 p-3">
          <div class="featured-box text-center">
            <div class="featured-box-icon text-primary mt-4"> <i class="fas fa-envelope"></i> </div>
            <h3>Business Inquiries</h3>
            <p><a href="mailto:{{$basic->email}}" class="__cf_email__" data-cfemail="mailto:{{$basic->email}}">{{$basic->email}}</a></p>
          </div>
        </div>
      </div>
      <div class="col-12 mb-4">
        <div class="text-center py-5 px-2">
          <h2 class="text-8">Get in touch</h2>
          <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
          <div class="d-flex flex-column">
            <ul class="social-icons social-icons-lg social-icons-colored justify-content-center">
              <li class="social-icons-facebook"><a data-toggle="tooltip" href="{{$basic->facebook}}" target="_blank" title="" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
              <li class="social-icons-twitter"><a data-toggle="tooltip" href="{{$basic->twitter}}" target="_blank" title="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
              <li class="social-icons-linkedin"><a data-toggle="tooltip" href="{{$basic->telegram}}" target="_blank" title="" data-original-title="Telegram"><i class="fab fa-telegram"></i></a></li>
              <li class="social-icons-linkedin"><a data-toggle="tooltip" href="{{$basic->linkedin}}" target="_blank" title="" data-original-title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
              <li class="social-icons-youtube"><a data-toggle="tooltip" href="{{$basic->youtube}}" target="_blank" title="" data-original-title="Youtube"><i class="fab fa-youtube"></i></a></li>
              <li class="social-icons-instagram"><a data-toggle="tooltip" href="{{$basic->instagram}}" target="_blank" title="" data-original-title="Instagram"><i class="fab fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="hero-wrap section shadow-md">
    <div class="hero-mask opacity-9 bg-primary"></div>
    <div class="hero-bg" style="background-image:url('/{{$basic->theme}}/images/bg/image-2.jpg');"></div>
    <div class="hero-content">
      <div class="container text-center">
        <h2 class="text-9 text-white">Awesome Customer Support</h2>
        <p class="text-4 text-white mb-4">Have you any query? Don't worry. We have great people ready to help you whenever you need it.</p>
        <a href="{{route('help')}}" class="btn btn-light">Find out more</a> </div>
    </div>
  </section>
  <!-- Content end -->
</div>

@endsection
