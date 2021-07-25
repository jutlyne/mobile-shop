<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrandProduct;
use App\Models\CatProduct;
use App\Models\ImageGallery;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdminProductController extends Controller
{
    public function __construct(Product $product, ImageGallery $imageGallery, CatProduct $catProduct, BrandProduct $brandProduct)
    {
        $this->product = $product;
        $this->imageGallery = $imageGallery;
        $this->catProduct = $catProduct;
        $this->brandProduct = $brandProduct;
    }
    //Danh sách
    public function list(Request $request)
    {
        $cat_products = data_tree($this->catProduct->getItems());
        $cat_product_id = '';
        if ($request->cat) {
            $cat_product_id = (int)$request->cat;
        }
        $products = $this->product->getItems($cat_product_id);
        return view('admin.product.list-product', compact('cat_products', 'products', 'cat_product_id'));
    }
    //Thêm
    public function add()
    {
        $cat_products = data_tree($this->catProduct->getItems());
        $brand_products = $this->brandProduct->getItems();
        return view('admin.product.add-product', compact('cat_products', 'brand_products'));
    }


    public function postAdd(Request $request)
    {
        #Validation
        $request->validate([
            'product_name' => 'required',
            'cat_product_id' => 'required',
            'brand_id' => 'required',
            'product_price' => 'required|gt:0',
            'product_qty' => 'required|gt:0',
            'product_image' => 'required|image',
            'gallery.*' => 'image',
        ], [
            'product_name.required' => 'Nhập tên sản phẩm',
            'cat_product_id.required' => 'Chọn danh mục sản phẩm',
            'brand_id.required' => 'Chọn thương hiệu sản phẩm',
            'product_price.required' => 'Nhập giá bán',
            'product_price.gt' => 'Giá sản phẩm không hợp lệ',
            'product_qty.required' => 'Nhập số lượng đang có',
            'product_qty.gt' => 'Số lượng sản phẩm không hợp lệ',
            'product_image.required' => 'Chọn ảnh upload',
            'product_image.image' => 'Chọn hình ảnh (jpeg, png, bmp, gif, svg hoặc webp)',
            'gallery.*.image' => 'Chọn hình ảnh (jpeg, png, bmp, gif, svg hoặc webp)'
        ]);
        #Insert DB
        $data = [
            'product_name' => $request->product_name,
            'product_slug' => Str::slug($request->product_name),
            'cat_product_id' => $request->cat_product_id,
            'brand_id' => $request->brand_id,
            'product_price' => $request->product_price,
            'product_sale' => $request->product_sale,
            'product_qty' => $request->product_qty,
            'product_desc' => $request->product_desc,
            'product_spec' => $request->product_spec,
            'product_article' => $request->product_article,
            'product_popular' => $request->product_popular,
        ];
        if ($request->product_sale == null) {
            $data['product_sale'] = 0;
        }
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = "image-product-" . time() . '.' . $image->extension();
            $resizeImage = Image::make($image->getRealPath());
            $resizeImage->resize(525, 630);
            $resizeImage->save(public_path('uploads/product/' . $imageName));
            $data['product_image'] = $imageName;
        }
        $product_id = $this->product->addItem($data);
        #upload thư viện ảnh
        if ($product_id) {
            if ($request->hasfile('gallery')) {
                $i = 0;
                foreach ($request->file('gallery') as $gallery) {
                    $galleryName = "image-gallery-" . time() . $i++ . '.' . $gallery->extension();
                    $resizeGallery = Image::make($gallery->getRealPath());
                    $resizeGallery->resize(525, 630);
                    $resizeGallery->save(public_path('uploads/gallery/' . $galleryName));
                    $dataGallery = [
                        'gallery_path' => $galleryName,
                        'product_id' => $product_id
                    ];
                    $this->imageGallery->addItem($dataGallery);
                }
            }
        }
        if ($product_id) {
            return redirect()->route('admin.product.list-product')->with('msg', 'Thêm sản phẩm thành công!');
        }
    }
    //Sửa
    public function edit($id)
    {
        $infoProduct = $this->product->getItem($id);
        $cat_products = data_tree($this->catProduct->getItems());
        $brand_products = $this->brandProduct->getItems();
        return view('admin.product.edit-product', compact('cat_products', 'brand_products', 'infoProduct'));
    }
    public function postEdit(Request $request, $id)
    {
        #Validation
        $request->validate([
            'product_name' => 'required',
            'cat_product_id' => 'required',
            'brand_id' => 'required',
            'product_price' => 'required|gt:0',
            'product_qty' => 'required',
            'product_image' => 'image',
            'gallery.*' => 'image',
        ], [
            'product_name.required' => 'Nhập tên sản phẩm',
            'cat_product_id.required' => 'Chọn danh mục sản phẩm',
            'brand_id.required' => 'Chọn thương hiệu sản phẩm',
            'product_price.required' => 'Nhập giá bán',
            'product_price.gt' => 'Giá sản phẩm không hợp lệ',
            'product_qty.required' => 'Nhập số lượng đang có',
            'product_image.image' => 'Chọn hình ảnh (jpeg, png, bmp, gif, svg hoặc webp)',
            'gallery.*.image' => 'Chọn hình ảnh (jpeg, png, bmp, gif, svg hoặc webp)'
        ]);
        #Upload thư viện ảnh
        if ($request->hasfile('gallery')) {
            $i = 0;
            foreach ($request->file('gallery') as $gallery) {
                $galleryName = "image-gallery-" . time() . $i++ . '.' . $gallery->extension();
                $resizeGallery = Image::make($gallery->getRealPath());
                $resizeGallery->resize(525, 630);
                $resizeGallery->save(public_path('uploads/gallery/' . $galleryName));
                $dataGallery = [
                    'gallery_path' => $galleryName,
                    'product_id' => $id
                ];
                $this->imageGallery->addItem($dataGallery);
            }
        }
        #Insert DB
        $data = [
            'product_name' => $request->product_name,
            'product_slug' => Str::slug($request->product_name),
            'cat_product_id' => $request->cat_product_id,
            'brand_id' => $request->brand_id,
            'product_price' => $request->product_price,
            'product_sale' => $request->product_sale,
            'product_qty' => $request->product_qty,
            'product_desc' => $request->product_desc,
            'product_spec' => $request->product_spec,
            'product_article' => $request->product_article,
            'product_popular' => $request->product_popular,
        ];
        if ($request->product_sale == null) {
            $data['product_sale'] = 0;
        }
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = "image-product-" . time() . '.' . $image->extension();
            $resizeImage = Image::make($image->getRealPath());
            $resizeImage->resize(525, 630);
            $resizeImage->save(public_path('uploads/product/' . $imageName));
            unlink('uploads/product/' . $request->product_image_old);
            $data['product_image'] = $imageName;
        }
        $this->product->editItem($data, $id);
        return redirect()->route('admin.product.list-product')->with('msg', 'Cập nhật sản phẩm thành công!');
    }
    //Xóa
    public function del($id)
    {
        #Xóa thư viện ảnh
        $this->imageGallery->delItems($id);
        #Xóa sản phẩm
        $this->product->delItem($id);
        return redirect()->back()->with('msg', 'Xóa sản phẩm thành công!');
    }
    //Xóa ảnh thư viện
    public function delGallery(Request $request)
    {
        $id = $request->gallery_id;
        $result = $this->imageGallery->delItem($id);
        if ($result == true) {
            return response()->json([
                'success' => 'Xóa ảnh thành công!'
            ]);
        }
    }
    //Thay đổi trạng thái
    public function changeStatusProduct(Request $request)
    {
        $product_status = $this->product->getItem($request->product_id)->product_status;
        if ($product_status == 1) {
            $this->product->editItem(['product_status' => 2], $request->product_id);
            return response()->json([
                'status' => 'Sản phẩm không được hiển thị',
                'icon' =>   '<small class="badge badge-gradient-danger">
                                <i class="mdi mdi-window-close"></i>
                            </small>'
            ]);
        } else {
            $this->product->editItem(['product_status' => 1], $request->product_id);
            return response()->json([
                'status' => 'Sản phẩm đã được hiển thị',
                'icon' =>   '<small class="badge badge-gradient-success">
                                <i class="mdi mdi-check"></i>
                            </small>'
            ]);
        }
    }
    //Thay đổi trạng thái phổ biến sản phẩm
    public function changePopularProduct(Request $request)
    {
        $product_popular = $this->product->getItem($request->product_id)->product_popular;
        if ($product_popular == 1) {
            $this->product->editItem(['product_popular' => 2], $request->product_id);
            return response()->json([
                'icon' =>   '<a href="javascript:void(0)" class="badge badge-gradient-danger">
                                 Phổ biến
                            </a>'
            ]);
        } else {
            $this->product->editItem(['product_popular' => 1], $request->product_id);
            return response()->json([
                'icon' =>   '<a href="javascript:void(0)" class="badge badge-gradient-success">
                                 Sản phẩm thường
                            </a>'
            ]);
        }
    }
}
