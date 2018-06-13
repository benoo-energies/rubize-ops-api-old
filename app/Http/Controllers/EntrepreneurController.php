<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entrepreneur;
use App\Order;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class EntrepreneurController extends Controller
{

    public function checkEntrepreneurLogin(Request $request, $entrepreneurTel) {
        $entrepreneur = Entrepreneur::where('telephone', $entrepreneurTel)->where('status', 1)->first();
        if(count($entrepreneur) > 0) {
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



    public function entrepreneurLogin(Request $request) {

        $entrepreneur = Entrepreneur::where('telephone', $request->entrepreneurTel)
        ->where('status', 1)->first();

        if($entrepreneur) {
            // Si le numéro existe en BDD --> Requête TAGPAY
            try {
 
                $client = new GuzzleHttpClient();
      
               //$response = $client->get('https://22806.tagpay.fr/api/tpstatus.php?merchantid=2631806354846560&password=ef9901d3ccfef8128f61cbc92ec1baf8&client=33660866178&PIN=2148');
               $response = $client->get('https://22806.tagpay.fr/api/tpstatus.php?merchantid=2631806354846560&password=ef9901d3ccfef8128f61cbc92ec1baf8&client='.$request->entrepreneurTel.'&pin='.$request->entrepreneurPin);
               //$response = $request->send();
               $xml = $response->getBody();
               $xml = simplexml_load_string($xml);
    
               if($xml->result == "0: success") {
                    $balance = $xml->reservebalance;
                    $currency = $xml->reservecurrency;
                    $idClient = $request->entrepreneurTel;
                    $merchantId = $xml->merchantid;

                    $result = array(
                        'status'    => true,
                        'data'      => array(
                            "balance"               => $balance,
                            "currency"              => $currency,
                            "idClient"              => $idClient,
                            "merchantId"            => $merchantId,
                            "entrepreneurBenooId"   => $entrepreneur->id
                        )
                    );
                    return response()->json($result);                       
                
               } else {
                $result = array(
                    "status" => false,
                    "error" => "Impossible de se connecter, votre compte n'est pas actif.Contactez votre support Benoo Energies pour plus d'information."
                );
                return response()->json($result);
               }
      
           } catch (RequestException $re) {
                $result = array(
                    "status" => false,
                    "error" => "Impossible de se connecter, veuillez réessayer. Si le problème persiste contactez votre support Benoo Energies."
                );
                return response()->json($result);
           }
        } else {
            // Si le numéro de l'entrepreneur n'existe pas en BDD
            $result = array(
                "status" => false,
                "error" => "Impossible de se connecter, votre compte n'est pas actif.Contactez votre support Benoo Energies pour plus d'information.",
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
                'status'    => false,
                'data'      => []
            );
        }

        return response()->json($result);
    }

}