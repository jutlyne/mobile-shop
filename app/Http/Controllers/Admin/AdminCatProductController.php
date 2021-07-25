<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\CatProduct;
use App\Models\Product;

class AdminCatProductController extends Controller
{
    public function __construct(CatProduct $catProduct, Product $product)
    {
        $this->catProduct = $catProduct;
        $this->product = $product;
    }
    public function index()
    {
        $categories = data_tree($this->catProduct->getItems());
        return view('admin.cat-product.index', compact('categories'));
    }
    public function postAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_product_name' => 'required',
            'cat_product_desc' => 'required|min:10',
        ], [
            'cat_product_name.required' => 'Nhập tên danh mục',
            'cat_product_desc.required' => 'Nhập mô tả danh mục',
            'cat_product_desc.min' => 'Mô tả danh mục tối thiểu 10 ký tự',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }
        $data = [
            'cat_product_name' => $request->cat_product_name,
            'cat_product_slug' => Str::slug($request->cat_product_name),
            'cat_product_desc' => $request->cat_product_desc,
            'cat_product_parent' => $request->cat_product_parent,
        ];
        $result = $this->catProduct->addItem($data);
        if ($result == true) {
            return response()->json([
                'success' => 'Thêm danh mục thành công'
            ]);
        }
    }
    public function edit(Request $request)
    {
        $cat_product_id = $request->cat_product_id;
        $catProduct = $this->catProduct->getItem($cat_product_id);
        return response()->json([
            'cat_product_id' => $catProduct->cat_product_id,
            'cat_product_name' => $catProduct->cat_product_name,
            'cat_product_desc' => $catProduct->cat_product_desc
        ]);
    }
    public function postEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_product_name' => 'required',
            'cat_product_desc' => 'required|min:10',
        ], [
            'cat_product_name.required' => 'Nhập tên danh mục',
            'cat_product_desc.required' => 'Nhập mô tả danh mục',
            'cat_product_desc.min' => 'Mô tả danh mục tối thiểu 10 ký tự',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }
        $data = [
            'cat_product_name' => $request->cat_product_name,
            'cat_product_slug' => Str::slug($request->cat_product_name),
            'cat_product_desc' => $request->cat_product_desc,
        ];
        $result = $this->catProduct->editItem($data, $request->cat_product_id);
        if ($result == true) {
            return response()->json([
                'success' => 'Cập nhật danh mục thành công!',
            ]);
        } else {
            return response()->json([
                'success' => 'Không sửa gì hết mà cũng cập nhật hehe!',
            ]);
        }
    }
    public function del(Request $request)
    {
        $cat_product_id = $request->cat_product_id;
        $cateChild = data_tree($this->catProduct->getItems(), $cat_product_id);
        if ($cateChild) {
            return response()->json([
                'error' => 'Vui lòng xóa danh mục con trước!'
            ]);
        }
        $checkProduct = $this->product->getItems($cat_product_id);
        if ($checkProduct->count() > 0) {
            return response()->json([
                'error' => 'Vui lòng xóa sản phẩm thuộc danh mục trước!'
            ]);
        }
        $result = $this->catProduct->delItem($cat_product_id);
        if ($result == true) {
            return response()->json([
                'success' => 'Xóa danh mục sản phẩm thành công!'
            ]);
        }
    }
}
