<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entrepreneur;
use App\Order;
use App\OrderDetail;
use App\Customer;
use App\Service;
use Carbon\Carbon;

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
            $order->payment_type = $request['paymentType'];
            $order->date = Carbon::now();
            $order->status = 1;
            $order->save();
            foreach ($request->products as $key => $value) {
                if(!empty($value)) {
                    $service = Service::where('id',$value['id'])->where('status', 1)->first();
                    if($service){ $serviceTypeId = $service->service_type_id; } else { $serviceTypeId = NULL; }
                    
                    $tmpDetail = new OrderDetail;
                    $tmpDetail->entrepreneur_id = $entrepreneur->id;
                    $tmpDetail->customer_id = $customerId;
                    $tmpDetail->service_id = $value['id'];
                    $tmpDetail->service_type_id = $serviceTypeId;
                    $tmpDetail->order_id = $order->id;
                    $tmpDetail->quantity = $value['qty'];
                    $tmpDetail->unit_price_fcfa = $value['price'];
                    $tmpDetail->total_price_fcfa = $value['price']*$value['qty'];
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

    public function saveOfflineOrder(Request $request, $entrepreneurId) {
       
        $entrepreneur = Entrepreneur::find($entrepreneurId);

        if($entrepreneur) {
            if( $request['carts'] > 0 ) {

                $offlineSales = $request['carts'];
                
                foreach ($request['carts'] as $key => $cart) {
                    $total = 0;
    
                    $order = new Order;
                    $order->entrepreneur_id = $entrepreneur->id;
                    $order->status = 1;
                    $order->date = Carbon::createFromTimestamp($cart[0]['date'])->toDateTimeString();
                    $order->total = $cart[0]['total'];
                    $order->comission = $cart[0]['total']*0.2;
                    $order->payment_type = $cart[0]['paymentType'];
                    $order->save();
                    
                    foreach ($cart[0]['detail']['products'] as $key => $product ) {
                        if(isset($product['id'])) {
                            $service = Service::where('id',$product['id'])->where('status', 1)->first();
                            if($service){ $serviceTypeId = $service->service_type_id; } else { $serviceTypeId = NULL; }

                            $tmpDetail = new OrderDetail;
                            $tmpDetail->entrepreneur_id = $entrepreneur->id;
                            $tmpDetail->service_id = $product['id'];
                            $tmpDetail->service_type_id = $serviceTypeId;
                            $tmpDetail->order_id = $order->id;
                            $tmpDetail->quantity = $product['qty'];
                            $tmpDetail->unit_price_fcfa = $product['price'];
                            $tmpDetail->total_price_fcfa = $product['price']*$product['qty'];
                            $tmpDetail->status = 1;
                            $tmpDetail->save();
                        }
                        $total += $product['price']*$product['qty']; 
                    }        
                    
    
                    $offlineSales[$key] = [];
                }
                
                foreach($offlineSales as $k => $sale) {
                    if($sale == []) { unset($offlineSales[$k]); }
                }
                
            }     

            $result = array(
                'status'    => true,
                'data'      => array(
                    "balance"               => "",
                    "currency"              => "",
                    "idClient"              => "",
                    "merchantId"            => "",
                    "entrepreneurBenooId"   => $entrepreneur->id,
                    /* "offlineSales"   => $offlineSales */
                )
            );
            return response()->json($result);            
            
        } else {
            // Si le numéro de l'entrepreneur n'existe pas en BDD
            $result = array(
                "status" => false,
                "error" => "Impossible de finaliser la vente, votre compte n'est pas actif. Contactez votre support Benoo Energies pour plus d'information.",
                "offlineSales" => $offlineSales
            );

            return response()->json($result);
        }  
    }

}