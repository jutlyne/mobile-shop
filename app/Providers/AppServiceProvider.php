<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\CatProduct;
use App\Models\BrandProduct;
use App\Models\CatPost;
use App\Models\Product;
use App\Models\Post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        //Share dữ liệu menu danh mục sản phẩm
        $menuCatProduct = CatProduct::all();
        View::share('menuCatProduct', $menuCatProduct);
        //Share dữ liệu menu thương hiệu sản phẩm
        $menuBrandProduct = BrandProduct::all();
        View::share('menuBrandProduct', $menuBrandProduct);
        //Share dữ liệu menu danh mục tin tức
        $menuCatPost = CatPost::all();
        View::share('menuCatPost', $menuCatPost);
        //Share dữ liệu sản phẩm bán chạy
        $productSelling = Product::where('product_status', 1)->orderBy('product_sold', 'DESC')->limit(10)->get();
        View::share('productSelling', $productSelling);
        //Share dữ liệu tin xem nhiều
        $postTopViews = Post::where('post_status', 1)->orderBy('post_views', 'DESC')->limit(10)->get();
        View::share('postTopViews', $postTopViews);
    }
}
