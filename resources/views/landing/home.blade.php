<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>MSC English</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Bootstrap App Landing Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Small Apps Template v1.0">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('landing/images/favicon.png')}}" />
  
  <!-- PLUGINS CSS STYLE -->
  <link rel="stylesheet" href="{{asset('landing/plugins/bootstrap/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('landing/plugins/themify-icons/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('landing/plugins/slick/slick.css')}}">
  <link rel="stylesheet" href="{{asset('landing/plugins/slick/slick-theme.css')}}">
  <link rel="stylesheet" href="{{asset('landing/plugins/fancybox/jquery.fancybox.min.css')}}">
  <link rel="stylesheet" href="{{asset('landing/plugins/aos/aos.css')}}">
  <link rel="stylesheet" href="{{asset('landing/plugins/fontawesome/css/font-awesome.min.css')}}">

  <!-- CUSTOM CSS -->
  <link href="{{asset('landing/css/style.css')}}" rel="stylesheet">
   <style>
    #download:hover{
       background-color: 
    }
   </style>
</head>

<body class="body-wrapper" data-spy="scroll" data-target=".privacy-nav">


<!--============================
=            Banner            =
=============================-->
<div class="section banner-full">
	<div class="container">
		<div class="row">
			
                <div class="col-lg-7 align-self-center">
                    <div class="block">
                        <div class="logo" style="display: flex;flex-direction: row;align-items: center">
                            <img src="{{asset('landing/images/logo.png')}}" width="70px" alt="logo">
                            <h3 style="color: #5c2172;font-size: 40px;padding-left: 10px;font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">MSC english</h3>
                        </div>
                        <h1 style="color:#222;text-align: right">برنامه آموزش زبان انگلیسی
                            <br>
                            ارشد وزارت علوم
                        </h1>
                        <p style="text-align: right;margin-bottom: 5px">
                             بیش از 3000 لغت <i class="fa fa-check" style="color:green"></i>
                        </p>
                        <p style="text-align: right;margin-bottom: 5px">
                            برگزیدن و مرور کلمات <i class="fa fa-check" style="color:green"></i>
                        </p>
                        <p style="text-align: right;margin-bottom: 5px">
                            ده ها آزمون از سال های مختلف <i class="fa fa-check" style="color:green"></i>
                        </p>
                        <p style="text-align: right;margin-bottom: 5px">
                            پاسخنامه تشریحی <i class="fa fa-check" style="color:green"></i>
                        </p>
                        <ul class="list-inline app-badge" style="opacity: 0.5;">
                            <li class="list-inline-item">
                                <a style="cursor: pointer;"><img src="{{asset('landing/images/app/appple-store.jpg')}}" alt="Apple Store"></a>
                            </li>
                            <li class="list-inline-item">
                                <a style="cursor: pointer;"><img src="{{asset('landing/images/app/google-play.jpg')}}" alt="Google Play"></a>
                            </li>
                        </ul>
                        <div class="support">
                            <img class="img-fluid" src="{{asset('landing/images/icons/supported-services.png')}}" alt="supported-services">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 justify-content-xs-center">
                    <div class="image" data-aos="flip-right">
                        <img class="img-fluid" style="height: auto;width: 100%;margin-top:100px" src="{{asset('landing/images/banner.png')}}" alt="Iphone-Black">
                    </div>
                </div>
		</div>
	</div>
</div>
<!--====  End of Banner  ====-->

<!--============================
=            Footer            =
=============================-->

<footer class="footer-classic">
  <ul class="social-icons list-inline">
    <li class="list-inline-item">
      <a  style="cursor: pointer"><i class="ti-facebook"></i></a>
    </li>
    <li class="list-inline-item">
      <a  style="cursor: pointer"><i class="ti-twitter"></i></a>
    </li>
    <li class="list-inline-item">
      <a  style="cursor: pointer"><i class="ti-instagram"></i></a>
    </li>
    <li class="list-inline-item">
      <a style="cursor: pointer"><i class="ti-dribbble"></i></a>
    </li>
  </ul>
  <ul class="footer-links list-inline">
    <li class="list-inline-item">
      <a href="#download" style="cursor: pointer;opacity: 0.5;" id="download">دانلود مستقیم</a>
    </li>
    <li class="list-inline-item">
      <a href="{{url('blog')}}">وبلاگ</a>
    </li>
    {{-- <li class="list-inline-item">
      <a href="privacy-policy.html">قوانین</a>
    </li> --}}
    <li class="list-inline-item">
      <a href="{{url('team')}}">توسعه دهنگان</a>
    </li>
    <li class="list-inline-item">
      <a href="{{ url('contact') }}">تماس با ما</a>
    </li>
    <li class="list-inline-item">
      <a href="{{url('about')}}">درباره ما</a>
    </li>
  </ul>
</footer>


  <!-- To Top -->
  <div class="scroll-top-to">
    <i class="ti-angle-up"></i>
  </div>
  
  <!-- JAVASCRIPTS -->
  <script src="{{asset('landing/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('landing/plugins/bootstrap/bootstrap.min.js')}}"></script>
  <script src="{{asset('landing/plugins/slick/slick.min.js')}}"></script>
  <script src="{{asset('landing/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
  <script src="{{asset('landing/plugins/syotimer/jquery.syotimer.min.js')}}"></script>
  <script src="{{asset('landing/plugins/aos/aos.js')}}"></script>
  <!-- google map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g"></script>
  <script src="{{asset('landing/plugins/google-map/gmap.js')}}"></script>
  
  <script src="{{asset('landing/js/script.js')}}"></script>
</body>

</html>