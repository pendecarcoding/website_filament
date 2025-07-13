@extends('frontend.web')

@section('content')
<main class="main">
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{Storage::url(setting('site_banner'))}})">
        <div class="container">
            <h2 class="breadcrumb-title">Produk Hukum</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li class="active">Produk Hukum</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->
    <div class="hero-section searh-wrapper">
        <form method="GET" action="{{ route('produk-hukum') }}" accept-charset="UTF-8" autocomplete="off">
            @csrf
            <div class="banner-form-box">
                <div class="banner-form-input">
                    <input name="search" type="text" placeholder="Kata Kunci" value="{{ old('search', request('search')) }}" maxlength="255" pattern="[A-Za-z0-9\s\-_.,]+" title="Hanya huruf, angka, dan karakter khusus dasar diperbolehkan">
                    @error('search')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="banner-form-input">
                    <input type="text" name="nomor" placeholder="Nomor" value="{{ old('nomor', request('nomor')) }}" maxlength="50" pattern="[A-Za-z0-9\s\-_.,/]+" title="Hanya huruf, angka, dan karakter khusus dasar diperbolehkan">
                    @error('nomor')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="banner-form-input">
                    <select name="tahun" class="form-select select2" data-placeholder="Pilih Tahun">
                        <option value="">Pilih Tahun</option>
                        @for($i = 2016; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ old('tahun', request('tahun')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                    @error('tahun')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="banner-form-input">
                    <select class="form-select select2" name="kategori" data-placeholder="Kategori Produk Hukum">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('kategori', request('kategori')) == $category->id ? 'selected' : '' }}>{{ e($category->name) }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="banner-form-input">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <!-- gallery-area -->
    <div class="course-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-images"></i> Produk Hukum</span>
                        <h2 class="site-title">Produk Hukum</h2>
                        <p>Kumpulan produk hukum dan peraturan.</p>
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
                            <h4 class="event-title"><a href="#">{{ $produk->judul }}</a></h4>
                            <div class="event-meta">
                                <span class="event-date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($produk->created_at)->translatedFormat('l, d F Y') }}</span>
                                <span class="event-time"><i class="far fa-eye"></i>Dibaca : {{ $produk->dibaca }} Kali</span>
                            </div>
                            <div class="event-btn">
                                <a href="{{ route('produk-hukum.detail', $produk->judul) }}" class="theme-btn-read-download">Baca<i class="fas fa-eye"></i></a>
                                <a href="{{Storage::url($produk->file_produk_hukum)}}" target="_blank" class="theme-btn-read-download">Download<i class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <!-- pagination -->
            <div class="pagination-area">
                <div aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        @if($produkHukum->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                            </a>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $produkHukum->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                            </a>
                        </li>
                        @endif

                        @for($i = 1; $i <= $produkHukum->lastPage(); $i++)
                            <li class="page-item {{ $produkHukum->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $produkHukum->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor

                            @if($produkHukum->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $produkHukum->nextPageUrl() }}" aria-label="Next">
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