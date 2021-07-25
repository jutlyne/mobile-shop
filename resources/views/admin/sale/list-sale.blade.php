@extends('templates.admin.master')

@section('main-content')
    <div class="page-header">
        <h3 class="page-title"> DANH SÁCH NGƯỜI DÙNG </h3>
        <p id="result"></p>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="tabs">
                      <div class="wrapper">
                        <div class="buttonWrapper">
                          <button class="tab-button active" style="border-top-left-radius: 10px;" data-id="new">Đang diễn ra khuyến mãi</button>
                          <button class="tab-button" data-id="shipping">Khuyến mãi sắp diễn ra</button>
                          <button class="tab-button" style="border-top-right-radius: 10px;" data-id="cancel">Khuyến mãi đã kết thúc</button>
                        </div>
                        <div class="contentWrapper">
                          <!-- start tab Home -->
                          <div class="table-responsive content active" id="new">
                              <table class="table table-hover" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên khuyến mãi</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody style="text-align : center">
                                    @php
                                    $temp = 1;
                                    $today = date("Y-m-d");
                                    @endphp
                                    @foreach ($sale as $item)
                                      @if(strtotime($today) > strtotime($item->date_start) && strtotime($today) < strtotime($item->date_end))
                                        <tr>
                                            <td>{{ $temp++ }}</td>
                                            <td>
                                                {{ $item->name_sale }}
                                            </td>
                                            <td>
                                                {{ $item->date_start }}
                                            </td>
                                            <td>
                                                {{ $item->date_end }}
                                            </td>
                                            <td>
                                                @if(strtotime($today) > strtotime($item->date_start) && strtotime($today) < strtotime($item->date_end))
                                                  Đang diễn ra
                                                @elseif(strtotime($today) < strtotime($item->date_start))
                                                  Sắp diễn ra
                                                @elseif(strtotime($today) > strtotime($item->date_end))
                                                  Kết thúc
                                                @endif
                                            </td>
                                            <td>
                                              <a href="{{ route('admin.sale.edit-sale', $item->id_sale) }}"
                                                  class="badge badge-gradient-info">
                                                  <i class="mdi mdi-table-edit"></i>
                                              </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                              </table>
                          </div>


                          <!-- end tab Home
                          start tab About -->


                          <div class="table-responsive content" id="shipping">
                              <table class="table table-hover" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên khuyến mãi</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($sale as $item)
                                      @if(strtotime($today) < strtotime($item->date_start))
                                        <tr>
                                            <td>{{ $temp++ }}</td>
                                            <td>
                                                {{ $item->name_sale }}
                                            </td>
                                            <td>
                                                {{ $item->date_start }}
                                            </td>
                                            <td>
                                                {{ $item->date_end }}
                                            </td>
                                            <td>
                                                @if(strtotime($today) > strtotime($item->date_start) && strtotime($today) < strtotime($item->date_end))
                                                  Đang diễn ra
                                                @elseif(strtotime($today) < strtotime($item->date_start))
                                                  Sắp diễn ra
                                                @elseif(strtotime($today) > strtotime($item->date_end))
                                                  Kết thúc
                                                @endif
                                            </td>
                                            <td>
                                              <a href="{{ route('admin.sale.edit-sale', $item->id_sale) }}"
                                                  class="badge badge-gradient-info">
                                                  <i class="mdi mdi-table-edit"></i>
                                              </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                              </table>
                          </div>


                          <div class="table-responsive content" id="cancel">
                              <table class="table table-hover" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên khuyến mãi</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($sale as $item)
                                      @if(strtotime($today) > strtotime($item->date_end))
                                        <tr>
                                            <td>{{ $temp++ }}</td>
                                            <td>
                                                {{ $item->name_sale }}
                                            </td>
                                            <td>
                                                {{ $item->date_start }}
                                            </td>
                                            <td>
                                                {{ $item->date_end }}
                                            </td>
                                            <td>
                                                @if(strtotime($today) > strtotime($item->date_start) && strtotime($today) < strtotime($item->date_end))
                                                  Đang diễn ra
                                                @elseif(strtotime($today) < strtotime($item->date_start))
                                                  Sắp diễn ra
                                                @elseif(strtotime($today) > strtotime($item->date_end))
                                                  Kết thúc
                                                @endif
                                            </td>
                                            <td>
                                              <a href="{{ route('admin.sale.edit-sale', $item->id_sale) }}"
                                                  class="badge badge-gradient-info">
                                                  <i class="mdi mdi-table-edit"></i>
                                              </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                              </table>
                          </div>

                    <div class="d-block text-center mt-3">
                        <div class="d-inline-block">
                            {{-- {{ $users->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.change-status-product').on('click', function() {
                var product_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.product.change-status-product') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        // toastr.success(data.status);
                        $('#change-stutus-' + product_id).html(data.icon);
                    }
                });
            });
            $('.change-popular-product').on('click', function() {
                var product_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.product.change-popular-product') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        $('#change-popular-' + product_id).html(data.icon);
                    }
                });
            });
        });

    </script>
@endsection
