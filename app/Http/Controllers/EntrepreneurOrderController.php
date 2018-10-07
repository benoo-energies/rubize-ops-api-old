<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entrepreneur;
use App\EntrepreneurOrder;
use App\EntrepreneurOrderDetail;
use App\EntrepreneurProduct;
use Illuminate\Support\Facades\Mail;

class EntrepreneurOrderController extends Controller
{

    public function saveOrder(Request $request, $entrepreneurId) {
        $entrepreneur = Entrepreneur::find($entrepreneurId);

        if($entrepreneur) {

            $order = new EntrepreneurOrder;
            $order->entrepreneur_id = $entrepreneur->id;
            $order->total = $request['total'];
            $order->status = 2; 
            $order->save();
            foreach ($request->products as $key => $value) {
                if(!empty($value)) {
                    $product = EntrepreneurProduct::where('id',$value['id'])->where('status', 1)->first();
                    if($product){ $productTypeId = $product->service_type_id; } else { $productTypeId = NULL; }

                    $tmpDetail = new EntrepreneurOrderDetail;
                    $tmpDetail->entrepreneur_id = $entrepreneur->id;
                    $tmpDetail->entrepreneur_order_id = $order->id;
                    $tmpDetail->entrepreneur_product_id = $value['id'];
                    $tmpDetail->entrepreneur_product_type_id = $productTypeId;
                    $tmpDetail->quantity = $value['qty'];
                    $tmpDetail->unit_price_fcfa = $value['price'];
                    $tmpDetail->total_price_fcfa = $value['price']*$value['qty'];
                    $tmpDetail->status = 1;
                    $tmpDetail->save();
                } 
            }          

            // ENVOI DU MAIL AVEC LA COMMANDE
/*             Mail::send('emails.entrepreneur-order', ['products' => $request->products, 'total' => $request['total'], "entrepreneur" => $entrepreneur], function ($m) {
                $m->from('contact@benoo-energies.com', 'Benoo Energies');
    
                $m->to(["akenfack@benoo-energies.com", "contact@benoo-energies.com", "mbordeleau@benoo-energies.com"])->subject('Une nouvelle commande entrepreneur a été enregistrée');
                //$m->to("vjlockel@gmail.com")->subject('Une nouvelle commande entrepreneur a été enregistrée');
            }); */

            $result = array(
                'status'    => true,
                'data'      => array(
                    "entrepreneurBenooId"   => $entrepreneur->id
                )
            );
            return response()->json($result);            
            
        } else {
            // Si le numéro de l'entrepreneur n'existe pas en BDD
            $result = array(
                "status" => false,
                "error" => "Impossible de finaliser votre commande, votre compte n'est pas actif. Contactez votre support Benoo Energies pour plus d'information.",
            );

            return response()->json($result);
        }  
    }

    public function getOrderHistory($entrepreneurId) {
        $orders = EntrepreneurOrder::whereIn('status', [1,2,3])
            ->where('entrepreneur_id', $entrepreneurId)
            ->orderBy('created_at', 'ASC')
            ->get();
    
        $orderData = array();
        if(count($orders) > 0) {
            $libelleStatus = array(
                1 => "Commande en attente de validation",
                2 => "Commande en cours",
                3 => "Commande expédiée"
            );

            foreach ($orders as $key => $order) {
                $details = $order->orderDetails;
                
                $detailTemp = "";
                
                if(count($details) > 0) {
                    $i = 0;
                    foreach ($details as $key => $detail) {
                        /* if($i > 0) { $detailTemp .="<br>"; } */
                        $detailTemp .= "<li>".$detail->quantity." x ".$detail->product->title."</li>";
                        $i++;
                    }                    
                }

                $tmpData = array(
                    "id"            => $order->id,
                    "date"         => date('d/m/Y', strtotime($order->created_at)),
                    "total"       => $order->total,
                    "detail"    => $detailTemp,
                    'status'  => $order->status,
                    'statusLibelle'  => $libelleStatus[$order->status]
                );
                $orderData[] = $tmpData;
            }

            $result = array(
                'status'    => true,
                'data'      => $orderData
            );
        } else {
            $result = array(
                'status'    => true,
                'data'      => []
            );
        }

        return response()->json($result);


    }

    public function updateOrderStatus(Request $request, $entrepreneurId, $orderId) {
        $order = EntrepreneurOrder::where("id", $orderId)->where('entrepreneur_id', $entrepreneurId)->first();

        if($order) {
            $order->status = 4;
            $order->save();

            $result = array(
                'status'    => true,
                'data'      => array()
            );
            return response()->json($result);            
        } else {
            // Si le numéro de l'entrepreneur n'existe pas en BDD
            $result = array(
                "status" => false,
                "error" => "Impossible de mettre à jour le statut de votre commande. Si le problème persiste, contactez votre support Benoo Energies.",
            );

            return response()->json($result);  
        }
    }

}