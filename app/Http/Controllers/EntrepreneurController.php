<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entrepreneur;
use App\Village;
use App\Order;
use App\EntrepreneurOrder;
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
        $entrepreneurOrder = EntrepreneurOrder::select('id', 'created_at', 'total')->where('entrepreneur_id', $entrepreneurId)->where('status', 2)->orderBy('created_at', 'DESC')->get();
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

}