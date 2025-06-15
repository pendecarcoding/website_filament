@extends('frontend.web')

@section('content')
<main class="main">
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{Storage::url(setting('site_banner'))}})">
        <div class="container">
            <h2 class="breadcrumb-title">Statistik</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li class="active">Statistik</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- statistics-area -->
    <div class="course-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-chart-bar"></i> Statistik</span>
                        <h2 class="site-title">Statistik <span>Produk Hukum</span></h2>
                        <p>Data statistik produk hukum berdasarkan kategori dan tahun.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="my-grid" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td width="3%">No</td>
                                    <td width="41%">Kategori Produk Hukum</td>
                                    @php
                                        $years = array_keys(array_diff_key($statistics[0], ['category' => '']));
                                        sort($years);
                                    @endphp
                                    @foreach($years as $year)
                                        <td align="center">{{ $year }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics as $index => $stat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $stat['category'] }}</td>
                                    @foreach($years as $year)
                                        <td align="center">{{ $stat[$year] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- statistics-area end -->
</main>
@endsection