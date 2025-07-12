 <footer class="footer-area">
     <div class="footer-widget">
         <div class="container">
             <div class="row footer-widget-wrapper pt-100 pb-70">
                 <div class="col-md-6 col-lg-4">
                     <div class="footer-widget-box about-us">
                         <a href="#" class="footer-logo logo-bg-jdih">
                             <img src="{{Storage::url(setting('site_logo', 'default value'))}}" alt="">
                         </a>
                         <p class="mb-3">
                             {{setting("site_description")}}
                         </p>
                         <ul class="footer-contact">
                             <li><a href="tel:+21236547898"><i class="far fa-phone"></i>{{setting("site_phone")}}</a></li>
                             <li><i class="far fa-map-marker-alt"></i>{{setting('site_address')}}</li>
                             <li><a href="mailto:{{setting('site_email')}}"><i
                                         class="far fa-envelope"></i>{{setting('site_email')}}</a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-md-6 col-lg-2">
                     <div class="footer-widget-box list">
                         <h4 class="footer-widget-title">Profil</h4>
                         <ul class="footer-list">
                             @foreach(Biostate\FilamentMenuBuilder\Models\MenuItem::whereHas('menu', function($query) {
                             $query->where('name', 'FOOTER PROFILE');
                             })->whereNull('parent_id')->get() as $menuItem)
                             <li><a href="{{ $menuItem->link }}" target="{{ $menuItem->target }}"><i class="fas fa-caret-right"></i> {{ $menuItem->name }}</a></li>
                             @endforeach
                         </ul>
                     </div>
                 </div>
                 <div class="col-md-6 col-lg-3">
                     <div class="footer-widget-box list">
                         <h4 class="footer-widget-title">Tautan</h4>
                         <ul class="footer-list">
                             @foreach(Biostate\FilamentMenuBuilder\Models\MenuItem::whereHas('menu', function($query) {
                             $query->where('name', 'FOOTER LINKS');
                             })->whereNull('parent_id')->get() as $menuItem)
                             <li><a href="{{ $menuItem->link }}" target="{{ $menuItem->target }}"><i class="fas fa-caret-right"></i> {{ $menuItem->name }}</a></li>
                             @endforeach
                         </ul>
                     </div>
                 </div>
                 <div class="col-md-6 col-lg-3">
                     <div class="footer-widget-box list">

                         <div class="footer-newsletter">

                             <div class="subscribe-form">
                                 <img src="{{asset('assets/img/slider/green2.png')}}" alt="">
                             </div>

                             <!-- Histats.com  (div with counter) -->
                             <div id="histats_counter"></div>
                             <!-- Histats.com  START  (aync)-->
                             <script type="text/javascript">
                                 var _Hasync = _Hasync || [];
                                 _Hasync.push(['Histats.start', '1,4962981,4,204,260,30,00011000']);
                                 _Hasync.push(['Histats.fasi', '1']);
                                 _Hasync.push(['Histats.track_hits', '']);
                                 (function() {
                                     var hs = document.createElement('script');
                                     hs.type = 'text/javascript';
                                     hs.async = true;
                                     hs.src = ('//s10.histats.com/js15_as.js');
                                     (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
                                 })();
                             </script>
                             <noscript><a href="/" target="_blank"><img src="//sstatic1.histats.com/0.gif?4962981&101" alt="website statistics" border="0"></a></noscript>
                             <!-- Histats.com  END  -->
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="copyright">
         <div class="container">
             <div class="copyright-wrapper">
                 <div class="row">
                     <div class="col-md-6 align-self-center">
                         <p class="copyright-text">
                             &copy; Copyright <span id="date"></span> <a href="#"> JDIH Kabupaten Bengkalis </a> Designed By Tim IT JDIH Bengkalis. All Rights Reserved.
                         </p>
                     </div>
                     <div class="col-md-6 align-self-center">
                         <ul class="footer-social">
                             <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                             <li><a href="#"><i class="fab fa-whatsapp"></i></a></li>
                             <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                             <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </footer>