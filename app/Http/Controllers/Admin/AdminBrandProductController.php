<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BrandProduct;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class AdminBrandProductController extends Controller
{
    public function __construct(BrandProduct $brandProduct, Product $product)
    {
        $this->brandProduct = $brandProduct;
        $this->product = $product;
    }
    public function index()
    {
        $brands = $this->brandProduct->getItems();
        return view('admin.brand-product.index', compact('brands'));
    }

    public function postAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required',
            'brand_desc' => 'required|min:10',
        ], [
            'brand_name.required' => 'Nhập tên thương hiệu',
            'brand_desc.required' => 'Nhập mô tả thương hiệu',
            'brand_desc.min' => 'Mô tả tối thiểu 10 ký tự',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $data = [
            'brand_name' => $request->brand_name,
            'brand_slug' => Str::slug($request->brand_name),
            'brand_desc' => $request->brand_desc,
        ];
        $result = $this->brandProduct->addItem($data);
        if ($result == true) {
            return response()->json([
                'success' => 'Thêm thương hiệu thành công!',
            ]);
        }
    }
    public function edit(Request $request)
    {
        $brand_id = $request->brand_id;
        $brand = $this->brandProduct->getItem($brand_id);
        return response()->json([
            'brand_id' => $brand->brand_id,
            'brand_name' => $brand->brand_name,
            'brand_desc' => $brand->brand_desc
        ]);
    }
    public function postEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required',
            'brand_desc' => 'required|min:10',
        ], [
            'brand_name.required' => 'Nhập tên thương hiệu',
            'brand_desc.required' => 'Nhập mô tả thương hiệu',
            'brand_desc.min' => 'Mô tả tối thiểu 10 ký tự',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $data = [
            'brand_name' => $request->brand_name,
            'brand_slug' => Str::slug($request->brand_name),
            'brand_desc' => $request->brand_desc,
        ];
        $result = $this->brandProduct->editItem($data, $request->brand_id);
        if ($result == true) {
            return response()->json([
                'success' => 'Cập nhật thương hiệu thành công!',
            ]);
        } else {
            return response()->json([
                'success' => 'Không sửa gì hết mà cũng cập nhật hehe!',
            ]);
        }
    }
    public function del(Request $request)
    {
        $brand_id = $request->brand_id;

        $checkProduct = Product::where('brand_id', $brand_id)->count();
        if ($checkProduct > 0) {
            return response()->json([
                'error' => 'Vui lòng xóa sản phẩm thuộc thương hiệu trước'
            ]);
        }
        $result = $this->brandProduct->delItem($brand_id);
        if ($result == true) {
            return response()->json([
                'success' => 'Xóa thương hiệu thành công'
            ]);
        }
    }
}
