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
            // ERREUR L'id du type de service est invalide
            $result = array(
                "status" => false,
                "error" => "No service type found"
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
    public function getServiceByType(Request $request, $typeId) {
        // Check existance Type ID
        $serviceType = ServiceType::where('status', 1)->where('id', $typeId)->first();
        if($serviceType) {
            $services = Service::where('status', 1)->where('service_type_id', $typeId)->get();
            // Encodage au format JSON
            $servicesData = array();
            foreach ($services as $key => $service) {
                $tmpData = array(
                    "id"            => $service->id,
                    "title"         => $service->title,
                    "picture"       => $service->picture,
                    "description"   => $service->description,
                    "price_fcfa"    => $service->price_fcfa,
                    "price_euro"    => $service->price_euro,
                    "description"   => $service->description,

                );
                $servicesData[] = $tmpData;
            }

            $result = array(
                'status'    => true,
                'data'      => $servicesData
            );
            return response()->json($result);

        } else {
            // ERREUR L'id du type de service est invalide
            $result = array(
                "status" => false,
                "error" => "Invalid service type id"
            );

            return response()->json($result);

        }
    }

}