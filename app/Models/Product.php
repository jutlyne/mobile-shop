<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CatProduct;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $primaryKey = "product_id";
    public $timestamps = false;

    //Relationships
    public function catProduct()
    {
        return $this->belongsTo('App\Models\CatProduct', 'cat_product_id');
    }
    public function brandProduct()
    {
        return $this->belongsTo('App\Models\BrandProduct', 'brand_id');
    }
    public function imageGallery()
    {
        return $this->hasMany('App\Models\ImageGallery', 'product_id');
    }
    //Xử lý admin
    public function getItems($cat = '')
    {
        if ($cat != '') {
            $idChild = data_tree(CatProduct::all(), $cat);
            $listId[] = $cat;
            foreach ($idChild as $item) {
                $listId[] = $item->cat_product_id;
            }
            return $this->whereIn('cat_product_id', $listId)->orderBy('product_id', 'DESC')->paginate(10);
        }
        return $this->orderBy('product_id', 'DESC')->paginate(10);
    }
    public function getAll()
    {
        return $this->all();
    }
    public function addItem($data)
    {
        return $this->insertGetId($data);
    }
    public function getItem($id)
    {
        return $this->find($id);
    }
    public function editItem($data, $id)
    {
        return $this->where('product_id', $id)->update($data);
    }
    public function delItem($id)
    {
        $product_image = $this->getItem($id)->product_image;
        unlink('uploads/product/' . $product_image);
        return $this->destroy($id);
    }
    //Xử lý public
    public function getProductSale()
    {
        return $this->where('product_status', 1)->orderBy('product_sale', 'DESC')->get();
    }

    public function getSale()
    {
      return $this
      ->join('sale_detail','sale_detail.id_product_sale','=', 'products.product_id')
      ->join('sale', 'sale.id_sale','=','sale_detail.id_sale')
      ->select('products.product_price', 'sale.discount', 'sale_detail.soluong_sale', 'products.product_id')
      ->get();
    }
    public function getProductPolular()
    {
        return $this->where('product_popular', 2)->where('product_status', 1)->orderBy('product_qty', 'DESC')->paginate(12);
    }
    public function getProductAll($sort)
    {
        if ($sort == 'giam-dan') {
            return $this->where('product_status', 1)->orderBy('product_price', 'DESC')->paginate(16);
        } elseif ($sort == 'tang-dan') {
            return $this->where('product_status', 1)->orderBy('product_price', 'ASC')->paginate(16);
        } elseif ($sort == 'giam-nhieu') {
            return $this->where('product_status', 1)->orderBy('product_sale', 'DESC')->paginate(16);
        } else {
            return $this->where('product_status', 1)->orderBy('product_id', 'DESC')->paginate(16);
        }
    }

    public function getProductCat($listId, $sort)
    {
        if ($sort == 'giam-dan') {
            return $this->whereIn('cat_product_id', $listId)->where('product_status', 1)->orderBy('product_price', 'DESC')->paginate(16);
        } elseif ($sort == 'tang-dan') {
            return $this->whereIn('cat_product_id', $listId)->where('product_status', 1)->orderBy('product_price', 'ASC')->paginate(16);
        } elseif ($sort == 'giam-nhieu') {
            return $this->whereIn('cat_product_id', $listId)->where('product_status', 1)->orderBy('product_sale', 'DESC')->paginate(16);
        } else {
            return $this->whereIn('cat_product_id', $listId)->where('product_status', 1)->orderBy('product_id', 'DESC')->paginate(16);
        }
    }
    public function getCountProduct($listId = '')
    {
        if ($listId) {
            return $this->whereIn('cat_product_id', $listId)->where('product_status', 1)->count();
        } else {
            return $this->where('product_status', 1)->count();
        }
    }
    public function getSameProduct($id)
    {
        return $this->where('cat_product_id', $id)->where('product_status', 1)->orderBy('product_id', 'DESC')->limit(8)->get();
    }
    public function getProductBrand($id, $sort)
    {
        if ($sort == 'giam-dan') {
            return $this->where('brand_id', $id)->where('product_status', 1)->orderBy('product_price', 'DESC')->paginate(16);
        } elseif ($sort == 'tang-dan') {
            return $this->where('brand_id', $id)->where('product_status', 1)->orderBy('product_price', 'ASC')->paginate(16);
        } elseif ($sort == 'giam-nhieu') {
            return $this->where('brand_id', $id)->where('product_status', 1)->orderBy('product_sale', 'DESC')->paginate(16);
        } else {
            return $this->where('brand_id', $id)->where('product_status', 1)->orderBy('product_id', 'DESC')->paginate(16);
        }
    }
    public function getCountProductByBrand($id)
    {
        return $this->where('brand_id', $id)->where('product_status', 1)->count();
    }

    public function getProductSearch($keyword, $sort)
    {
        if ($sort == 'giam-dan') {
            return $this->where('product_name', 'like', '%' . $keyword . '%')->where('product_status', 1)->orderBy('product_price', 'DESC')->paginate(16);
        } elseif ($sort == 'tang-dan') {
            return $this->where('product_name', 'like', '%' . $keyword . '%')->where('product_status', 1)->orderBy('product_price', 'ASC')->paginate(16);
        } elseif ($sort == 'giam-nhieu') {
            return $this->where('product_name', 'like', '%' . $keyword . '%')->where('product_status', 1)->orderBy('product_sale', 'DESC')->paginate(16);
        } else {
            return $this->where('product_name', 'like', '%' . $keyword . '%')->where('product_status', 1)->orderBy('product_id', 'DESC')->paginate(16);
        }
    }
    public function getCountProductSearch($keyword)
    {
        return $this->where('product_name', 'like', '%' . $keyword . '%')->where('product_status', 1)->count();
    }

    public function getSaleItem($id)
    {
      return $this
      ->join('sale_detail','sale_detail.id_product_sale','=', 'products.product_id')
      ->join('sale', 'sale.id_sale','=','sale_detail.id_sale')
      ->select('products.product_price', 'sale.discount', 'sale_detail.soluong_sale', 'products.product_id')
      ->where('sale_detail.id_product_sale',$id)
      ->get();
    }
}
