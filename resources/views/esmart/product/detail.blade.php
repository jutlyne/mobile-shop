@extends('templates.esmart.layout-product')

@section('main-content')

    <style>
        .txt-center {
            font-size: 25px;
            text-align: center;
        }

        .hide {
            display: none;
        }

        .clear {
            float: none;
            clear: both;
        }

        .rating {
            width: 140px;
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: center;
            position: relative;
        }

        .rating>label {
            float: right;
            display: inline;
            padding: 0;
            margin: 0;
            position: relative;
            width: 1.1em;
            cursor: pointer;
            color: #000;
        }

        .rating>label:hover,
        .rating>label:hover~label,
        .rating>input.radio-btn:checked~label {
            color: transparent;
        }

        .rating>label:hover:before,
        .rating>label:hover~label:before,
        .rating>input.radio-btn:checked~label:before,
        .rating>input.radio-btn:checked~label:before {
            content: "\2605";
            position: absolute;
            left: 0;
            color: #FFD700;
        }

        .intro{
          opacity: 0;
          visibility: hidden !important;
        }

        .other{
          border: 1px solid #bebebe;
          color: rgb(255, 255, 255);
          background: #bebebe;
        }

    </style>
    <div class="main-content fl-right">
        <div class="section" id="detail-product-wp">
            <div class="section-detail clearfix">
                <div class="thumb-wp fl-left" style="position: relative; padding: 40px 0px;">
                    <a href="" title="" id="main-thumb">
                        <img id="zoom" src="uploads/product/{{ $infoProduct->product_image }}"
                            data-zoom-image="uploads/product/{{ $infoProduct->product_image }}">
                    </a>
                    <div id="list-thumb">
                        @foreach ($infoProduct->imageGallery as $imageGallery)
                            <a href="" data-image="uploads/gallery/{{ $imageGallery->gallery_path }}"
                                data-zoom-image="uploads/gallery/{{ $imageGallery->gallery_path }}">
                                <img id="zoom" src="uploads/gallery/{{ $imageGallery->gallery_path }}">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="thumb-respon-wp fl-left">
                    <img src="uploads/product/{{ $infoProduct->product_image }}" alt="">
                </div>
                <div class="info fl-right">
                    <h3 class="product-name text-center">{{ $infoProduct->product_name }}</h3>
                    <div class="desc">
                        <p>{!! $infoProduct->product_spec !!}</p>
                    </div>
                    <div class="num-product">
                        <span class="title">S???n ph???m c?? s???n: </span>
                        <span class="status">{{ $infoProduct->product_qty }}</span>
                    </div>
                    @php $dis = 0; @endphp
                    @foreach ($sale as $s)
                      @php
                        $dis = $s->discount;
                      @endphp
                    @endforeach
                    <p class="price">
                        {{ number_format($infoProduct->product_price - ($infoProduct->product_price * $dis) / 100, '0', ',', '.') }}
                        vn??
                    </p>
                    <div id="num-order-wp">
                        <a title="" id="minus"><i class="fa fa-minus"></i></a>
                        <input type="text" class="num-order" value="1" id="num-order">
                        <a title="" id="plus"><i class="fa fa-plus"></i></a>
                    </div>
                    <a href="javascript:void(0)" qty-product="{{ $infoProduct->product_qty }}"
                        data-id="{{ $infoProduct->product_id }}" id="testadd" title="Th??m gi??? h??ng" class="add-cart">Th??m gi??? h??ng</a>
                </div>
            </div>
        </div>
        <div class="section" id="post-product-wp">
            <div class="section-head">
                <h3 class="section-title">M?? t??? s???n ph???m</h3>
            </div>
            <div class="section-detail">
                {!! $infoProduct->product_article !!}
            </div>
        </div>

        <div class="section" id="post-product-wp">
            <div class="section-head">
                <h3 class="section-title">B??nh lu???n - ????nh gi??</h3>
            </div>
            <div class="section-detail">
                <form id="form-add-comment">
                    <label class="text-white bg-success py-1 px-2 rounded mb-2">Nh???n v??o ????y ????? ????nh gi??</label>
                    <input type="hidden" class="product-id" value="{{ $infoProduct->product_id }}">
                    <div class="form-group">
                        <div class="txt-center">
                            <div class="rating">
                                <input id="star5" name="star" type="radio" value="5" class="radio-btn hide" checked />
                                <label for="star5">???</label>
                                <input id="star4" name="star" type="radio" value="4" class="radio-btn hide" />
                                <label for="star4">???</label>
                                <input id="star3" name="star" type="radio" value="3" class="radio-btn hide" />
                                <label for="star3">???</label>
                                <input id="star2" name="star" type="radio" value="2" class="radio-btn hide" />
                                <label for="star2">???</label>
                                <input id="star1" name="star" type="radio" value="1" class="radio-btn hide" />
                                <label for="star1">???</label>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col">
                            <input type="text" name="name" class="name form-control" placeholder="H??? t??n (*)">
                        </div>
                        <div class="col">
                            <input type="text" name="email" class="email form-control" placeholder="Email (*)">
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea name="comment" class="comment form-control" rows="5"
                            placeholder="Nh???p b??nh lu???n c???a b???n (*)"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn bg-success text-white">G???i</button>
                    </div>
                </form>

                <div id="list-comment" class="card p-3 bg-light">
                    @forelse ($listComment as $comment)
                        <div class="media mb-3 border p-1 bg-white">
                            <span class="bg-light p-2 text-muted font-weight-bold mr-3">
                                CM
                            </span>
                            <div class="media-body">
                                <h5 class="mt-0 font-weight-bold">{{ $comment->comment_name }}</h5>
                                <div>
                                    <span class="text-warning">
                                        @for ($i = 1; $i <= $comment->comment_rating; $i++)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        @endfor
                                    </span>
                                    <span class="text-muted">
                                        @php
                                        $time = $comment->comment_date;
                                        @endphp
                                        {{ $time }}
                                    </span>
                                </div>
                                <span>
                                    {{ $comment->comment_content }}
                                </span>

                                @php
                                $commentReply =
                                DB::table('comments')->where('comment_parent',$comment->comment_id)->orderBy('comment_id',
                                'DESC')->get();
                                @endphp
                                @foreach ($commentReply as $item)
                                    <div class="media mt-3">
                                        <span class="bg-light p-2 text-muted font-weight-bold mr-3">
                                            CM
                                        </span>
                                        <div class="media-body">
                                            <h5 class="mt-0 font-weight-bold">
                                                <span class="text-success">
                                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                </span>
                                                {{ $item->comment_name }}
                                            </h5>
                                            <div>
                                                <span class="text-muted">{{ $item->comment_date }}</span>
                                            </div>
                                            <span>
                                                {{ $item->comment_content }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Ch??a c?? b??nh lu???n ????nh gi??</p>
                    @endforelse
                </div>

                <div class="section" id="paging-wp">
                    <div class="section-detail">
                        {{ $listComment->links('vendor.pagination.pagination-public') }}
                    </div>
                </div>

            </div>
        </div>
        <div class="section" id="same-category-wp">
            <div class="section-head">
                <h3 class="section-title">S???n ph???m li??n quan</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($sameProduct as $item)
                        @if ($item->product_id != $infoProduct->product_id)
                            <li>
                                <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                                    title="" class="thumb">
                                    <img src="uploads/product/{{ $item->product_image }}">
                                </a>
                                <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                                    title="" class="product-name">
                                    {{ $item->product_name }}
                                </a>
                                <div class="price">
                                    <span class="new">
                                        {{ number_format($item->product_price - ($item->product_price * $item->product_sale) / 100, 0, ',', '.') }}??
                                    </span>
                                    <span class="text-success">
                                        -{{ $item->product_sale }} %
                                    </span>
                                    <br>
                                    <span class="old">
                                        {{ number_format($item->product_price, 0, ',', '.') }}??
                                    </span>
                                </div>
                                <div class="action clearfix">
                                    <a href="javascript:void(0)" onclick="addCatItem({{ $item->product_id }})"
                                        class="other fl-left">Th??m gi??? h??ng</a>
                                    <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                                        title="" class="buy-now fl-right">Xem chi ti???t</a>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.add-cart', function(e) {
            e.preventDefault();
            var product_id = $(this).attr('data-id');
            var num_order = $('.num-order').val();
            var qty_product = $(this).attr('qty-product');

            if (parseInt(num_order) > parseInt(qty_product)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Th???t b???i...',
                    text: 'S??? l?????ng trong kho kh??ng ?????!',
                });
                return false;
            }

            $.ajax({
                url: "{{ route('esmart.cart.add-cart') }}",
                method: "GET",
                data: {
                    product_id: product_id,
                    num_order: num_order,
                },
                success: function(data) {
                    showCart();
                    Swal.fire({
                        icon: 'success',
                        title: 'Th??nh c??ng!',
                        text: '???? th??m ' + num_order + ' s???n ph???m v??o gi??? h??ng!',
                        footer: '<a href = "' + "{{ route('esmart.cart.show-cart') }}" +
                            '">??i ?????n gi??? h??ng</a>'
                    })
                }
            });
        });

    </script>

    @if (isset($_GET['page']))
        <script>
            $(document).ready(function() {
                var location = $('#list-comment').offset().top;
                $('html,body').animate({
                    scrollTop: location
                }, 400);
                return false;
            });

        </script>
    @endif

    <script>
        $(document).ready(function(){
          $("#num-order").blur(function(){
            var qty = $(this).val();
            var a = document.getElementById('testadd');
            if(qty <= 0){
              Swal.fire({
                  icon: 'error',
                  title: 'Kh??ng h???p l???',
                  text: 'C?? v??? gi?? tr??? c???a b???n nh???p kh??ng h???p l???',
              });
              document.getElementById("num-order").value = 1;
            };
          });
        });
        $('#form-add-comment').on('submit', function(e) {
            e.preventDefault();
            //L???y s??? sao
            var checkbox = document.getElementsByName('star');
            var rating = "";
            for (var i = 0; i < checkbox.length; i++) {
                if (checkbox[i].checked === true) {
                    rating += checkbox[i].value;
                }
            }
            //L???y th??ng tin b??nh lu???n
            var productId = $('#form-add-comment .product-id').val();
            var name = $('#form-add-comment .name').val();
            var email = $('#form-add-comment .email').val();
            var comment = $('#form-add-comment .comment').val();
            //G???i th??ng tin qua ajax
            $.ajax({
                url: "{{ route('esmart.comment.add-comment') }}",
                type: "POST",
                data: {
                    productId: productId,
                    rating: rating,
                    name: name,
                    email: email,
                    comment: comment
                },
                cache: false,
                success: function(data) {
                    if (data.errors) {
                        for (var count = 0; count < data.errors.length; count++) {
                            toastr.error(data.errors[count]);
                        }
                    }
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Th??nh c??ng!',
                            text: 'C???m ??n b???n ???? b??nh lu???n. Ch??ng t??i s??? ph???n h???i trong th???i gian s???m nh???t!',
                        });
                        $('#form-add-comment .name').val('');
                        $('#form-add-comment .email').val('');
                        $('#form-add-comment .comment').val('');
                    }
                }
            });
        });

    </script>
@endsection
