<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\EntrepreneurOrder;
use App\EntrepreneurProduct;
use App\EntrepreneurOrderDetail;
use Illuminate\Support\Facades\Redirect;

class AdminEntrepreneurProduct extends Controller
{

    public function getEntrepreneurProducts() {
        $products = EntrepreneurProduct::where('status', 1)->orderBy('title')->get();

        return view('entrepreneur-products', ['products' => $products]);
    }    

    public function createEntrepreneurProduct(Request $request) {
        $product = new EntrepreneurProduct;
        $product->title = $request->title;
        $product->unity = $request->unity;
        $product->picture = $request->picture;
        $product->price_fcfa = str_replace(",", ".", $request->price_fcfa);
        $product->status = 1;
        $product->save();

        return redirect('/entrepreneurs/products');        
    }
    
    public function updateEntrepreneurProduct(Request $request, $id) {
        $product = EntrepreneurProduct::where('status', 1)->where('id', $id)->first();
        if($product) {
            $product->title = $request->title;
            $product->unity = $request->unity;
            $product->picture = $request->picture;
            $product->price_fcfa = str_replace(",", ".", $request->price_fcfa);
            $product->save();        
        }

        return redirect('/entrepreneurs/products');        
    }

    public function deleteEntrepreneurProduct(Request $request, $id) {
        $product = EntrepreneurProduct::where('status', 1)->where('id', $id)->first();

        if($product) {
            $product->status = 2;
            $product->save();        
        }

        return redirect('/entrepreneurs/products');         
    }


}