<?php

namespace App\Http\Controllers\Esmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $sort = '';
        if ($request->sort) {
            $sort = $request->sort;
        }
        $productAll = $this->product->getProductSearch($keyword, $sort);
        $countProduct = $this->product->getCountProductSearch($keyword);
        return view('esmart.search.search', compact('productAll', 'countProduct', 'sort', 'keyword'));
    }
    public function autocomplete(Request $request)
    {
        $data = $request->all();
        $keyword = $data['keyword'];
        if ($keyword) {
            $productSearch = Product::where('product_status', 1)->where('product_name', 'like', '%' . $keyword . '%')->limit(10)->get();
            return view('esmart.search.autocomplete', compact('productSearch'));
        }
    }
}
