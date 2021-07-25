<?php

namespace App\Http\Controllers\Esmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CatProduct;
use App\Models\BrandProduct;
use App\Models\Comment;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function __construct(Product $product, CatProduct $catProduct, BrandProduct $brandProduct, Comment $comment)
    {
        $this->product = $product;
        $this->catProduct = $catProduct;
        $this->brandProduct = $brandProduct;
        $this->comment = $comment;
    }

    public function index(Request $request)
    {
        $sort = '';
        if ($request->sort) {
            $sort = $request->sort;
        }
        $productAll = $this->product->getProductAll($sort);
        $countProduct = $this->product->getCountProduct();
        $sale = $this->product->getSale();
        return view('esmart.product.index', compact('productAll', 'countProduct', 'sort', 'sale'));
    }
    public function cat($slug, $id, Request $request)
    {
        //Thông tin danh mục
        $infoCat = $this->catProduct->getItem($id);
        //Thông tin sản phẩm theo danh mục
        $idChild = data_tree($this->catProduct->all(), $id);
        $listId[] = $id;
        foreach ($idChild as $item) {
            $listId[] = $item->cat_product_id;
        }
        $sort = '';
        if ($request->sort) {
            $sort = $request->sort;
        }
        $productCat = $this->product->getProductCat($listId, $sort);
        $countProduct = $this->product->getCountProduct($listId);
        //Gửi dữ liệu sang view
        return view('esmart.product.cat', compact('productCat', 'infoCat', 'countProduct', 'sort'));
    }
    public function brand($slug, $id, Request $request)
    {
        $infoBrand = $this->brandProduct->getItem($id);
        $sort = '';
        if ($request->sort) {
            $sort = $request->sort;
        }
        $productBrand = $this->product->getProductBrand($id, $sort);
        $countProduct = $this->product->getCountProductByBrand($id);
        return view('esmart.product.brand', compact('infoBrand', 'productBrand', 'countProduct', 'sort'));
    }
    public function detail($slug, $id)
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $infoProduct = $this->product->getItem($id);
        $sameProduct = $this->product->getSameProduct($infoProduct->cat_product_id);
        $listComment = $this->comment->getItems($id);
        $sale        = $this->product->getSaleItem($id);
        return view('esmart.product.detail', compact('infoProduct', 'sameProduct', 'listComment', 'now', 'sale'));
    }

}
