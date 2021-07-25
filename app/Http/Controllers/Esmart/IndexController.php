<?php

namespace App\Http\Controllers\Esmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class IndexController extends Controller
{
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function index()
    {
        $sale = $this->product->getSale();
        $productSale = $this->product->getProductSale();
        $productPopular = $this->product->getProductPolular();
        return view('esmart.index.index', compact('productSale', 'productPopular', 'sale'));
    }
}
