<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use App\ServiceType;
use App\Entrepreneur;
class ServicesController extends Controller
{

    /**
    * Catégories Services
    *
    * Récupération des catégories de services
    *
    * @return Response
    */
    public function getServiceTypes() {
        $serviceTypes = ServiceType::where('status', 1)->get();
        $typeData = array();
        if(count($serviceTypes) > 0) {
            foreach ($serviceTypes as $key => $type) {
                $tmpData = array(
                    "id"        => $type->id,
                    "title"     => $type->title,
                    "picture"   => $type->picture
                );
                $typeData[] = $tmpData;
            }
            $result = array(
                "status" => true,
                "data" =>$typeData
            );

            return response()->json($result);
        } else {
            // ERREUR L'id du type de service est invalide
            $result = array(
                "status" => false,
                "error" => "No service type found"
            );

            return response()->json($result);
        }
    }

    /**
    * Catégories Services
    *
    * Récupération des catégories de services pour un entrepreneur
    *
    * @return Response
    */
    public function getServiceTypesEnt(Request $request, $entrepreneurBenooId) {
        $entrepreneur = Entrepreneur::where('id', $entrepreneurBenooId)->where('status', 1)->first();
        if($entrepreneur) {
            $tmpService = explode(",", $entrepreneur->services);
            $serviceTypes = ServiceType::whereIn('id', $tmpService)->where('status', 1)->get();
            
            $typeData = array();
            if($serviceTypes) {
                foreach ($serviceTypes as $key => $type) {
                    $tmpData = array(
                        "id"        => $type->id,
                        "title"     => $type->title,
                        "picture"   => $type->picture
                    );
                    $typeData[] = $tmpData;
                }
                $result = array(
                    "status" => true,
                    "data" =>$typeData
                );
    
                return response()->json($result);
            } else {
                
                $result = array(
                    "status" => false,
                    "error" => "Impossible de récupérer les catégories de services."
                );

                return response()->json($result);
            }
        
        } else {

            $result = array(
                "status" => false,
                "error" => "Impossible de récupérer les informations du compte."
            );

            return response()->json($result);
        } 
    }

    /**
    * Places Post
    *
    * Ajout d'un restaurant
    * @param  int  $typeId  Id de la catégorie
    *
    * @return Response
    */
    public function getServiceByType(Request $request, $typeId, $entrepreneurId = 0) {
        // Check existance Type ID
        $serviceType = ServiceType::where('status', 1)->where('id', $typeId)->first();
        if($serviceType) {

            $services = Service::where('status', 1)->where('service_type_id', $typeId)->orderBy('picture')->get();
            
            $servicesData = array();
            
            if(count($services) > 0) {
                foreach ($services as $key => $service) {
                    $tmpData = array(
                        "id"            => $service->id,
                        "title"         => $service->title,
                        "picture"       => $service->picture,
                        "description"   => $service->description,
                        "price_fcfa"    => $service->entrepreneurPrice($entrepreneurId),
                        "price_euro"    => $service->price_euro,
                        "decimal"       => $service->weight,
                        
                    );
                    $servicesData[] = $tmpData;
                }
                
            }
            
            $result = array(
                'status'    => true,
                'data'      => $servicesData
            );
            // Encodage au format JSON
            return response()->json($result);
            
        } else {
            // ERREUR L'id du type de service est invalide
            $result = array(
                "status" => false,
                "error" => "Impossible de récupérer les service associées"
            );

            return response()->json($result);

        }
    }

}