@extends('templates.admin.master')

@section('main-content')
    <div class="page-header">
        <h3 class="page-title"> QUẢN LÝ ĐƠN HÀNG </h3>
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

                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-inline" method="GET">
                                <input type="date" class="form-control form-control-sm mb-2 mr-sm-2"
                                    value="{{ isset($date_from) ? $date_from : '' }}" name="date_from">
                                <div class="input-group mb-2 mr-sm-2">
                                    <input type="date" class="form-control form-control-sm"
                                        value="{{ isset($date_to) ? $date_to : '' }}" name="date_to">
                                </div>
                                <button type="submit" class="btn btn-gradient-primary btn-sm mb-2"
                                    style="font-family: roboto">Lọc</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form class="form-inline" method="GET">
                                <input type="text" class="form-control form-control-sm mb-2 mr-sm-2"
                                    value="{{ isset($search) ? $search : '' }}" name="search"
                                    placeholder="Email/ Mã đơn hàng">
                                <button type="submit" class="btn btn-sm btn-gradient-info mb-2"
                                    style="font-family: roboto">Tìm
                                    kiếm</button>
                            </form>
                        </div>
                    </div>


                    <div class="tabs">
                      <div class="wrapper">
                        <div class="buttonWrapper">
                          <button class="tab-button active" style="border-top-left-radius: 10px;" data-id="new">Đơn hàng mới</button>
                          <button class="tab-button" data-id="shipping">Đang giao</button>
                          <button class="tab-button" data-id="success">Đã hoàn thành</button>
                          <button class="tab-button" style="border-top-right-radius: 10px;" data-id="cancel">Đã huỷ</button>
                        </div>
                        <div class="contentWrapper">
                          <!-- start tab Home -->
                          <div class="table-responsive content active" id="new">
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Đơn hàng</th>
                                          <th>Thông tin khách hàng</th>
                                          <th>Tổng quan đơn hàng</th>
                                          <th>Trang thái</th>
                                          <th>Hình thức thanh toán</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($listOrder as $item)
                                        @if($item->order_status == 1)
                                          <tr>
                                              <td>#{{ $item->order_code }}</td>
                                              <td>
                                                  <div class="mb-1">
                                                      {{ $item->order_email }}
                                                  </div>
                                                  <small style="font-family: roboto">
                                                      Người nhận: <span class="text-muted">{{ $item->order_name }}</span>
                                                  </small>
                                                  <br>
                                                  <small style="font-family: roboto">
                                                      Thời gian: <span class="text-muted">
                                                          @php
                                                          $time = $item->created_at;
                                                          @endphp
                                                          {{ $time->diffForHumans($now) }}
                                                      </span>
                                                  </small>
                                              </td>
                                              <td>
                                                  <div class="mb-1">
                                                      Tổng tiền: <span
                                                          class="text-danger">{{ number_format($item->order_total, '0', ',', '.') }}đ</span>
                                                  </div>
                                                  <small style="font-family: roboto">
                                                      Số lượng: <span class="text-muted">{{ $item->order_qty }}</span>
                                                  </small>

                                              </td>
                                              <td>
                                                  <span class="text-light">
                                                      @if ($item->order_status == 1)
                                                          <span class="bg-info p-1 rounded">
                                                              Đơn hàng mới
                                                          </span>
                                                      @elseif($item->order_status == 2)
                                                          <span class="bg-warning p-1 rounded">
                                                              Đang giao
                                                          </span>
                                                      @elseif($item->order_status == 3)
                                                          <span class="bg-success p-1 rounded">
                                                              Đã hoàn thành
                                                          </span>
                                                      @else
                                                          <span class="bg-danger p-1 rounded">
                                                              Đã hủy
                                                          </span>
                                                      @endif
                                                  </span>
                                              </td>
                                              <td>
                                                  @if ($item->order_payment == 1)
                                                      <span class="text-success">Thanh toán online</span>
                                                  @else
                                                      <span class="text-secondary">Khi nhận hàng</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  <a href="{{ route('admin.order.detail-order', $item->order_id) }}"
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
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Đơn hàng</th>
                                          <th>Thông tin khách hàng</th>
                                          <th>Tổng quan đơn hàng</th>
                                          <th>Trang thái</th>
                                          <th>Hình thức thanh toán</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($listOrder as $item)
                                        @if($item->order_status == 2)
                                          <tr>
                                              <td>#{{ $item->order_code }}</td>
                                              <td>
                                                  <div class="mb-1">
                                                      {{ $item->order_email }}
                                                  </div>
                                                  <small style="font-family: roboto">
                                                      Người nhận: <span class="text-muted">{{ $item->order_name }}</span>
                                                  </small>
                                                  <br>
                                                  <small style="font-family: roboto">
                                                      Thời gian: <span class="text-muted">
                                                          @php
                                                          $time = $item->created_at;
                                                          @endphp
                                                          {{ $time->diffForHumans($now) }}
                                                      </span>
                                                  </small>
                                              </td>
                                              <td>
                                                  <div class="mb-1">
                                                      Tổng tiền: <span
                                                          class="text-danger">{{ number_format($item->order_total, '0', ',', '.') }}đ</span>
                                                  </div>
                                                  <small style="font-family: roboto">
                                                      Số lượng: <span class="text-muted">{{ $item->order_qty }}</span>
                                                  </small>

                                              </td>
                                              <td>
                                                  <span class="text-light">
                                                      @if ($item->order_status == 1)
                                                          <span class="bg-info p-1 rounded">
                                                              Đơn hàng mới
                                                          </span>
                                                      @elseif($item->order_status == 2)
                                                          <span class="bg-warning p-1 rounded">
                                                              Đang giao
                                                          </span>
                                                      @elseif($item->order_status == 3)
                                                          <span class="bg-success p-1 rounded">
                                                              Đã hoàn thành
                                                          </span>
                                                      @else
                                                          <span class="bg-danger p-1 rounded">
                                                              Đã hủy
                                                          </span>
                                                      @endif
                                                  </span>
                                              </td>
                                              <td>
                                                  @if ($item->order_payment == 1)
                                                      <span class="text-success">Thanh toán online</span>
                                                  @else
                                                      <span class="text-secondary">Khi nhận hàng</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  <a href="{{ route('admin.order.detail-order', $item->order_id) }}"
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
                          <!-- end tab about
                          start tab contact -->
                          <div class="table-responsive content" id="success">
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Đơn hàng</th>
                                          <th>Thông tin khách hàng</th>
                                          <th>Tổng quan đơn hàng</th>
                                          <th>Trang thái</th>
                                          <th>Hình thức thanh toán</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($listOrder as $item)
                                        @if($item->order_status == 3)
                                          <tr>
                                              <td>#{{ $item->order_code }}</td>
                                              <td>
                                                  <div class="mb-1">
                                                      {{ $item->order_email }}
                                                  </div>
                                                  <small style="font-family: roboto">
                                                      Người nhận: <span class="text-muted">{{ $item->order_name }}</span>
                                                  </small>
                                                  <br>
                                                  <small style="font-family: roboto">
                                                      Thời gian: <span class="text-muted">
                                                          @php
                                                          $time = $item->created_at;
                                                          @endphp
                                                          {{ $time->diffForHumans($now) }}
                                                      </span>
                                                  </small>
                                              </td>
                                              <td>
                                                  <div class="mb-1">
                                                      Tổng tiền: <span
                                                          class="text-danger">{{ number_format($item->order_total, '0', ',', '.') }}đ</span>
                                                  </div>
                                                  <small style="font-family: roboto">
                                                      Số lượng: <span class="text-muted">{{ $item->order_qty }}</span>
                                                  </small>

                                              </td>
                                              <td>
                                                  <span class="text-light">
                                                      @if ($item->order_status == 1)
                                                          <span class="bg-info p-1 rounded">
                                                              Đơn hàng mới
                                                          </span>
                                                      @elseif($item->order_status == 2)
                                                          <span class="bg-warning p-1 rounded">
                                                              Đang giao
                                                          </span>
                                                      @elseif($item->order_status == 3)
                                                          <span class="bg-success p-1 rounded">
                                                              Đã hoàn thành
                                                          </span>
                                                      @else
                                                          <span class="bg-danger p-1 rounded">
                                                              Đã hủy
                                                          </span>
                                                      @endif
                                                  </span>
                                              </td>
                                              <td>
                                                  @if ($item->order_payment == 1)
                                                      <span class="text-success">Thanh toán online</span>
                                                  @else
                                                      <span class="text-secondary">Khi nhận hàng</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  <a href="{{ route('admin.order.detail-order', $item->order_id) }}"
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
                          <!-- end tab success
                          start tab cancel -->
                          <div class="table-responsive content" id="cancel">
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Đơn hàng</th>
                                          <th>Thông tin khách hàng</th>
                                          <th>Tổng quan đơn hàng</th>
                                          <th>Trang thái</th>
                                          <th>Hình thức thanh toán</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($listOrder as $item)
                                        @if($item->order_status == 4)
                                          <tr>
                                              <td>#{{ $item->order_code }}</td>
                                              <td>
                                                  <div class="mb-1">
                                                      {{ $item->order_email }}
                                                  </div>
                                                  <small style="font-family: roboto">
                                                      Người nhận: <span class="text-muted">{{ $item->order_name }}</span>
                                                  </small>
                                                  <br>
                                                  <small style="font-family: roboto">
                                                      Thời gian: <span class="text-muted">
                                                          @php
                                                          $time = $item->created_at;
                                                          @endphp
                                                          {{ $time->diffForHumans($now) }}
                                                      </span>
                                                  </small>
                                              </td>
                                              <td>
                                                  <div class="mb-1">
                                                      Tổng tiền: <span
                                                          class="text-danger">{{ number_format($item->order_total, '0', ',', '.') }}đ</span>
                                                  </div>
                                                  <small style="font-family: roboto">
                                                      Số lượng: <span class="text-muted">{{ $item->order_qty }}</span>
                                                  </small>

                                              </td>
                                              <td>
                                                  <span class="text-light">
                                                      @if ($item->order_status == 1)
                                                          <span class="bg-info p-1 rounded">
                                                              Đơn hàng mới
                                                          </span>
                                                      @elseif($item->order_status == 2)
                                                          <span class="bg-warning p-1 rounded">
                                                              Đang giao
                                                          </span>
                                                      @elseif($item->order_status == 3)
                                                          <span class="bg-success p-1 rounded">
                                                              Đã hoàn thành
                                                          </span>
                                                      @else
                                                          <span class="bg-danger p-1 rounded">
                                                              Đã hủy
                                                          </span>
                                                      @endif
                                                  </span>
                                              </td>
                                              <td>
                                                  @if ($item->order_payment == 1)
                                                      <span class="text-success">Thanh toán online</span>
                                                  @else
                                                      <span class="text-secondary">Khi nhận hàng</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  <a href="{{ route('admin.order.detail-order', $item->order_id) }}"
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
                        </div>
                      </div>
                    </div>
                    <!-- end tab contact -->
                    <div class="d-block text-center mt-3">
                        <div class="d-inline-block">
                            @if (isset($_GET['date_from']) && isset($_GET['date_to']))
                                {{ $listOrder->appends(['date_from' => $_GET['date_from'], 'date_to' => $_GET['date_to']])->links() }}
                            @elseif(isset($_GET['search']) )
                                {{ $listOrder->appends(['search' => $_GET['search']])->links() }}
                            @else
                                {{ $listOrder->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
