<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Survey;
use App\Entrepreneur;
use App\Customer;
use App\Order;
use App\ServiceType;

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

        return view('entrepreneur-profile', ['entrepreneur' => $entrepreneur, 'services' => $serviceType]);
    }
    
    public function getCreateProfile() {
        $serviceType = ServiceType::where('status', 1)->get();

        return view('entrepreneur-profile', ['services' => $serviceType]);
    }
    
    
    public function updateProfile(Request $request, $id) {
        $serviceType = implode(',', $request->serviceType);
        $entrepreneur = Entrepreneur::where('id', $id)->where('status', 1)->first();

        $entrepreneur->tagpay_id = $request->tagpay_id;
        $entrepreneur->firstname = $request->firstname;
        $entrepreneur->lastname  = $request->lastname;
        $entrepreneur->telephone = $request->telephone;
        $entrepreneur->services = $serviceType;
        $entrepreneur->longitude = str_replace(",", ".", $request->longitude);
        $entrepreneur->latitude = str_replace(",", ".", $request->latitude);
        $entrepreneur->save();
        
        return redirect('/entrepreneurs');
    }
    
    public function createProfile(Request $request) {

        $serviceType = implode(',', $request->serviceType);

        $entrepreneur = new Entrepreneur;
        $entrepreneur->tagpay_id = $request->tagpay_id;
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
}