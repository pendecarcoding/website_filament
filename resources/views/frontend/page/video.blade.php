@extends('frontend.web')

@section('content')
<main class="main">
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{Storage::url(setting('site_banner'))}})">
        <div class="container">
            <h2 class="breadcrumb-title">Video</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li class="active">Video</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- video-area -->
    <div class="course-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-video"></i> Galeri Video</span>
                        <h2 class="site-title">Video</h2>
                        <p>Kumpulan video dokumentasi kegiatan kami.</p>
                    </div>
                </div>
            </div>
            <div class="row">
               @foreach ($videoItems->items() as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <div class="gallery-img">
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}">
                                <div class="gallery-overlay">
                                    <a href="{{ $item['link'] }}" class="gallery-icon popup-youtube">
                                        <i class="fas fa-play"></i>
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
            <!-- pagination -->
            <div class="pagination-area">
                <div aria-label="Page navigation example">
                    <ul class="pagination">
                        @if($videoItems->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ url('video?page=' . ($videoItems->currentPage() - 1)) }}" aria-label="Previous">
                                    <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                                </a>
                            </li>
                        @endif

                        @for($i = 1; $i <= $videoItems->lastPage(); $i++)
                            <li class="page-item {{ $videoItems->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ url('video?page=' . $i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($videoItems->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ url('video?page=' . ($videoItems->currentPage() + 1)) }}" aria-label="Next">
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
    <!-- video-area end -->
</main>
@endsection