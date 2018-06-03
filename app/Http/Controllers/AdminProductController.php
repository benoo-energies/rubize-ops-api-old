<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use App\ServiceType;

class AdminProductController extends Controller
{

    public function getProducts() {
        $products = Service::where('status', 1)->get();
        $serviceType = ServiceType::where('status', 1)->get();

        return view('products', ['products' => $products, 'serviceType' => $serviceType]);
    }

    public function productCreate(Request $request) {
        $product = new Service;
        $product->title = $request->title;
        $product->service_type_id = $request->service_type_id;
        $product->picture = $request->picture;
        $product->price_fcfa = str_replace(",", ".", $request->price_fcfa);
        $product->type = 1;
        $product->status = 1;
        $product->save();

        return redirect('/products');
    }

    public function productUpdate(Request $request, $id) {
        $product = Service::where('status', 1)->where('id', $id)->first();
        $serviceType = ServiceType::where('status', 1)->get();

        $product->title = $request->title;
        $product->service_type_id = $request->service_type_id;
        $product->picture = $request->picture;
        $product->price_fcfa = str_replace(",", ".", $request->price_fcfa);
        $product->save();

        return redirect('/products');
    }

    public function productDelete(Request $request, $id) {
        $product = Service::where('status', 1)->where('id', $id)->first();

        $product->status = 2;
        $product->save();

        return redirect('/products');
    }
}