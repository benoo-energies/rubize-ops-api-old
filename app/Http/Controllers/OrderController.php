<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entrepreneur;
use App\Order;
use App\OrderDetail;
use App\Customer;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class OrderController extends Controller
{

    public function saveOrder(Request $request, $entrepreneurId) {
        $entrepreneur = Entrepreneur::where('telephone', $request['entrepreneurTel'])
        ->where('status', 1)->first();

        if($entrepreneur) {
            // Si le numéro existe en BDD --> Requête TAGPAY
            try {
                $merchantId = $request['merchantId'][0];
                $merchantPassword = "ef9901d3ccfef8128f61cbc92ec1baf8";
                $entrepreneurTel = $request['entrepreneurTel'];
                $entrepreneurPin = $request['entrepreneurPin'];
                $commission = $request['comission'];
                $entrepreneurRC = $request['entrepreneurRC'][0];
                $description = $request['description'];
                $referenceId = $request['referenceId'];
                $total = $request['total'];

                $link = "https://22806.tagpay.fr/api/tpdebit.php?merchantid=".$merchantId."&password=".$merchantPassword."&client=".$entrepreneurTel."&pin=".$entrepreneurPin."&amount=".$commission."&currency=".$entrepreneurRC."&description=".$description."&referenceid=".$referenceId;

                $client = new GuzzleHttpClient();
                $response = $client->get($link);
                $xml = $response->getBody();
                $xml = simplexml_load_string($xml);                

                if($xml->result == "0 : success" || $xml->result == "0: success" || $xml->result == "0 :success" ||  $xml->result == "0:success") {
                   $customer = Customer::where('telephone',  $request["clientTel"])
                   ->where('entrepreneur_id',$entrepreneur->id)
                   ->where('status', 1)
                   ->first();
                   
                   if($customer){
                       $customerId = $customer->id;
                    } else {
                        $customerId = NULL;
                    }   
                    $order = new Order;
                    $order->entrepreneur_id = $entrepreneur->id;
                    $order->customer_id = $customerId;
                    $order->total = $request['total'];
                    $order->comission = $request['comission'];
                    $order->status = 1;
                    $order->save();
                    foreach ($request->products as $key => $value) {
                        if(!empty($value)) {
                            $tmpDetail = new OrderDetail;
                            $tmpDetail->entrepreneur_id = $entrepreneur->id;
                            $tmpDetail->customer_id = $customerId;
                            $tmpDetail->service_id = $value['id'];
                            $tmpDetail->order_id = $order->id;
                            $tmpDetail->quantity = $value['qty'];
                            $tmpDetail->status = 1;
                            $tmpDetail->save();
                        } 
                    }                                    
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
                        "error" => "Impossible de finaliser la vente, veuillez réessayer. Si le problème persiste contactez votre support Benoo Energies."
                    );
                    return response()->json($result);
                } 
           } catch (RequestException $re) {
                $result = array(
                    "status" => false,
                    "error" => "Une erreur s'est produite lors de l'enregistrement de la vente, veuillez réessayer. Si le problème persiste contactez votre support Benoo Energies."
                );
                return response()->json($result);
           }
        } else {
            // Si le numéro de l'entrepreneur n'existe pas en BDD
            $result = array(
                "status" => false,
                "error" => "Impossible de finaliser la vente, votre compte n'est pas actif. Contactez votre support Benoo Energies pour plus d'information.",
            );

            return response()->json($result);
        }  
    }

}