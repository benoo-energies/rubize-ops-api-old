<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entrepreneur;
use App\Village;
use App\Order;
use App\EntrepreneurOrder;
use App\ServiceType;
use App\Service;
use Illuminate\Support\Facades\Hash;

class EntrepreneurController extends Controller
{

/*     public function checkEntrepreneurLogin(Request $request, $entrepreneurTel) {
        $entrepreneur = Entrepreneur::where('telephone', $entrepreneurTel)->where('status', 1)->first();
        if($entrepreneur) {
            // Si l'entrepreneur est déjà enregistré en BDD
            $customerData = array(
                "entrepreneurBenooId"   => $entrepreneur->id,
                'create'                => false
            );
        
            $result = array(
                'status'    => true,
                'data'      => $customerData
            );
            return response()->json($result);   
        } else {
            $result = array(
                "status" => false,
                "error" => "Entrepreneur doesn't exists"
            );

            return response()->json($result);  
        }
    }
 */


    public function entrepreneurLogin(Request $request) {
        $entrepreneur = Entrepreneur::where('telephone', $request->entrepreneurTel)
        ->where('status', 1)->first();
        if($entrepreneur) {
            if(Hash::check($request->entrepreneurPin, $entrepreneur->pin)) {
                $hashOK = true;
            } else {            
                $hashOK = false;
            }
    
            if($hashOK) {
                $result = array(
                    'status'    => true,
                    'data'      => array(
                        "entrepreneurBenooId"       => $entrepreneur->id,
                        "benoo_entrepreneur_id"     => $entrepreneur->id,
                        "benoo_entrepreneur_tel"    => $entrepreneur->telephone
                    )
                );
                return response()->json($result);            
            } else {
                // Si le numéro de l'entrepreneur n'existe pas en BDD
                $result = array(
                    "status" => false,
                    "error" => "Télphone et/ou pin incorrect.",
                );
    
                return response()->json($result);
            }   

        } else {
            // Si le numéro de l'entrepreneur n'existe pas en BDD
            $result = array(
                "status" => false,
                "error" => "Télphone et/ou pin incorrect.",
            );

            return response()->json($result);
        }
    }

    public function getEntrepreneurHistory(Request $request, $entrepreneurId) {
        $order = Order::select('id', 'created_at', 'total')->where('entrepreneur_id', $entrepreneurId)->where('status', 1)->orderBy('created_at', 'DESC')->get();
        $entrepreneurOrder = EntrepreneurOrder::select('id', 'created_at', 'total')->where('entrepreneur_id', $entrepreneurId)->whereIn('status', [2,3,4])->orderBy('created_at', 'DESC')->get();
        $order->map(function ($ord) {
            $ord['type'] = 'credit';
            return $ord;
        });
        $entrepreneurOrder->map(function ($entOrd) {
            $entOrd['type'] = 'debit';
            return $entOrd;
        });

        $merged = $order->concat($entrepreneurOrder);
        $history = $merged->sortByDesc(function($post)
        {
          return $post->created_at;
        });

        $historyData = array();
        if(count($history) > 0) {
            foreach ($history as $key => $history) {
                $tmpData = array(
                    "id"        => $history->id,
                    "date"      => date('d/m/Y', strtotime($history->created_at)),
                    "amount"    => $history->total,
                    "type"      => $history->type
                );
                $historyData[] = $tmpData;
            }

            $result = array(
                'status'    => true,
                'data'      => $historyData
            );
        } else {
            $result = array(
                'status'    => true,
                'data'      => []
            );
        }

        return response()->json($result);
    }


    public function getProductsData(Request $request, $entrepreneurId) {
        $entrepreneur = Entrepreneur::where('id', $entrepreneurId)->where('status', 1)->first();
        if($entrepreneur) {
            
            $typeData = array();
            $tmpService = explode(",", $entrepreneur->services);
            $serviceTypes = ServiceType::whereIn('id', $tmpService)->where('status', 1)->get();
            if($serviceTypes) {
                foreach ($serviceTypes as $key => $type) {
                    
                    $services = Service::where('status', 1)->where('service_type_id', $type->id)->orderBy('picture')->get();
                    
                    $tmpProduct = array();
                    $servicesData = array();
                    
                    if(count($services) > 0) {
                        foreach ($services as $key => $service) {
                            $tmpProduct = array(
                                "id"            => $service->id,
                                "title"         => $service->title,
                                "picture"       => $service->picture,
                                "price_fcfa"    => $service->entrepreneurPrice($entrepreneurId),
                                "decimal"       => $service->weight,
                                
                            );
                            $servicesData[] = $tmpProduct;
                        }
                        
                    }

                    $tmpData[] = array(
                        "id"        => $type->id,
                        "title"     => $type->title,
                        "picture"   => $type->picture,
                        "products"  => $servicesData
                    );
                }
                $typeData = $tmpData;
      
                $result = array(
                    'status'    => true,
                    'data'      => $typeData
                );
    
                return response()->json($result);
            } else {
                
                $result = array(
                    "status" => false,
                    "error" => "Impossible de récupérer les catégories de services."
                );

                return response()->json($result);
            }
        } else {
            // ERREUR L'id du type de service est invalide
            $result = array(
                "status" => false,
                "error" => "Impossible de récupérer les produits"
            );

            return response()->json($result);
        }
    }

}