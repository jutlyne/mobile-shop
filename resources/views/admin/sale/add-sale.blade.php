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
        <h3 class="page-title"> TẠO KHUYẾN MÃI </h3>
    </div>
    <form action="{{ route('admin.sale.add-sale') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="post-name">Tên khuyến mãi</label>
                            <input type="hidden" name="" id="aid_sale" value="">
                            <input type="text" name="sale_name" value="" required class="form-control"
                                id="post-name" placeholder="Nhập tên tin tức (*)">
                        </div>

                        <div class="form-group">
                            <label for="post-name">Discont %</label>
                            <input type="number" name="sale_discount" value="" required class="form-control"
                                id="post-name" placeholder="Nhập tên tin tức (*)">
                        </div>

                        @error('post_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="post-cat">Ngày bắt đầu</label>
                            <input type="date" class="form-control" value="" required name="sale_start">
                        </div>
                        <div class="form-group">
                            <label for="post-cat">Ngày kết thúc</label>
                            <input type="date" class="form-control" value="" required name="sale_end">
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
                        <button type="submit" class="btn btn-gradient-primary">Thêm</button>
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
                  <td><input type='number' class='number-sale' style='border : 1px solid #ebedf2' value='`+num+`' disabled></input></td>
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
