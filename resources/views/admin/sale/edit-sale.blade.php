@extends('templates.admin.master')

@section('main-content')
<style media="screen">
  .input-sale{
    height: 20px;
  }
  td{
    overflow: hidden;
  }
</style>
    <div class="page-header">
        <h3 class="page-title"> SỬA KHUYẾN MÃI </h3>
    </div>
    <form action="{{ route('admin.sale.edit-sale', $infoSale->id_sale) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="post-name">Tên khuyến mãi</label>
                            <input type="hidden" name="" id="aid_sale" value="{{ $infoSale->id_sale }}">
                            <input type="text" name="sale_name" value="{{ $infoSale->name_sale }}" required class="form-control"
                                id="post-name" placeholder="Nhập tên tin tức (*)">
                        </div>

                        <div class="form-group">
                            <label for="post-name">Discount %</label>
                            <input type="number" name="sale_discount" value="{{ $infoSale->discount }}" required class="form-control"
                                id="post-name" placeholder="Nhập tên tin tức (*)">
                        </div>

                        @error('post_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="post-cat">Ngày bắt đầu</label>
                            <input type="date" class="form-control" value="{{ $infoSale->date_start }}" required name="sale_start">
                        </div>
                        <div class="form-group">
                            <label for="post-cat">Ngày kết thúc</label>
                            <input type="date" class="form-control" value="{{ $infoSale->date_end }}" required name="sale_end">
                        </div>

                        @error('cat_post_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="product-popular">Trạng thái</label>
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="post_status" id="radio1"
                                                value="1" checked>
                                            Hiển thị
                                        </label>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="post_status" id="radios2"
                                                value="2">
                                            Ẩn
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="form-group">
                            <label for="post-image">Ảnh đại diện (*)</label>
                            <input type="file" name="post_image"
                                class="border border-secondary rounded p-2 form-control-file" id="post-image">
                        </div> -->

                        @error('post_image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="post-desc">Danh sách đã chọn</label>
                            <div style="border : 1px solid #ebedf2; border-radius: 2%; width : 100%; height : 350px; overflow-x : hidden;">
                              <table class="table table-hover" id="list-sale"  style="text-align : center">
                                  <thead>
                                      <tr>
                                          <th style="width: 70%">Tên sản phẩm</th>
                                          <th style="width: 20%">Số lượng</th>
                                          <th style="width: 10%"></th>
                                      </tr>
                                  </thead>
                                  @foreach($detail as $d)
                                  <tbody>
                                      <td>{{ $d->name_product }}</td>
                                      <td><input type="number" disabled class="number-sale" data-token="{{ csrf_token() }}" data-id="2" value="{{ $d->soluong_sale - $d->soluong_sale_thuc }}" style="border : 1px solid #ebedf2;  width: 50%; text-align: center"></input></td>
                                      <td><a href="javascript:void(0)" class="btn-remove-product-js" data-id="{{$d->id_sale_detail}}" data-token="{{ csrf_token() }}" style="color : red">X</a></td>
                                  </tbody>
                                  @endforeach
                              </table>
                          </div>
                        </div>

                        @error('post_desc')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="post-content">Danh sách sản phẩm</label>
                            <div class="product-sale row" style="height: 250px; overflow-x : hidden">

                              @foreach($product as $p)
                                <div class="col-md-6 row old-parents" style="margin: 5px 0 10px 0">
                                  <a class="col-9" style="overflow : hidden;text-decoration: none; color:black">{{$p->product_name}}</a>
                                  <input class="col-2" type="number" style="border: none" width="20px" class="old_soluong" name="" value="1" max="$p->product_qty">
                                  <a href="javascript:void(0)" class="btn-add-product-js col-1" data-token="{{ csrf_token() }}" data-id="{{$p->product_id}}" >+</a>
                                </div>
                              @endforeach

                            </div>
                        </div>

                        @error('post_content')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-gradient-primary">Cập nhật</button>
                        <button type="reset" class="btn btn-gradient-danger">Nhập lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $(".btn-add-product-js").click(function() {
        self = $(this);
        id = self.data('id');
        sid = $('#aid_sale').val();
        soluong = self.prev();
        num = self.prev().val();
        tr = self.parents('.old-parents');
        name = soluong.prev().text();
        tr.remove();
        $.ajax({
            url: "admin/sale/add-item/"+id,
            type: 'get',
            cache: false,
            data: {id:id, sid:sid, soluong:num, ten:name},
            success: function(data){
              document.getElementById('list-sale').innerHTML += `<tbody>
                  <td>`+name+`</td>
                  <td><input type='number' class='number-sale' style='border : 1px solid #ebedf2; width: 50%' value='`+num+`' disabled></input></td>
                  <td><a href='javascript:void(0)' class='btn-remove-product-js' data-token='{{ csrf_token() }}' data-id='`+data.sucid+`' style='color : red'>X</a></td>
              </tbody>`;
            }
          });
      });
    })
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '.btn-remove-product-js', function() {
          self = $(this);
          id = self.data('id');
          tr = self.parents('tbody');
          tr.remove();
          $.ajax({
              url: "admin/sale/remove-item/"+id,
              type: 'get',
              cache: false,
              data: {id:id},
              success: function(data){
                console.log('ok');
              }
            });
      });
    })
    </script>
@endsection
