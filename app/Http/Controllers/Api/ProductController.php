<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProduct(){
        $products = Products::get()->all();
        return $products;
    }

    public function showProduct($id){
        $product = Products::find($id);
        return $product;    
    }

    public function updateProduct(Request $request, $id){
        $product = Products::find($id);

        if($product){
         
            $product = Products::where('id', $id)->first();
            $product->status_id = 5;
            $product->save();
    
        }else{
            $response = [
                "message" => "product not found!"
            ];
        }
        return $response;
    }

    public function deleteProduct($id) {
        $product = Products::find($id);
        if($product){
          $product->delete();
        }else{
            $response = [
                "message" => "Product not found !"
            ];
        }
        return $response;
    }
}
