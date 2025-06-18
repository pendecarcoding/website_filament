@extends('frontend.web')
@section('content')
 <main class="main">

        <!-- tuition fee -->
        <div class="tuition-fee py-120">
            <div class="container">
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

                </div>
            </div>
        </div>
        <!-- tuition fee end -->

    </main>

@endsection