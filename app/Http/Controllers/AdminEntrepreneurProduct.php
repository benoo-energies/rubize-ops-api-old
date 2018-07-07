<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\EntrepreneurOrder;
use App\EntrepreneurProduct;
use App\EntrepreneurOrderDetail;
use Illuminate\Support\Facades\Redirect;
use App\ServiceType;

class AdminEntrepreneurProduct extends Controller
{

    public function getEntrepreneurProducts() {
        $products = EntrepreneurProduct::where('status', 1)->orderBy('title')->get();
        $serviceType = ServiceType::where('status', 1)->get();

        return view('entrepreneur-products', ['products' => $products, 'serviceType' => $serviceType]);
    }    

    public function createEntrepreneurProduct(Request $request) {
        $product = new EntrepreneurProduct;
        $product->title = $request->title;
        $product->service_type_id = $request->service_type_id;
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
            $product->service_type_id = $request->service_type_id;
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