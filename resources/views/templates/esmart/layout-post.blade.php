@include('templates.esmart.inc.header')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ route('esmart.index.index') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ route('esmart.post.index') }}" title="">Tin tức</a>
                    </li>
                    @if (isset($infoCat))
                        <li>
                            <a href="{{ route('esmart.post.cat', [$infoCat->cat_post_slug, $infoCat->cat_post_id]) }}"
                                title="">{{ $infoCat->cat_post_name }}</a>
                        </li>
                    @endif
                    @if (isset($infoPost))
                        <li>
                            <a href="{{ route('esmart.post.detail', [$infoPost->post_slug, $infoPost->post_id]) }}"
                                title="">{{ $infoPost->post_name }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        @yield('main-content')

        <div class="sidebar fl-left">

            @include('templates.esmart.inc.category-post')

            <div style="margin-top: 25px"></div>

            @include('templates.esmart.inc.post-popular')

        </div>
    </div>
</div>
@include('templates.esmart.inc.footer')
