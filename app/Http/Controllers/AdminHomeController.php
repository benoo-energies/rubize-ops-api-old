<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Survey;
use App\SurveyProspect;
use App\SurveyResult;

use App\Entrepreneur;
use App\Customer;
use App\Order;

class AdminHomeController extends Controller
{
    public function getHome() {
        
        $TAUX_FCFA = 655;

        $actifEntrepreneur = Entrepreneur::select('created_at')->where('status', 1)->orderBy('created_at', 'DESC')->get();
        $nbEntrepreneur = count($actifEntrepreneur);
        if($nbEntrepreneur > 0) {
            $dateEntrepreneur = "Dernier ajout le ".date('d/m/Y à H:i', $actifEntrepreneur[0]->created_at->timestamp);
        } else {
            $dateEntrepreneur = "Aucun entrepreneur actuellement";
        }

        $client = Customer::select('created_at')->where('status', 1)->orderBy('created_at', "DESC")->get();
        $nbClient = count($client);
        if($nbClient > 0) {
            $dateClient = "Dernier ajout le ".date('d/m/Y à H:i', $client[0]->created_at->timestamp);
        } else {
            $dateClient = "Aucun client actuellement";
        }

        $survey = Survey::select('created_at')->where('status', 1)->orderBy('created_at', "DESC")->get();
        $nbSurvey = count($survey);
        
        $surveyProspect = SurveyProspect::select('created_at')->where('status', 1)->orderBy('created_at', "DESC")->get();
        $nbSurveyProspect = count($surveyProspect);

        if($nbSurveyProspect > 0 && $nbSurvey > 0){
            if($survey[0]->created_at->timestamp > $surveyProspect[0]->created_at->timestamp) {
                $dateSurvey = "Dernière enquête le ".date('d/m/Y à H:i', $survey[0]->created_at->timestamp);
            } else {
                $dateSurvey = "Dernière enquête le ".date('d/m/Y à H:i', $surveyProspect[0]->created_at->timestamp);
            }
        } elseif($nbSurveyProspect > 0 || $nbSurvey > 0) {
            if($nbSurveyProspect > 0) {
                $dateSurvey = "Dernière enquête le ".date('d/m/Y à H:i', $surveyProspect[0]->created_at->timestamp);
            } else {
                $dateSurvey = "Dernière enquête le ".date('d/m/Y à H:i', $survey[0]->created_at->timestamp);
            }
        } else {
            $dateSurvey = "Aucune enquête actuellement";
        }

        $wishKw = SurveyResult::select('besoin_futur')->where('status',1)->sum('besoin_futur');

        $order = Order::select('created_at')->where('status', 1)->orderBy('created_at', "DESC")->get();
        $nbOrder = count($order);
        if($nbOrder > 0) {
            $dateOrder = "Dernière vente le ".date('d/m/Y à H:i', $order[0]->created_at->timestamp);
        } else {
            $dateOrder = "Aucune vente actuellement";
        }

        $comission = Order::select('comission')->where('status',1)->sum('comission');

        return view('home', [
            'nbEntrepreneur' => $nbEntrepreneur, 
            'dateEntrepreneur' => $dateEntrepreneur,
            'dateSurvey' => $dateSurvey,
            'nbSurvey' => $nbSurvey + $nbSurveyProspect,
            'wishKw' => $wishKw / 1000,
            'nbClient' => $nbClient,
            'dateClient' => $dateClient,
            'nbOrder' => $nbOrder,
            'dateOrder' => $dateOrder,
            'comission' => $comission / $TAUX_FCFA,
            'tauxFcfa' => $TAUX_FCFA,
        ]);

    }
}