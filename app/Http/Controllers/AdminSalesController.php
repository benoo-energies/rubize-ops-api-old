<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Service;
use App\Order;
use App\ProviderOrder;
use App\Entrepreneur;
use App\Provider;

class AdminSalesController extends Controller
{


    private function exportSales($type, $id=null) {
        $services = Service::where('status', 1)->get();
        if(count($services) > 0) {
            $dataService = array();
            $idService = array();
            foreach($services as $service) {
                $dataService[] = $service->title;
                $idService[] = $service->id;
            } 
        }
        
        if($type != "global") {
            if($type == 'entrepreneur') {
                $column = array(
                    'Date',
                    'ID entrepreneur',
                    'ID client',
                    'ID vente',
                );

                $column = array_merge($column, $dataService);
                $column[] = 'Total';

                $filename = "Export_sales_entrepreneur_".$id."_".date('Ymd');
                Excel::create($filename, function($excel)  use ($id, $column, $dataService, $idService) {
                
                    // ONGLET VENTES ENTREPRENEUR
                    $excel->sheet('Ventes entrepreneurs', function($sheet) use ($id, $column, $dataService, $idService) {
                        $sheet->row(1, $column);
    
                        $orders = Order::has('details')->where('entrepreneur_id', $id)->where('status', 1)->get();
                         //echo "<h1>".count($orders)."</h1>";
                         if(count($orders) > 0) {
                            foreach ($orders as $key => $order) {
    
                                $saleData = array(
                                    $order->created_at,
                                    $order->entrepreneur_id,
                                    $order->customer_id,
                                    $order->id,
                                );                         
                                 //echo "<h1>Order ID : $order->id</h1>";
                                 foreach ($idService as $key => $id) {
                                     $detail = $order->details()->where('order_id', $order->id)->where('service_id', $id)->where('status',1)->first();
                                     if(count($detail) == 0) {
                                        $qty = 0;
                                     } else {
                                         $qty = $detail->quantity;
                                     }
                                     $saleData[] = $qty;
                                     //echo "<h5>".$dataService[$key]." : $qty </h5>";
                                 }
                                 $saleData[] = $order->total;
                                 $sheet->appendRow($saleData);
                             }
        
                         }
                         
    
                    });
                             
                })->export('xls');
                

            } elseif($type == "provider") {
                $column = array(
                    'Date',
                    'ID gestionnaire',
                    'ID entrepreneur',
                    'ID vente',
                );
                
                $column = array_merge($column, $dataService);
                $column[] = 'Total';
                $filename = "Export_sales_global_provider_".$id."_".date('Ymd');


                Excel::create($filename, function($excel)  use ($id, $column, $dataService, $idService) {
                
                    // ONGLET VENTES GESTIONNAIRE
                    $excel->sheet('Ventes gestionnaires', function($sheet) use ($id, $column, $dataService, $idService) {
                        $sheet->row(1, $column);
    
                        $orders = ProviderOrder::has('details')->where('provider_id', $id)->where('status', 1)->get();
                        //echo "<h1>".count($orders)."</h1>";
                        if(count($orders) > 0) {
                            foreach ($orders as $key => $order) {

                                $saleData = array(
                                    $order->created_at,
                                    $order->provider_id,
                                    $order->entrepreneur_id,
                                    $order->id,
                                );                         
                                //echo "<h1>Order ID : $order->id</h1>";
                                foreach ($idService as $key => $id) {
                                    $detail = $order->details()->where('provider_order_id', $order->id)->where('service_id', $id)->where('status',1)->first();
                                    if(count($detail) == 0) {
                                        $qty = 0;
                                    } else {
                                        $qty = $detail->quantity;
                                    }
                                    $saleData[] = $qty;
                                    //echo "<h5>".$dataService[$key]." : $qty </h5>";
                                }
                                $saleData[] = $order->total;
                                $sheet->appendRow($saleData);
                            }
        
                        }
                         
    
                    });
                             
                })->export('xls');

            }

                
        } else {
            $filename = "Export_sales_global_".date('Ymd');
            $column = array(
                'Date',
                'ID entrepreneur',
                'ID client',
                'ID vente',
            );            
            $column = array_merge($column, $dataService);
            $column[] = 'Total';
            Excel::create($filename, function($excel)  use ($column, $dataService, $idService) {
                
                // ONGLET VENTES ENTREPRENEUR
                $excel->sheet('Ventes entrepreneurs', function($sheet) use ($column, $dataService, $idService) {
                    $sheet->row(1, $column);

                    $orders = Order::has('details')->where('status', 1)->get();
                     //echo "<h1>".count($orders)."</h1>";
                     if(count($orders) > 0) {
                        foreach ($orders as $key => $order) {

                            $saleData = array(
                                $order->created_at,
                                $order->entrepreneur_id,
                                $order->customer_id,
                                $order->id,
                            );                         
                             //echo "<h1>Order ID : $order->id</h1>";
                             foreach ($idService as $key => $id) {
                                 $detail = $order->details()->where('order_id', $order->id)->where('service_id', $id)->where('status',1)->first();
                                 if(count($detail) == 0) {
                                    $qty = 0;
                                 } else {
                                     $qty = $detail->quantity;
                                 }
                                 $saleData[] = $qty;
                                 //echo "<h5>".$dataService[$key]." : $qty </h5>";
                             }
                             $saleData[] = $order->total;
                             $sheet->appendRow($saleData);
                         }
    
                     }
                     

                });


                // ONGLET VENTES GESTIONNAIRE
                $column = array(
                    'Date',
                    'ID gestionnaire',
                    'ID entrepreneur',
                    'ID vente',
                );            
                $column = array_merge($column, $dataService);
                $column[] = 'Total';
                $excel->sheet('Ventes gestionnaires', function($sheet) use ($column, $dataService, $idService) {
                    $sheet->row(1, $column);

                    $orders = ProviderOrder::has('details')->where('status', 1)->get();
                     //echo "<h1>".count($orders)."</h1>";
                     if(count($orders) > 0) {
                        foreach ($orders as $key => $order) {

                            $saleData = array(
                                $order->created_at,
                                $order->provider_id,
                                $order->entrepreneur_id,
                                $order->id,
                            );                         
                             //echo "<h1>Order ID : $order->id</h1>";
                             foreach ($idService as $key => $id) {
                                 $detail = $order->details()->where('provider_order_id', $order->id)->where('service_id', $id)->where('status',1)->first();
                                 if(count($detail) == 0) {
                                    $qty = 0;
                                 } else {
                                     $qty = $detail->quantity;
                                 }
                                 $saleData[] = $qty;
                                 //echo "<h5>".$dataService[$key]." : $qty </h5>";
                             }
                             $saleData[] = $order->total;
                             $sheet->appendRow($saleData);
                         }
    
                     }

                });                
                         
            })->export('xls');
        }
    }


    public function exportAllSales() {
        $this->exportSales('global');
    }

    public function exportEntrepreneurSales(Request $request) {
        $entrepreneur = Entrepreneur::where('telephone', $request->idEntrepreneur)->where('status',1)->first();
        $this->exportSales('entrepreneur', $entrepreneur->id);
    }
    
    public function exportProviderSales(Request $request) {
        $provider = Provider::where('telephone', $request->idProvider)->where('status',1)->first();
        $this->exportSales('provider', $provider->id);
    }

}