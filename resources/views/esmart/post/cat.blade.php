@extends('templates.esmart.layout-post')

@section('main-content')
    <div class="main-content fl-right">
        <div class="section" id="list-blog-wp">
            <div class="section-head clearfix">
                <h3 class="section-title">{{ $infoCat->cat_post_name }}</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($postCat as $item)
                        <li class="clearfix bg-white mb-3 border p-3">
                            <a href="{{ route('esmart.post.detail', [$item->post_slug, $item->post_id]) }}" title=""
                                class="thumb fl-left">
                                <img src="uploads/post/{{ $item->post_image }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ route('esmart.post.detail', [$item->post_slug, $item->post_id]) }}" title=""
                                    class="title">
                                    {{ $item->post_name }}
                                </a>
                                <span class="create-date">
                                    @php
                                    $timePost = $item->created_at;
                                    @endphp
                                    {{ $timePost->diffForHumans($now) }}
                                    |
                                    Lượt xem : {{ $item->post_views }}
                                </span>
                                <p class="desc">
                                    {{ $item->post_desc }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="section" id="paging-wp">
            <div class="section-detail">
                {{ $postCat->links('vendor.pagination.pagination-public') }}
            </div>
        </div>
    </div>
@endsection
