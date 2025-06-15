@extends('frontend.web')

@section('content')
<main class="main">
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{Storage::url(setting('site_banner'))}})">
        <div class="container">
            <h2 class="breadcrumb-title">Berita</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li class="active">Berita</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- news-area -->
    <div class="course-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-newspaper"></i> Berita Terkini</span>
                        <h2 class="site-title">Berita <span>Terbaru</span></h2>
                        <p>Dapatkan informasi terbaru dan terpercaya seputar berita terkini.</p>
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
            <!-- pagination -->
            <div class="pagination-area">
                <div aria-label="Page navigation example">
                    <ul class="pagination">
                        @if($newsItems->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ url('berita?page=' . ($newsItems->currentPage() - 1)) }}" aria-label="Previous">
                                    <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                                </a>
                            </li>
                        @endif

                        @for($i = 1; $i <= $newsItems->lastPage(); $i++)
                            <li class="page-item {{ $newsItems->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ url('berita?page=' . $i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($newsItems->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ url('berita?page=' . ($newsItems->currentPage() + 1)) }}" aria-label="Next">
                                    <span aria-hidden="true"><i class="far fa-arrow-right"></i></span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true"><i class="far fa-arrow-right"></i></span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <!-- pagination end -->
        </div>
    </div>
    <!-- news-area end -->
</main>
@endsection