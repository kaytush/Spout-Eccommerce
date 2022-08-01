@extends('theme.'.$basic->theme.'.layouts.app')
@section('title', $page_title)

@section('content')

  <!-- Content
  ============================================= -->
  <div id="content">

    <!-- Who we are
    ============================================= -->
    <section class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 d-flex">
            <div class="my-auto px-0 px-lg-5 mx-2">
              <h2 class="text-9">Who we are</h2>
              <p class="text-4">Quidam lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. Lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. lisque persius interesset his et, in quot quidam mea essent possim iriure.</p>
            </div>
          </div>
          <div class="col-lg-6 my-auto text-center"> <img class="img-fluid shadow-lg rounded-lg" src="/{{$basic->theme}}/images/who-we-are.jpg" alt=""> </div>
        </div>
      </div>
    </section>
    <!-- Who we are end -->

    <!-- Our Values
    ============================================= -->
    <section class="section bg-white">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-lg-6 order-2 order-lg-1">
            <div class="row">
              <div class="col-6 col-lg-7 ml-auto mb-lg-n5"> <img class="img-fluid rounded-lg shadow-lg" src="/{{$basic->theme}}/images/our-values-vision.jpg" alt="banner"> </div>
              <div class="col-6 col-lg-8 mt-lg-n5"> <img class="img-fluid rounded-lg shadow-lg" src="/{{$basic->theme}}/images/our-values-mission.jpg" alt="banner"> </div>
            </div>
          </div>
          <div class="col-lg-6 d-flex order-1 order-lg-2">
            <div class="my-auto px-0 px-lg-5">
              <h2 class="text-9 mb-4">Our Values</h2>
              <h4 class="text-4 font-weight-500">Our Mission</h4>
              <p class="tex-3" >Quidam lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. Lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. lisque persius interesset his et, in quot quidam mea essent possim iriure.</p>
              <h4 class="text-4 font-weight-500 mb-2">Our Vision</h4>
              <p class="tex-3" >Persequeris quidam lisque persius interesset his et, in quot quidam vim, ad mea essent possim iriure. Lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. lisque persius interesset his et, in quot quidam.</p>
              <h4 class="text-4 font-weight-500 mb-2">Our Goal</h4>
              <p class="tex-3" >Lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. Lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure. lisque persius interesset his et, in quot quidam mea essent possim iriure.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Values end -->

    <!-- Leadership
    ============================================= -->
    <section class="section">
      <div class="container">
        <h2 class="text-9 text-center">Leadership</h2>
        <p class="lead text-center mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        <div class="row">
          <div class="col-sm-6 col-md-3 text-center mb-4 mb-md-0">
            <div class="team rounded d-inline-block"> <img class="img-fluid rounded" alt="" src="/{{$basic->theme}}/images/team/leader.jpg">
              <h3>Neil Patel</h3>
              <p class="text-muted">CEO &amp; Founder</p>
              <ul class="social-icons social-icons-sm d-inline-flex">
                <li class="social-icons-facebook"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social-icons-twitter"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li class="social-icons-google"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Google"><i class="fab fa-google"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-3 text-center mb-4 mb-md-0">
            <div class="team rounded d-inline-block"> <img class="img-fluid rounded" alt="" src="/{{$basic->theme}}/images/team/leader-2.jpg">
              <h3>James Maxwell</h3>
              <p class="text-muted">Co-Founder</p>
              <ul class="social-icons social-icons-sm d-inline-flex">
                <li class="social-icons-facebook"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social-icons-twitter"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li class="social-icons-google"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Google"><i class="fab fa-google"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-3 text-center mb-4 mb-md-0">
            <div class="team rounded d-inline-block"> <img class="img-fluid rounded" alt="" src="/{{$basic->theme}}/images/team/leader-3.jpg">
              <h3>Ruby Clinton</h3>
              <p class="text-muted">Chief Marketing Officer</p>
              <ul class="social-icons social-icons-sm d-inline-flex">
                <li class="social-icons-facebook"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social-icons-twitter"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li class="social-icons-google"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Google"><i class="fab fa-google"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-md-3 text-center mb-4 mb-md-0">
            <div class="team rounded d-inline-block"> <img class="img-fluid rounded" alt="" src="/{{$basic->theme}}/images/team/leader-4.jpg">
              <h3>Miky Sheth</h3>
              <p class="text-muted">General Manager</p>
              <ul class="social-icons social-icons-sm d-inline-flex">
                <li class="social-icons-facebook"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social-icons-twitter"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li class="social-icons-google"><a data-toggle="tooltip" href="javascript:void(0);" target="_blank" title="" data-original-title="Google"><i class="fab fa-google"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Leadership end -->

    <!-- Our Investors
    ============================================= -->
    <section class="section bg-white">
      <div class="container">
        <h2 class="text-9 text-center">Our Investors</h2>
        <p class="lead text-center mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        <div class="brands-grid separator-border">
          <div class="row align-items-center">
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-1.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-2.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-3.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-4.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-5.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-6.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-7.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-8.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-9.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-10.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-11.png" alt="Brands"></a></div>
            <div class="col-6 col-sm-4 col-lg-2 text-center"><a href="javascript:void(0);"><img class="img-fluid" src="/{{$basic->theme}}/images/partner/partner-1.png" alt="Brands"></a></div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Investors end -->

    <!-- Testimonial
    ============================================= -->
    <section class="section">
      <div class="container">
        <h2 class="text-9 text-center">What people are saying about Payyed</h2>
        <p class="lead text-center mb-4">A payments experience people love to talk about</p>
        <div class="owl-carousel owl-theme" data-autoplay="true" data-nav="true" data-loop="true" data-margin="30" data-slideby="2" data-stagepadding="5" data-items-xs="1" data-items-sm="1" data-items-md="2" data-items-lg="2">
          <div class="item">
            <div class="testimonial rounded text-center p-4">
              <p class="text-4">“Easy to use, reasonably priced simply dummy text of the printing and typesetting industry. Quidam lisque persius interesset his et, in quot quidam possim iriure.”</p>
              <strong class="d-block font-weight-500">Jay Shah</strong> <span class="text-muted">Founder at Icomatic Pvt Ltd</span> </div>
          </div>
          <div class="item">
            <div class="testimonial rounded text-center p-4">
              <p class="text-4">“I am happy Working with printing and typesetting industry. Quidam lisque persius interesset his et, in quot quidam persequeris essent possim iriure.”</p>
              <strong class="d-block font-weight-500">Patrick Cary</strong> <span class="text-muted">Freelancer from USA</span> </div>
          </div>
          <div class="item mh-100">
            <div class="testimonial rounded text-center p-4">
              <p class="text-4">“Fast easy to use transfers to a different currency. Much better value that the banks.”</p>
              <strong class="d-block font-weight-500">De Mortel</strong> <span class="text-muted">Online Retail</span> </div>
          </div>
          <div class="item">
            <div class="testimonial rounded text-center p-4">
              <p class="text-4">“I have used them twice now. Good rates, very efficient service and it denies high street banks an undeserved windfall. Excellent.”</p>
              <strong class="d-block font-weight-500">Chris Tom</strong> <span class="text-muted">User from UK</span> </div>
          </div>
          <div class="item">
            <div class="testimonial rounded text-center p-4">
              <p class="text-4">“It's a real good idea to manage your money by payyed. The rates are fair and you can carry out the transactions without worrying!”</p>
              <strong class="d-block font-weight-500">Mauri Lindberg</strong> <span class="text-muted">Freelancer from Australia</span> </div>
          </div>
          <div class="item">
            <div class="testimonial rounded text-center p-4">
              <p class="text-4">“Only trying it out since a few days. But up to now excellent. Seems to work flawlessly. I'm only using it for sending money to friends at the moment.”</p>
              <strong class="d-block font-weight-500">Dennis Jacques</strong> <span class="text-muted">User from USA</span> </div>
          </div>
        </div>
        <div class="text-center mt-4"><a href="javascript:void(0);" class="btn-link text-4">See more people review<i class="fas fa-chevron-right text-2 ml-2"></i></a></div>
      </div>
    </section>
    <!-- Testimonial end -->

    <!-- JOIN US
    ============================================= -->
    <section class="section bg-primary py-5">
      <div class="container text-center">
        <div class="row">
          <div class="col-sm-6 col-md-3">
            <div class="featured-box text-center">
              <div class="featured-box-icon text-light mb-2"> <i class="fas fa-globe"></i> </div>
              <h4 class="text-12 text-white mb-0">180+</h4>
              <p class="text-4 text-white mb-0">Countries</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="featured-box text-center">
              <div class="featured-box-icon text-light mb-2"> <i class="fas fa-dollar-sign"></i> </div>
              <h4 class="text-12 text-white mb-0">120</h4>
              <p class="text-4 text-white mb-0">Currencies</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-3 mt-4 mt-md-0">
            <div class="featured-box text-center">
              <div class="featured-box-icon text-light mb-2"> <i class="fas fa-users"></i> </div>
              <h4 class="text-12 text-white mb-0">2.5M</h4>
              <p class="text-4 text-white mb-0">Users</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-3 mt-4 mt-md-0">
            <div class="featured-box text-center">
              <div class="featured-box-icon text-light mb-2"> <i class="far fa-life-ring"></i> </div>
              <h4 class="text-12 text-white mb-0">24X7</h4>
              <p class="text-4 text-white mb-0">Support</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- JOIN US end -->

  </div>
  <!-- Content end -->

@endsection
