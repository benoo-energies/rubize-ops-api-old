<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entrepreneur;
use App\Village;
use App\Order;
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
        $history = Order::where('entrepreneur_id', $entrepreneurId)->where('status', 1)->orderBy('created_at', 'DESC')->get();

        $historyData = array();
        if(count($history) > 0) {
            foreach ($history as $key => $history) {
                $tmpData = array(
                    "id"            => $history->id,
                    "date"         => date('d/m/Y', strtotime($history->created_at)),
                    "amount"       => $history->comission
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