@extends('templates.esmart.layout-post')

@section('main-content')
    <div class="main-content fl-right bg-white p-3">
        <div class="section" id="detail-blog-wp">
            <div class="section-head clearfix">
                <h3 class="section-title">{{ $infoPost->post_name }}</h3>
            </div>
            <div class="section-detail">
                <span class="create-date">
                    @php
                    $timePost = $infoPost->created_at;
                    @endphp
                    {{ $timePost->diffForHumans($now) }}
                    |
                    Lượt xem : {{ $infoPost->post_views }}
                </span>
                <div class="detail">
                    <p>
                        <strong>{{ $infoPost->post_desc }}</strong>
                    </p>
                    <p style="text-align: center;">
                        <img src="uploads/post/{{ $infoPost->post_image }}" alt="">
                    </p>
                    <p>
                        {!! $infoPost->post_content !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="section" id="social-wp">
            <div class="section-detail">
                {{-- <div class="fb-comments" data-href="http://www.esmart.com/tin-tuc/{{ $infoPost->post_slug }}.html"
                    data-numposts="5" data-width="100%"></div> --}}
            </div>
        </div>
    </div>
    
@endsection
