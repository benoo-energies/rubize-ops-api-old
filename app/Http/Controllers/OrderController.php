<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entrepreneur;
use App\Order;
use App\OrderDetail;
use App\Customer;

class OrderController extends Controller
{

    public function saveOrder(Request $request, $entrepreneurId) {
        $entrepreneur = Entrepreneur::find($entrepreneurId);

        if($entrepreneur) {

            $customer = Customer::where('telephone',  $request["clientTel"])
            ->where('entrepreneur_id',$entrepreneur->id)
            ->where('status', 1)
            ->first();

            if($customer){ $customerId = $customer->id; } else { $customerId = NULL; } 

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
                    $tmpDetail->unit_price_fcfa = $value['price'];
                    $tmpDetail->status = 1;
                    $tmpDetail->save();
                } 
            }            
            $result = array(
                'status'    => true,
                'data'      => array(
                    "balance"               => "",
                    "currency"              => "",
                    "idClient"              => "",
                    "merchantId"            => "",
                    "entrepreneurBenooId"   => $entrepreneur->id
                )
            );
            return response()->json($result);            
            
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