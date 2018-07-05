<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EntrepreneurProduct;

class EntrepreneurProductController extends Controller
{

    public function getEntrepreneurProduct() {
        // Check existance Type ID
            $products = EntrepreneurProduct::where('status', 1)->get();
            
            $productData = array();
            
            if(count($products) > 0) {
                foreach ($products as $key => $product) {
                    $tmpData = array(
                        "id"            => $product->id,
                        "title"         => $product->title,
                        "picture"       => $product->picture,
                        "description"   => $product->description,
                        //"price_fcfa"    => $product->entrepreneurPrice($entrepreneurId),
                        "price_fcfa"    => $product->price_fcfa,
                        "unity"    => $product->unity,
                        
                    );
                    $productData[] = $tmpData;
                }
            
                $result = array(
                    'status'    => true,
                    'data'      => $productData
                );
                // Encodage au format JSON
                return response()->json($result);
                
            } else {
            // ERREUR L'id du type de service est invalide
            $result = array(
                "status" => false,
                "error" => "Aucun produit disponible à la commande actuellement."
            );

            return response()->json($result);

        }
    }

}