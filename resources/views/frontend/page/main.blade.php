@extends('frontend.web')

@section('content')



<main class="main">

        <!-- hero slider -->
        <div class="hero-section">
            <div class="hero-slider owl-carousel owl-theme">
                @foreach ($sliders as $slider)
                <div class="hero-single" style="height: 58vh;background: url({{ asset('storage/' . $slider->image_path) }})">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-lg-7">
                            <div class="hero-content">

                                    <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                    {{ $slider->title }}
                                    </h1>
                                    <p data-animation="fadeInLeft" data-delay=".75s">
                                       Kabupaten Bengkalis
                                    </p>
                                    <!-- <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                        <a href="about.html" class="theme-btn">About More<i
                                                class="fas fa-arrow-right-long"></i></a>
                                        <a href="contact.html" class="theme-btn theme-btn2">Learn More<i
                                                class="fas fa-arrow-right-long"></i></a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach



            </div>
        </div>
        <!-- hero slider end -->
        <div class="hero-section searh-wrapper" >
        <form method="GET" action="{{ route('produk-hukum') }}" accept-charset="UTF-8" autocomplete="off">
                           <div class="banner-form-box">
                              <div class="banner-form-input">
                                 <input name="search" type="text" placeholder="Kata Kunci" value="{{ request('search') }}">
                              </div>
                               <div class="banner-form-input">
                                 <input type="text" name="nomor" placeholder="Nomor" value="{{ request('nomor') }}">
                              </div>
                               <div class="banner-form-input">
                                 <select name="tahun" class="form-select select2" data-placeholder="Pilih Tahun">
                                   <option value="">Pilih Tahun</option>
                                   @for($i = 2016; $i <= date('Y'); $i++)
                                   <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                   @endfor
                                 </select>
                              </div>
                              <div class="banner-form-input">
                                 <select class="form-select select2" name="kategori" data-placeholder="Kategori Produk Hukum">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="banner-form-input">
                                 <button type="submit"><i class="fa fa-search"></i></button>
                              </div>
                           </div>
                        </form>
                        </div>




        <!-- about area -->
        <div class="about-area py-120">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                            <div class="about-img">
                                <div class="row g-4">
                                    <img class="img-1" src="{{Storage::url(setting('site_profile'))}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline">JDIH PEMERINTAH KABUPATEN BENGKALIS</span>
                                <h2 class="site-title">
                                    Selayang Pandang
                                </h2>
                            </div>
                            <p class="about-text">
                               Bagian Hukum Sekretariat Daerah Kabupaten Bengkalis merupakan unit kerja yang berperan strategis dalam pengelolaan Jaringan Dokumentasi dan Informasi Hukum (JDIH). Sebagai bagian dari sistem nasional JDIH, kami bertugas menyediakan akses informasi hukum yang lengkap, akurat, dan dapat diandalkan untuk mendukung transparansi, akuntabilitas, serta kepastian hukum di lingkungan Pemerintah Kabupaten Bengkalis. <br> <br> Melalui platform ini, masyarakat dapat dengan mudah memperoleh berbagai produk hukum daerah yang telah diterbitkan oleh Pemerintah Kabupaten Bengkalis.
                            </p>
                            <br>
                            <p class="about-text">Informasi Produk Hukum
Kami menyediakan akses terbuka terhadap berbagai regulasi dan kebijakan daerah, yang meliputi:</p>
                            <div class="about-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="about-item">

                                            <div class="about-item-icon">
                                                <img src="assets/img/icon/open-book.svg" alt="">
                                            </div>

                                            <div class="about-item-content">
                                                <h5>Informasi Peraturan Daerah Pemerintah Kabupaten Bengkalis</h5>
                                                <p>Telusuri dan unduh Peraturan Daerah (Perda) yang mengatur berbagai aspek penyelenggaraan pemerintahan dan pembangunan daerah.</p>
                                            </div>
                                        </div>
                                        <div class="about-item">
                                            <div class="about-item-icon">
                                                <img src="assets/img/icon/global-education.svg" alt="">
                                            </div>
                                            <div class="about-item-content">
                                                <h5>Peraturan Bupati Kabupaten Bengkalis</h5>
                                                <p>Akses dokumen Peraturan Bupati (Perbup) yang merupakan pelaksanaan teknis dari Perda dan pengaturan kebijakan internal pemerintahan.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->



        <!-- feature area -->
        <div class="feature-area pt-10 pb-100">
            <!-- <div class="container">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-2">
                        <div class="feature-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="feature-icon">
                                <img src="assets/img/icon/scholarship.svg" alt="">
                            </div>
                            <div class="feature-content">
                                <h4 class="feature-title">Produk Hukum</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="feature-item active wow fadeInDown" data-wow-delay=".25s">
                            <div class="feature-icon">
                                <img src="assets/img/icon/teacher.svg" alt="">
                            </div>
                            <div class="feature-content">
                                <h4 class="feature-title">PERDA</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="feature-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="feature-icon">
                                <img src="assets/img/icon/library.svg" alt="">
                            </div>
                            <div class="feature-content">
                                <h4 class="feature-title">PERBUP</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="feature-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="feature-icon">
                                <img src="assets/img/icon/money.svg" alt="">
                            </div>
                            <div class="feature-content">
                                <h4 class="feature-title">Statistik</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="feature-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="feature-icon">
                                <img src="assets/img/icon/money.svg" alt="">
                            </div>
                            <div class="feature-content">
                                <h4 class="feature-title">Dasar Hukum</h4>
                            </div>
                        </div>
                    </div>

                     <div class="col-md-6 col-lg-2">
                        <div class="feature-item wow fadeInDown" data-wow-delay=".25s">
                            <div class="feature-icon">
                                <img src="assets/img/icon/money.svg" alt="">
                            </div>
                            <div class="feature-content">
                                <h4 class="feature-title">FAQ</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="container">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="site-heading text-center">
                <h2 class="site-title">Daftar<span> Menu</span></h2>
                <p>Berikut adalah daftar menu yang memudahkan Anda dalam mengakses informasi penting terkait produk hukum, regulasi daerah, dan data statistik secara cepat dan terstruktur.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Menu 1 -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="department-item wow fadeInUp" data-wow-delay=".25s">
                <div class="department-icon">
                    <img src="assets/img/icon/monitor.svg" alt="Produk Hukum">
                </div>
                <div class="department-info">
                    <h4 class="department-title"><a href="{{ route('produk-hukum') }}">Produk Hukum</a></h4>
                    <p>Beragam dokumen hukum yang telah diterbitkan secara resmi.</p>
                    <div class="department-btn">
                        <a href="{{ route('produk-hukum') }}">Selengkapnya <i class="fas fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu 2 -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="department-item wow fadeInUp" data-wow-delay=".50s">
                <div class="department-icon">
                    <img src="assets/img/icon/law.svg" alt="Peraturan Daerah">
                </div>
                <div class="department-info">
                    <h4 class="department-title"><a href="{{ route('produk-hukum') }}">Peraturan Daerah</a></h4>
                    <p>Kumpulan Perda yang berlaku dan menjadi acuan hukum di daerah.</p>
                    <div class="department-btn">
                        <a href="{{ route('produk-hukum') }}">Selengkapnya <i class="fas fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu 3 -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="department-item wow fadeInUp" data-wow-delay=".75s">
                <div class="department-icon">
                    <img src="assets/img/icon/data.svg" alt="Peraturan Bupati">
                </div>
                <div class="department-info">
                    <h4 class="department-title"><a href="{{ route('produk-hukum') }}">Peraturan Bupati</a></h4>
                    <p>Informasi mengenai kebijakan yang ditetapkan oleh Bupati setempat.</p>
                    <div class="department-btn">
                        <a href="{{ route('produk-hukum') }}">Selengkapnya <i class="fas fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu 4 -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="department-item wow fadeInUp" data-wow-delay="1s">
                <div class="department-icon">
                    <img src="assets/img/icon/health.svg" alt="Statistik">
                </div>
                <div class="department-info">
                    <h4 class="department-title"><a href="{{ route('statistik') }}">Statistik</a></h4>
                    <p>Data dan statistik yang mendukung kebijakan publik berbasis fakta.</p>
                    <div class="department-btn">
                        <a href="{{ route('statistik') }}">Selengkapnya <i class="fas fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu 5 -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="department-item wow fadeInUp" data-wow-delay=".25s">
                <div class="department-icon">
                    <img src="assets/img/icon/art.svg" alt="Dasar Hukum">
                </div>
                <div class="department-info">
                    <h4 class="department-title"><a href="{{ route('page', 'dasar-hukum') }}">Dasar Hukum</a></h4>
                    <p>Referensi hukum utama yang menjadi landasan kebijakan dan regulasi.</p>
                    <div class="department-btn">
                        <a href="{{ route('page', 'dasar-hukum') }}">Selengkapnya <i class="fas fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu 6 -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="department-item wow fadeInUp" data-wow-delay=".50s">
                <div class="department-icon">
                    <img src="assets/img/icon/information.svg" alt="FAQ">
                </div>
                <div class="department-info">
                    <h4 class="department-title"><a href="{{ route('faq') }}">FAQ</a></h4>
                    <p>Pertanyaan umum yang sering ditanyakan terkait layanan dan sistem.</p>
                    <div class="department-btn">
                        <a href="{{ route('faq') }}">Selengkapnya <i class="fas fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
        <!-- feature area end -->


        <!-- counter area -->
        <div class="counter-area pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="assets/img/icon/course.svg" alt="">
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $countProdukHukumPerda }}" data-speed="3000">{{ $countProdukHukumPerda }}</span>
                                <h6 class="title">Peraturan Daerah</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="assets/img/icon/graduation.svg" alt="">
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $countProdukHukumBupati }}" data-speed="3000">{{ $countProdukHukumBupati }}</span>
                                <h6 class="title">Peraturan Bupati</h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- counter area end -->



        <!-- course-area -->
        <div class="course-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <!-- <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Publikasi</span> -->
                            <h2 class="site-title">Produk Hukum <span>Terbaru</span></h2>
                            <p>Akses cepat ke Perda dan Perbup terbaru yang diterbitkan Pemerintah Kabupaten Bengkalis, disajikan secara lengkap dan mudah diakses untuk mendukung transparansi publik.</p>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    @foreach ($produkHukum as $produk)
                    <div class="col-lg-12">
                        <div class="event-item">
                            <div class="event-location">
                                <span class="course-level">{{ $produk->no_peraturan }}</span>
                                <span class="course-level2">{{ $produk->category->name }}</span>
                            </div>
                            <div class="event-info">
                                <div class="event-meta">
                                    <span class="event-date"><i class="far fa-calendar-alt"></i>{{ $produk->tanggal_terbit }}</span>
                                    <span class="event-time"><i class="far fa-clock"></i>{{ $produk->waktu_terbit }}</span>
                                </div>
                                <h4 class="event-title"><a href="#">{{ $produk->judul }}</a></h4>
                                <div class="event-btn">
                                    <a href="{{ route('produk-hukum.detail', $produk->judul) }}" class="theme-btn-read-download">Baca<i class="fas fa-eye"></i></a>
                                    <a href="{{Storage::url($produk->file_produk_hukum)}}" target="_blank" class="theme-btn-read-download">Download<i class="fas fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                <center><a class="theme-btn" style="background-color: orange;" href="{{ route('produk-hukum') }}">Produk Hukum Lainnya<i class="fas fa-arrow-right-long"></i></a></center>

                </div>
            </div>
        </div>
        <!-- course-area -->

          <!-- team-area -->
        <div class="team-area py-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <h2 class="site-title">Struktur <span>Organisasi</span></h2>
                            <p>Berikut adalah struktur organisasi JDIH Kabupaten Bengkalis yang terdiri dari Aparatur Sipil Negara (ASN) yang berdedikasi dalam memberikan pelayanan informasi hukum. Setiap pegawai memiliki peran dan tanggung jawab masing-masing dalam mendukung transparansi dan akuntabilitas penyelenggaraan pemerintahan.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($employees as $employee)
                    <div class="col-md-6 col-lg-3">
                        <div class="team-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="team-img">
                                <img src="{{ asset('storage/' . $employee->image_path) }}" alt="{{ $employee->nama_pegawai }}">
                            </div>
                            <!-- <div class="team-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-whatsapp"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div> -->
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="#">{{ $employee->nama_pegawai }}</a></h5>
                                    <span>{{ $employee->jabatan }}</span>
                                </div>
                            </div>
                            <!-- <span class="team-social-btn"><i class="far fa-share-nodes"></i></span> -->
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>
        <!-- team-area end -->


        <!-- video-area -->
        <div class="video-area">
            <div class="container">
                <div class="video-content" style="background-image: url(assets/img/video/01.jpg);">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="video-wrapper">
                                <a class="play-btn popup-youtube" href="https://www.youtube.com/watch?v=kwyKNhkHYgE">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- video-area end -->


         <!-- gallery area -->
         <div class="gallery-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">

                            <h2 class="site-title">Galeri <span>Kegiatan</span></h2>
                            <p>Lihat dokumentasi kegiatan dan acara penting di lingkungan Pemerintah Kabupaten Bengkalis.</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach ($galleryItems->items() as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <div class="gallery-img">
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}">
                                <div class="gallery-overlay">
                                    <a href="{{ $item['link'] }}" class="gallery-icon">
                                        <i class="fas fa-link"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="gallery-content">
                                <h4 class="gallery-title">
                                    <a href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                                </h4>
                                <span class="gallery-date">{{ $item['date'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <center><a class="theme-btn" style="background-color: orange;" href="{{ route('galeri') }}">Galeri Lainnya<i class="fas fa-arrow-right-long"></i></a></center>

            </div>
        </div>
        <!-- gallery area end -->


        <!-- enroll area-->
        <!-- <div class="enroll-area pt-80 pb-80">
            <div class="container">
                <div class="col-lg-12">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-6">
                            <div class="enroll-left wow fadeInLeft" data-wow-delay=".25s">
                                <div class="enroll-form">
                                    <div class="enroll-form-header">
                                        <h3>Start Your Enrollment</h3>
                                        <p>We are variations of passages the have suffered.</p>
                                    </div>
                                    <form action="#">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Your Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email Address">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select" name="service">
                                                <option value="">Choose Course</option>
                                                <option value="1">Art And Design</option>
                                                <option value="2">Acting And Drama</option>
                                                <option value="3">Accounting And Finance</option>
                                                <option value="4">Biology And Conservation</option>
                                                <option value="5">Science And Engineering</option>
                                                <option value="6">Health Administration</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="message" class="form-control" placeholder="Type Message"
                                                rows="4"></textarea>
                                        </div>
                                        <button class="theme-btn">Enroll Now<i class="fas fa-arrow-right-long"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="enroll-right wow fadeInUp" data-wow-delay=".25s">
                                <div class="skill-content">
                                    <div class="site-heading mb-3">
                                        <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Our Skills</span>
                                        <h2 class="site-title text-white">
                                            Explore Your <span>Creativity And Talent</span> With Us
                                        </h2>
                                    </div>
                                    <p class="text-white">
                                        There are many variations of passages available but the majority have suffered
                                        alteration in some form by injected humour randomised words which don't look even
                                        slightly believable. If you are going to use passage you need sure there anything
                                        embarrassing first true generator on the Internet.
                                    </p>
                                    <div class="skills-section">
                                        <div class="progress-box">
                                            <h5>Our Students <span class="pull-right">85%</span></h5>
                                            <div class="progress" data-value="85">
                                                <div class="progress-bar" role="progressbar"></div>
                                            </div>
                                        </div>
                                        <div class="progress-box">
                                            <h5>Our Teachers <span class="pull-right">65%</span></h5>
                                            <div class="progress" data-value="65">
                                                <div class="progress-bar" role="progressbar"></div>
                                            </div>
                                        </div>
                                        <div class="progress-box">
                                            <h5>Our Courses <span class="pull-right">75%</span></h5>
                                            <div class="progress" data-value="75">
                                                <div class="progress-bar" role="progressbar"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="contact.html" class="theme-btn mt-5">Learn More<i class="fas fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- enroll area end -->


        <!-- department area -->
        <!-- <div class="department-area bg py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Department</span>
                            <h2 class="site-title">Browse Our <span>Department</span></h2>
                            <p>It is a long established fact that a reader will be distracted by the readable content of
                                a page when looking at its layout.</p>
                        </div>
                    </div>
                </div>
                <div class="department-slider owl-carousel owl-theme">
                    <div class="department-item">
                        <div class="department-icon">
                            <img src="assets/img/icon/monitor.svg" alt="">
                        </div>
                        <div class="department-info">
                            <h4 class="department-title"><a href="academic-single.html">Business And Finance</a></h4>
                            <p>There are many variations of passages the majority have some injected humour.</p>
                            <div class="department-btn">
                                <a href="academic-single.html">Selengkapnya<i class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="department-item">
                        <div class="department-icon">
                            <img src="assets/img/icon/law.svg" alt="">
                        </div>
                        <div class="department-info">
                            <h4 class="department-title"><a href="academic-single.html">Law And Criminology</a></h4>
                            <p>There are many variations of passages the majority have some injected humour.</p>
                            <div class="department-btn">
                                <a href="academic-single.html">Selengkapnya<i class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="department-item">
                        <div class="department-icon">
                            <img src="assets/img/icon/data.svg" alt="">
                        </div>
                        <div class="department-info">
                            <h4 class="department-title"><a href="academic-single.html">IT And Data Science</a></h4>
                            <p>There are many variations of passages the majority have some injected humour.</p>
                            <div class="department-btn">
                                <a href="academic-single.html">Selengkapnya<i class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="department-item">
                        <div class="department-icon">
                            <img src="assets/img/icon/health.svg" alt="">
                        </div>
                        <div class="department-info">
                            <h4 class="department-title"><a href="academic-single.html">Health And Medicine</a></h4>
                            <p>There are many variations of passages the majority have some injected humour.</p>
                            <div class="department-btn">
                                <a href="academic-single.html">Selengkapnya<i class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="department-item">
                        <div class="department-icon">
                            <img src="assets/img/icon/art.svg" alt="">
                        </div>
                        <div class="department-info">
                            <h4 class="department-title"><a href="academic-single.html">Art And Design</a></h4>
                            <p>There are many variations of passages the majority have some injected humour.</p>
                            <div class="department-btn">
                                <a href="academic-single.html">Selengkapnya<i class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- department area end -->


        <!-- faq area -->
        <div class="faq-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="faq-right">
                            <div class="site-heading mb-3">
                                <!-- <span class="site-title-tagline justify-content-start"><i class="far fa-book-open-reader"></i> FAQ</span> -->
                                <h2 class="site-title my-3">Pertanyaan yang <span>Sering Diajukan</span></h2>
                            </div>
                            <p class="mb-3">Jaringan Dokumentasi dan Informasi Hukum (JDIH) adalah sistem informasi hukum yang menyediakan akses terhadap berbagai produk hukum daerah. Berikut adalah beberapa pertanyaan yang sering diajukan terkait layanan JDIH Kabupaten Bengkalis.</p>
                            <p class="mb-4">
                                JDIH Kabupaten Bengkalis berkomitmen untuk memberikan layanan informasi hukum yang akurat, lengkap, dan mudah diakses oleh masyarakat. Kami terus berupaya meningkatkan kualitas layanan untuk mendukung transparansi dan kepastian hukum di Kabupaten Bengkalis.
                            </p>
                            <!-- <a href="contact.html" class="theme-btn mt-2">Ada Pertanyaan Lain?</a> -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <span><i class="far fa-question"></i></span> Apa itu JDIH?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        JDIH (Jaringan Dokumentasi dan Informasi Hukum) adalah sistem informasi hukum yang menyediakan akses terhadap berbagai produk hukum daerah. JDIH Kabupaten Bengkalis merupakan bagian dari sistem nasional JDIH yang bertujuan untuk menyediakan informasi hukum yang lengkap dan akurat.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <span><i class="far fa-question"></i></span> Produk hukum apa saja yang tersedia di JDIH?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        JDIH Kabupaten Bengkalis menyediakan berbagai produk hukum seperti Peraturan Daerah (Perda), Peraturan Bupati (Perbup), dan produk hukum daerah lainnya yang telah diterbitkan oleh Pemerintah Kabupaten Bengkalis.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <span><i class="far fa-question"></i></span> Bagaimana cara mengakses produk hukum di JDIH?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Anda dapat mengakses produk hukum melalui website JDIH Kabupaten Bengkalis. Produk hukum dapat diunduh dalam format PDF dan dapat diakses secara gratis oleh masyarakat.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        <span><i class="far fa-question"></i></span> Apakah ada biaya untuk mengakses JDIH?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Tidak ada biaya untuk mengakses dan mengunduh produk hukum melalui JDIH Kabupaten Bengkalis. Layanan ini disediakan secara gratis untuk mendukung transparansi dan akses informasi hukum bagi masyarakat.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- faq area end -->


        <!-- testimonial area -->
        <!-- <div class="testimonial-area bg pt-80 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Testimonials</span>
                            <h2 class="site-title">What Our Students <span>Say's</span></h2>
                            <p>It is a long established fact that a reader will be distracted by the readable content of
                                a page when looking at its layout.</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slider owl-carousel owl-theme">
                    <div class="testimonial-item">
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of tend to repeat chunks some all form necessary injected for the going are humour words.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/01.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Anthony Nicoll</h4>
                                <p>Student</p>
                            </div>
                        </div>
                        <span class="testimonial-quote-icon"><i class="far fa-quote-right"></i></span>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of tend to repeat chunks some all form necessary injected for the going are humour words.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/02.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Richard Lock</h4>
                                <p>Student</p>
                            </div>
                        </div>
                        <span class="testimonial-quote-icon"><i class="far fa-quote-right"></i></span>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of tend to repeat chunks some all form necessary injected for the going are humour words.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/03.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Randal Grand</h4>
                                <p>Student</p>
                            </div>
                        </div>
                        <span class="testimonial-quote-icon"><i class="far fa-quote-right"></i></span>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of tend to repeat chunks some all form necessary injected for the going are humour words.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/04.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Edward Miles</h4>
                                <p>Student</p>
                            </div>
                        </div>
                        <span class="testimonial-quote-icon"><i class="far fa-quote-right"></i></span>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="testimonial-quote">
                            <p>
                                There are many variations of tend to repeat chunks some all form necessary injected for the going are humour words.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/05.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Ninal Gordon</h4>
                                <p>Student</p>
                            </div>
                        </div>
                        <span class="testimonial-quote-icon"><i class="far fa-quote-right"></i></span>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- testimonial area end -->


        <!-- blog area -->
        <div class="blog-area py-115">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <h2 class="site-title">Berita<span> Terbaru</span></h2>
                            <p>Informasi terkini seputar kegiatan, pengumuman, dan perkembangan terbaru dari JDIH Kabupaten Bengkalis untuk meningkatkan transparansi dan akses informasi hukum bagi masyarakat.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($newsItems as $news)
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="blog-date"><i class="fal fa-calendar-alt"></i> {{ $news['date'] }}</div>
                            <div class="blog-item-img">
                                <img src="{{ $news['image_url'] }}" alt="Thumb">
                            </div>
                            <div class="blog-item-info">
                                <div class="blog-item-meta">

                                </div>
                                <h4 class="blog-title">
                                    <a href="{{ $news['link'] }}" target="_blank">{{ $news['title'] }}</a>
                                </h4>
                                <a class="theme-btn" href="{{ $news['link'] }}" target="_blank">Selengkapnya<i class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <center><a class="theme-btn" style="background-color: orange;" href="{{ route('berita') }}">Berita Lainnya<i class="fas fa-arrow-right-long"></i></a></center>
            </div>
        </div>
        <!-- blog area end -->


        <!-- partner area -->
        <div class="partner-area bg pt-50 pb-50">
            <div class="container">
                <div class="partner-wrapper partner-slider owl-carousel owl-theme">
                    @foreach ($partners as $partner)
                    <a href="{{ $partner->link }}" target="_blank"><img src="{{{ url('storage/' . $partner->image_path) }}}" alt="thumb"></a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- partner area end -->

    </main>

@endsection
