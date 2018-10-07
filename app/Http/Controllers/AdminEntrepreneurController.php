<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Survey;
use App\Entrepreneur;
use App\Customer;
use App\Order;
use App\Service;
use App\ServiceType;
use App\EntrepreneurPrice;
use Illuminate\Support\Facades\Redirect;

class AdminEntrepreneurController extends Controller
{
    public function getEntrepreneurs() {
        $entrepreneurs = Entrepreneur::select('id', 'telephone', 'lastname', 'firstname')
            ->where('status', 1)->orderBy('lastname')->get();

        return view('entrepreneurs', ['entrepreneurs' => $entrepreneurs]);
    }
    
    public function getProfile($id) {
        $entrepreneur = Entrepreneur::where('id', $id)->where('status', 1)->first();
        $serviceType = ServiceType::where('status', 1)->get();

        if($entrepreneur) {
            $products = Service::where('status', 1)->whereIn('service_type_id', explode(',', $entrepreneur->services))->orderBy('service_type_id')->get();
            return view('entrepreneur-profile', ['entrepreneur' => $entrepreneur, 'services' => $serviceType, 'randPin' => rand(100000, 999999), 'products' => $products]);
        } else {
            return Redirect::back()->with('status', 'error');
        }

    }
    
    public function getCreateProfile() {
        $serviceType = ServiceType::where('status', 1)->get();

        return view('entrepreneur-profile', ['services' => $serviceType, 'randPin' => rand(100000, 999999)]);
    }
    
    private function updateEntrepreneurPrice($serviceId, $entrepreneurId, $entrepreneurPrice) {
        $adminPrice = Service::where('id', $serviceId)->where('status', 1)->first();

        if($adminPrice) {
            // Check si prix identique au prix de l'admin
            if($adminPrice->price_fcfa == $entrepreneurPrice) {
                // Si prix identique               
                // Check si association existe
                $checkAssociation = EntrepreneurPrice::where('entrepreneur_id', $entrepreneurId)
                ->where('service_id', $serviceId)
                ->where('status', 1)
                ->first();                        
                if($checkAssociation) {
                    // Si oui --> Status = 2
                    $checkAssociation->status = 2;
                    $checkAssociation->save();    
                    
                }
            } else {
                // Si prix différent
                    //Check si association existe
                    $checkAssociation = EntrepreneurPrice::where('entrepreneur_id', $entrepreneurId)
                    ->where('service_id', $serviceId)
                    ->first();                      
                    if($checkAssociation) {
                        // Si association existe 
                             
                        // Comparaison du prix de l'association
                        if($checkAssociation->price_fcfa != $entrepreneurPrice || $checkAssociation->status == 2) {
                            // Si différents --> Update du prix de l'association
                            $checkAssociation->price_fcfa = $entrepreneurPrice;
                            $checkAssociation->status = 1;
                            $checkAssociation->save();
                        }
                    } else {
                        // Si non
                            // Création de l'association
                            $association = new EntrepreneurPrice;
                            $association->entrepreneur_id = $entrepreneurId;
                            $association->service_id = $serviceId;
                            $association->price_fcfa = $entrepreneurPrice;
                            $association->status = 1;
                            $association->save();
                    }
            }
        } 

    }
    
    public function updateProfile(Request $request, $id) {
        $serviceType = implode(',', $request->serviceType);
        $entrepreneur = Entrepreneur::where('id', $id)->where('status', 1)->first();
        
        if($entrepreneur) {
            
            $services = Service::whereIn('service_type_id', $request->serviceType)->where('status', 1)->orderBy('service_type_id')->get();

            if($services) {
                foreach ($services as $key => $service) {
                    $this->updateEntrepreneurPrice($service->id, $entrepreneur->id, $request['service_'.$service->id]);
                }
            }
            

            $entrepreneur->tagpay_id = $request->tagpay_id;
            $entrepreneur->firstname = $request->firstname;
            $entrepreneur->lastname  = $request->lastname;
            $entrepreneur->telephone = $request->telephone;
            $entrepreneur->services = $serviceType;
            $entrepreneur->longitude = str_replace(",", ".", $request->longitude);
            $entrepreneur->latitude = str_replace(",", ".", $request->latitude);
            $entrepreneur->save();
            
            return redirect('/entrepreneur/profile/'.$entrepreneur->id);
        } else {
            return Redirect::back()->with('status', 'error');
        }
    }
    
    public function createProfile(Request $request) {

        $serviceType = implode(',', $request->serviceType);

        $entrepreneur = new Entrepreneur;
        $entrepreneur->tagpay_id = $request->tagpay_id;
        $entrepreneur->pin = Hash::make($request->password);
        $entrepreneur->firstname = $request->firstname;
        $entrepreneur->lastname = $request->lastname;
        $entrepreneur->telephone = $request->telephone;
        $entrepreneur->services = $serviceType;
        $entrepreneur->longitude = str_replace(",", ".", $request->longitude);
        $entrepreneur->latitude = str_replace(",", ".", $request->latitude);
        $entrepreneur->type = 1;
        $entrepreneur->status = 1;
        $entrepreneur->save();
        
        return redirect('/entrepreneurs');
    }

    public function deleteProfile($id) {
        $entrepreneur = Entrepreneur::where('id', $id)->where('status', 1)->first();
        $entrepreneur->status = 2;
        $entrepreneur->save();
        
        return redirect('/entrepreneurs');
    }

    public function newPassword(Request $request, $id) {
        $entrepreneurId = $request->entrepreneurId;
        $entrepreneurPin = Hash::make($request->password);
        $entrepreneur = Entrepreneur::find($id);
        
        if($entrepreneur) {
            $entrepreneur->pin = $entrepreneurPin;
            $entrepreneur->save();
            return Redirect::back()->with('status', 'done');
        } else {
            return Redirect::back()->with('status', 'error');
        }

        
    }

}