@extends('frontend.web')

@section('content')
<main class="main">
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{Storage::url(setting('site_banner'))}})">
        <div class="container">
            <h2 class="breadcrumb-title">Galeri</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li class="active">Galeri</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- gallery-area -->
    <div class="course-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-images"></i> Galeri Foto</span>
                        <h2 class="site-title">Galeri</h2>
                        <p>Kumpulan foto dan dokumentasi kegiatan kami.</p>
                    </div>
                </div>
            </div>
            <div class="row">
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
            <!-- pagination -->
            <div class="pagination-area">
                <div aria-label="Page navigation example">
                    <ul class="pagination">
                        @if($galleryItems->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ url('galeri?page=' . ($galleryItems->currentPage() - 1)) }}" aria-label="Previous">
                                    <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                                </a>
                            </li>
                        @endif

                        @for($i = 1; $i <= $galleryItems->lastPage(); $i++)
                            <li class="page-item {{ $galleryItems->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ url('galeri?page=' . $i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($galleryItems->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ url('galeri?page=' . ($galleryItems->currentPage() + 1)) }}" aria-label="Next">
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
    <!-- gallery-area end -->
</main>
@endsection