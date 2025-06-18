@extends('frontend.web')
@section('content')
 <main class="main">

        <!-- tuition fee -->
        <div class="tuition-fee py-120">
            <div class="container">
                <div class="tuition-wrap">
                  <div class="mb-2">
                    <h3 class="mb-3">{{ $page->title }}</h3>
                    <div class="content">
                       {!! Str::of($page->content)->sanitizeHtml() !!}
                    </div>
                </div>


                </div>
            </div>
        </div>
        <!-- tuition fee end -->

    </main>

@endsection