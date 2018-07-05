<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Entrepreneur;
use App\EntrepreneurOrder;
use App\EntrepreneurProduct;
use App\EntrepreneurOrderDetail;
use Illuminate\Support\Facades\Redirect;

class AdminOrderController extends Controller
{
    public function getEntrepreneurOrders(Request $request) {
        if(NULL != $request['type'] && $request['type'] != "") {
            $type = $request['type'];
            $orders = EntrepreneurOrder::where('status', $request['type'])->orderBy('created_at', "DESC")->get();
        } else {
            $type = "";
            $orders = EntrepreneurOrder::whereIn('status', [1,2,3,4,5])->orderBy('created_at', "DESC")->get();
        }

        return view('orders', ['orders' => $orders, "type" => $type]);
    }

    public function getEntrepreneurOrderDetail($entrepreneurId, $orderId) {
        $entrepreneur = Entrepreneur::find($entrepreneurId);
        $order = EntrepreneurOrder::find($orderId);

        if($order && $entrepreneur) {
            $details = $order->orderDetails;
            return view('order-detail', ['order' => $order, 'entrepreneur' => $entrepreneur, 'details' => $details]);
        } else {
            return back();
        }
    }

    public function updateEntrepreneurOrder(Request $request, $entrepreneurId, $orderId) {
        $entrepreneur = Entrepreneur::find($entrepreneurId);
        $order = EntrepreneurOrder::find($orderId);

        if(NULL != $request['paid'] && $request['paid'] != "") {
            $paid = 1;
        } else {
            $paid = 0;
        }

        if($order && $entrepreneur) {
            $order->status = $request->status;
            $order->information = $request->information;
            $order->paid = $paid;
            $order->save();

            return redirect('orders/'.$entrepreneurId.'/'.$orderId);

        } else {
            return back();
        } 
    }

}