@extends('frontend.web')

@section('content')
<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{Storage::url(setting('site_banner'))}})">
        <div class="container">
            <h2 class="breadcrumb-title">{{$produkHukum->judul}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="index.html">Home</a></li>
                <li class="active">{{$produkHukum->category->name}}</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->


    <!-- terms of service -->
    <div class="py-120">
        <div class="container">
            <div class="content">
                <h4 class="widget-title">Metadata</h4>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td width="30%">Kode</td>
                            <td><code>{{$produkHukum->id}}</code></td>
                        </tr>
                        <tr>
                            <td>No. Peraturan</td>
                            <td><b>{{$produkHukum->no_peraturan}}</b></td>
                        </tr>
                        <tr>
                            <td>Judul</td>
                            <td>{{$produkHukum->judul}}</td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>{{$produkHukum->category->name}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Penetapan</td>
                            <td>{{$produkHukum->tanggal_penetapan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Diundangkan</td>
                            <td>{{$produkHukum->tanggal_diundangkan}}</td>
                        </tr>



                        <tr>
                            <td>No. Lembaran Daerah</td>
                            <td>{{$produkHukum->no_lembaran_daerah}}</td>
                        </tr>
                        <tr>
                            <td>File Produk Hukum</td>
                            <td>
                                <small>
                                    <a target="_blank" href="{{Storage::url($produkHukum->file_produk_hukum)}}">
                                        <i class="fa fa-lg fa-file-pdf-o text-danger"></i> &nbsp;
                                        {{$produkHukum->file_produk_hukum}} </a>
                                </small>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <object data="{{Storage::url($produkHukum->file_produk_hukum)}}" type="application/pdf" width="100%" height="1000">
                    <p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="{{Storage::url($produkHukum->file_produk_hukum)}}">Download</a>.</p>
                </object>
                <div class="read-more-btn">
                    <a href="https://jdih.bengkaliskab.go.id/web/link/produk-hukum" class="edu-btn">Kembali <i class="icon-4"></i></a>
                </div>
                <div class="share-area">

                    <script async="" src="https://platform-api.sharethis.com/panorama.js"></script><iframe id="pxcelframe" title="pxcelframe" src="//t.sharethis.com/a/t_.htm?ver=1.1814.23411&amp;cid=c010&amp;cls=B#cid=c010&amp;cls=B&amp;dmn=jdih.bengkaliskab.go.id&amp;rnd=1749961481592&amp;tt=t.dhj&amp;dhjLcy=189&amp;lbl=pxcel&amp;flbl=pxcel&amp;ll=d&amp;ver=1.1814.23411&amp;ell=d&amp;cck=__stid&amp;pn=%2Fweb%2Fdetailperaturan%2F499%2Fpengalokasian-bagian-dari-hasil-pajak-dan-retribusi-daerah-kepada-desa-di-kabupaten-bengkalis-tahun-anggaran-2025&amp;qs=na&amp;rdn=jdih.bengkaliskab.go.id&amp;rpn=%2Fweb%2Flink%2Fproduk-hukum&amp;rqs=na&amp;cc=ID&amp;cont=AS&amp;rc=RI&amp;ipaddr=125.165.107.141" style="display: none;"></iframe>
                    <script async="" src="https://count-server.sharethis.com/v2.0/get_counts?cb=window.__sharethis__.cb&amp;url=https%3A%2F%2Fjdih.bengkaliskab.go.id%2Fweb%2Fdetailperaturan%2F499%2Fpengalokasian-bagian-dari-hasil-pajak-dan-retribusi-daerah-kepada-desa-di-kabupaten-bengkalis-tahun-anggaran-2025"></script>
                    <script async="" src="https://buttons-config.sharethis.com/js/5d6241340388510012a26199.js"></script>
                    <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5d6241340388510012a26199&amp;product=inline-share-buttons" async="async"></script>
                    <div class="sharethis-inline-share-buttons m-b10 st-justified st-has-labels  st-inline-share-buttons st-animated" id="st-1">
                        <div class="st-total st-hidden">
                            <span class="st-label"></span>
                            <span class="st-shares">
                                Shares
                            </span>
                        </div>
                        <div class="st-btn st-first" data-network="facebook" style="display: inline-block;">
                            <img alt="facebook sharing button" src="https://platform-cdn.sharethis.com/img/facebook.svg">
                            <span class="st-label">Share</span>
                        </div>
                        <div class="st-btn" data-network="twitter" style="display: inline-block;">
                            <img alt="twitter sharing button" src="https://platform-cdn.sharethis.com/img/twitter.svg">
                            <span class="st-label">Tweet</span>
                        </div>
                        <div class="st-btn" data-network="whatsapp" style="display: inline-block;">
                            <img alt="whatsapp sharing button" src="https://platform-cdn.sharethis.com/img/whatsapp.svg">
                            <span class="st-label">Share</span>
                        </div>
                        <div class="st-btn" data-network="telegram" style="display: inline-block;">
                            <img alt="telegram sharing button" src="https://platform-cdn.sharethis.com/img/telegram.svg">
                            <span class="st-label">Share</span>
                        </div>
                        <div class="st-btn st-last" data-network="googlebookmarks" style="display: inline-block;">
                            <img alt="googlebookmarks sharing button" src="https://platform-cdn.sharethis.com/img/googlebookmarks.svg">
                            <span class="st-label">Mark</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- terms of service end -->

</main>
@endsection
