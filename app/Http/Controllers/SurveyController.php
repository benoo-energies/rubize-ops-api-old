<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Survey;
use App\Village;
use App\SurveyDispo;
use App\SurveyProspect;
use App\SurveyResult;
use App\SurveyWish;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Enqueteur;

class SurveyController extends Controller
{

    public function getVillages() {
        $villages = Village::where('status', 1)->get();
        $dataVillages = array();
        if(count($villages) > 0) {
            foreach ($villages as $key => $village) {
                $dataVillages[] = array(
                    "id"    => $village->id,
                    "name"  => $village->name
                );
            }
        }

        $result = array(
            'status'    => true,
            'data'      => $dataVillages
        );
        return response()->json($result);
    }

    public function getEnqueteurs() {
        $enqueteurs = Enqueteur::where('status', 1)->get();
        $dataEnqueteurs = array();
        if(count($enqueteurs) > 0) {
            foreach ($enqueteurs as $key => $enqueteur) {
                $dataEnqueteurs[] = array(
                    "id"    => $enqueteur->id,
                    "name"  => $enqueteur->name
                );
            }
        }

        $result = array(
            'status'    => true,
            'data'      => $dataEnqueteurs
        );
        return response()->json($result);
    }

    public function saveSurvey(Request $request, $entrepreneurId) {
        $dataKwh = array(
            "lampe_petrole" => 70,
            "torche_electrique" => 5,
            "bougies" => 5,
            "ampoules" => 15,
            "ventilateur" => 60,
            "telephone" => 5,
            "climatisation" => 1100,
            "radio" => 10,
            "machine_laver" => 1500,
            "frigo" => 150,
            "congelateur" => 200,
            "tv" => 35,
            "dvd" => 15,
            "tondeuse_electrique" => 80,
            "machine_broder" => 250,
            "machine_pleinte" => 250,
            "machine_coudre" => 250,
            "scie_circulaire" => 1600,
            "scie_sauteuse" => 600,
            "toupie" => 3000,
            "raboteuse" => 1800,
            "fraise_electrique" => 2000,
            "moulin_electrique" => 750,
            "arc_souder" => 2450,
            "ponceuse" => 350
        );

        $totalKwDispo = 0;
        $totalKwDispo += $dataKwh['lampe_petrole'] * $request->dispo_lampe;
        $totalKwDispo += $dataKwh['torche_electrique'] * $request->dispo_torche;
        $totalKwDispo += $dataKwh['bougies'] * $request->dispo_bougie;
        $totalKwDispo += $dataKwh['ampoules'] * $request->dispo_ampoule;
        $totalKwDispo += $dataKwh['ventilateur'] * $request->dispo_ventilateur;
        $totalKwDispo += $dataKwh['telephone'] * $request->dispo_tel;
        $totalKwDispo += $dataKwh['climatisation'] * $request->dispo_clim;
        $totalKwDispo += $dataKwh['radio'] * $request->dispo_radio;
        $totalKwDispo += $dataKwh['machine_laver'] * $request->dispo_machine_laver;
        $totalKwDispo += $dataKwh['frigo'] * $request->dispo_frigo;
        $totalKwDispo += $dataKwh['congelateur'] * $request->dispo_congelateur;
        $totalKwDispo += $dataKwh['tv'] * $request->dispo_tv;
        $totalKwDispo += $dataKwh['dvd'] * $request->dispo_dvd;
        $totalKwDispo += $dataKwh['tondeuse_electrique'] * $request->dispo_tondeuse;
        $totalKwDispo += $dataKwh['machine_broder'] * $request->dispo_machine_broder;
        $totalKwDispo += $dataKwh['machine_pleinte'] * $request->dispo_machine_pleinte;
        $totalKwDispo += $dataKwh['machine_coudre'] * $request->dispo_machine_coudre;
        $totalKwDispo += $dataKwh['scie_circulaire'] * $request->dispo_scie_circulaire;
        $totalKwDispo += $dataKwh['scie_sauteuse'] * $request->dispo_scie_sauteuse;
        $totalKwDispo += $dataKwh['toupie'] * $request->dispo_toupie;
        $totalKwDispo += $dataKwh['raboteuse'] * $request->dispo_raboteuse;
        $totalKwDispo += $dataKwh['fraise_electrique'] * $request->dispo_fraise;
        $totalKwDispo += $dataKwh['moulin_electrique'] * $request->dispo_moulin;
        $totalKwDispo += $dataKwh['arc_souder'] * $request->dispo_arc_souder;
        $totalKwDispo += $dataKwh['ponceuse'] * $request->dispo_ponceuse;

        $totalKwWish = 0;
        $totalKwWish += $dataKwh['ampoules'] * $request->wish_ampoule;
        $totalKwWish += $dataKwh['ventilateur'] * $request->wish_ventilateur;
        $totalKwWish += $dataKwh['telephone'] * $request->wish_tel;
        $totalKwWish += $dataKwh['climatisation'] * $request->wish_clim;
        $totalKwWish += $dataKwh['radio'] * $request->wish_radio;
        $totalKwWish += $dataKwh['machine_laver'] * $request->wish_machine_laver;
        $totalKwWish += $dataKwh['frigo'] * $request->wish_frigo;
        $totalKwWish += $dataKwh['congelateur'] * $request->wish_congelateur;
        $totalKwWish += $dataKwh['tv'] * $request->wish_tv;
        $totalKwWish += $dataKwh['dvd'] * $request->wish_dvd;
        $totalKwWish += $dataKwh['tondeuse_electrique'] * $request->wish_tondeuse;
        $totalKwWish += $dataKwh['machine_broder'] * $request->wish_machine_broder;
        $totalKwWish += $dataKwh['machine_pleinte'] * $request->wish_machine_pleinte;
        $totalKwWish += $dataKwh['machine_coudre'] * $request->wish_machine_coudre;
        $totalKwWish += $dataKwh['scie_circulaire'] * $request->wish_scie_circulaire;
        $totalKwWish += $dataKwh['scie_sauteuse'] * $request->wish_scie_sauteuse;
        $totalKwWish += $dataKwh['toupie'] * $request->wish_toupie;
        $totalKwWish += $dataKwh['raboteuse'] * $request->wish_raboteuse;
        $totalKwWish += $dataKwh['fraise_electrique'] * $request->wish_fraise;
        $totalKwWish += $dataKwh['moulin_electrique'] * $request->wish_moulin;
        $totalKwWish += $dataKwh['arc_souder'] * $request->wish_arc_souder;
        $totalKwWish += $dataKwh['ponceuse'] * $request->wish_ponceuse;


        // ENREGISTREMENT DE L'ENQUETE
        // Survey
        $survey = new Survey;
        $survey->entrepreneur_id = $entrepreneurId;
        $survey->firstname = $request->clientFirstname;
        $survey->lastname = $request->clientLastname;
        $survey->telephone = $request->clientTel;
        if($request->clientJob != "Autre") {
            $survey->job = $request->clientJob;
        } else {
            $survey->job = $request->clientJob2;
        }
        $survey->situation = $request->clientSituation;
        $survey->foyer = $request->clientFoyer;
        $survey->kit = $request->clientKit;
        $survey->kit_puissance = $request->clientKitP;
        $survey->ceet = $request->clientCeet;
        $survey->ceet_tranche = $request->clientCeetTranche;
        $survey->groupe_electrogene = $request->clientGE;
        $survey->groupe_electrogene_puissance = $request->clientGEP;
        $survey->reseau = $request->clientReseau;
        $survey->reseau_puissance = $request->clientReseauP;
        $survey->telephone_operator = $request->telephoneOperator;
        $survey->telephone_operator2 = $request->telephoneOperator2;
        $survey->telephone_cost = $request->telephoneCost;
        $survey->longitude = $request->longitude;
        $survey->latitude = $request->latitude;
        $survey->status = 1;
        $survey->save();

        // SurveyDispo
        $surveyDispo = new SurveyDispo;
        $surveyDispo->survey_id = $survey->id;
        $surveyDispo->dispo_lampe = $request->dispo_lampe;
        $surveyDispo->dispo_torche = $request->dispo_torche;
        $surveyDispo->dispo_bougie = $request->dispo_bougie;
        $surveyDispo->dispo_ampoule = $request->dispo_ampoule;
        $surveyDispo->dispo_ventilateur = $request->dispo_ventilateur;
        $surveyDispo->dispo_tel = $request->dispo_tel;
        $surveyDispo->dispo_clim = $request->dispo_clim;
        $surveyDispo->dispo_radio = $request->dispo_radio;
        $surveyDispo->dispo_machine_laver = $request->dispo_machine_laver;
        $surveyDispo->dispo_frigo = $request->dispo_frigo;
        $surveyDispo->dispo_congelateur = $request->dispo_congelateur;
        $surveyDispo->dispo_tv = $request->dispo_tv;
        $surveyDispo->dispo_dvd = $request->dispo_dvd;
        $surveyDispo->dispo_tondeuse = $request->dispo_tondeuse;
        $surveyDispo->dispo_machine_broder = $request->dispo_machine_broder;
        $surveyDispo->dispo_machine_pleinte = $request->dispo_machine_pleinte;
        $surveyDispo->dispo_machine_coudre = $request->dispo_machine_coudre;
        $surveyDispo->dispo_scie_circulaire = $request->dispo_scie_circulaire;
        $surveyDispo->dispo_scie_sauteuse = $request->dispo_scie_sauteuse;
        $surveyDispo->dispo_toupie = $request->dispo_toupie;
        $surveyDispo->dispo_raboteuse = $request->dispo_raboteuse;
        $surveyDispo->dispo_fraise = $request->dispo_fraise;
        $surveyDispo->dispo_moulin = $request->dispo_moulin;
        $surveyDispo->dispo_arc_souder = $request->dispo_arc_souder;
        $surveyDispo->dispo_ponceuse = $request->dispo_ponceuse;
        $surveyDispo->status = 1;
        $surveyDispo->save();

        // SurveyWish
        $surveyWish = new SurveyWish;
        $surveyWish->survey_id = $survey->id;
        $surveyWish->wish_ampoule = $request->wish_ampoule;
        $surveyWish->wish_ventilateur = $request->wish_ventilateur;
        $surveyWish->wish_tel = $request->wish_tel;
        $surveyWish->wish_clim = $request->wish_clim;
        $surveyWish->wish_radio = $request->wish_radio;
        $surveyWish->wish_machine_laver = $request->wish_machine_laver;
        $surveyWish->wish_frigo = $request->wish_frigo;
        $surveyWish->wish_congelateur = $request->wish_congelateur;
        $surveyWish->wish_tv = $request->wish_tv;
        $surveyWish->wish_dvd = $request->wish_dvd;
        $surveyWish->wish_tondeuse = $request->wish_tondeuse;
        $surveyWish->wish_machine_broder = $request->wish_machine_broder;
        $surveyWish->wish_machine_pleinte = $request->wish_machine_pleinte;
        $surveyWish->wish_machine_coudre = $request->wish_machine_coudre;
        $surveyWish->wish_scie_circulaire = $request->wish_scie_circulaire;
        $surveyWish->wish_scie_sauteuse = $request->wish_scie_sauteuse;
        $surveyWish->wish_toupie = $request->wish_toupie;
        $surveyWish->wish_raboteuse = $request->wish_raboteuse;
        $surveyWish->wish_fraise = $request->wish_fraise;
        $surveyWish->wish_moulin = $request->wish_moulin;
        $surveyWish->wish_arc_souder = $request->wish_arc_souder;
        $surveyWish->wish_ponceuse = $request->wish_ponceuse;
        $surveyWish->status = 1;
        $surveyWish->save();

        // SurveyResult
        $surveyResult = new SurveyResult;
        $surveyResult->survey_id = $survey->id;
        $surveyResult->besoin_actuel = $totalKwDispo;
        $surveyResult->besoin_futur = $totalKwWish;
        $surveyResult->status = 1;
        $surveySaved = $surveyResult->save();


        if($surveySaved) {
            Mail::send('emails.survey', ['data' => $request, 'type' => 'Entrepreneur', "dispoKw" => $totalKwDispo, "wishKw" => $totalKwWish], function ($m) {
                $m->from('contact@benoo-energies.com', 'Benoo Energies');

                $m->to(["contact@benoo-energies.com"])->subject('Une nouvelle enquête a été enregistrée (Entrepreneur)');
            });
            // Redirection vers la page de création de profil client
            $result = array(
                "status" => true,
                "data" => array(
                    'dispoKwh' => $totalKwDispo,
                    'wishKwh' => $totalKwWish,
                )
            );
            return response()->json($result);
        } else {
            // Redirection vers la page de création de profil client
            $result = array(
                "status" => false,
                "error" => "Une erreur s'est produite, veuillez réessayer. Si le problème persiste contactez votre support Benoo Energies."
            );
            return response()->json($result);
        }
    }



    public function saveSurveyProspect(Request $request) {
        $dataKwh = array(
            "lampe_petrole" => 70,
            "torche_electrique" => 5,
            "bougies" => 5,
            "ampoules" => 15,
            "ventilateur" => 60,
            "telephone" => 5,
            "climatisation" => 1100,
            "radio" => 10,
            "machine_laver" => 1500,
            "frigo" => 150,
            "congelateur" => 200,
            "tv" => 35,
            "dvd" => 15,
            "tondeuse_electrique" => 80,
            "machine_broder" => 250,
            "machine_pleinte" => 250,
            "machine_coudre" => 250,
            "scie_circulaire" => 1600,
            "scie_sauteuse" => 600,
            "toupie" => 3000,
            "raboteuse" => 1800,
            "fraise_electrique" => 2000,
            "moulin_electrique" => 750,
            "arc_souder" => 2450,
            "ponceuse" => 350
        );

        $totalKwDispo = 0;
        $totalKwDispo += $dataKwh['lampe_petrole'] * $request->dispo_lampe;
        $totalKwDispo += $dataKwh['torche_electrique'] * $request->dispo_torche;
        $totalKwDispo += $dataKwh['bougies'] * $request->dispo_bougie;
        $totalKwDispo += $dataKwh['ampoules'] * $request->dispo_ampoule;
        $totalKwDispo += $dataKwh['ventilateur'] * $request->dispo_ventilateur;
        $totalKwDispo += $dataKwh['telephone'] * $request->dispo_tel;
        $totalKwDispo += $dataKwh['climatisation'] * $request->dispo_clim;
        $totalKwDispo += $dataKwh['radio'] * $request->dispo_radio;
        $totalKwDispo += $dataKwh['machine_laver'] * $request->dispo_machine_laver;
        $totalKwDispo += $dataKwh['frigo'] * $request->dispo_frigo;
        $totalKwDispo += $dataKwh['congelateur'] * $request->dispo_congelateur;
        $totalKwDispo += $dataKwh['tv'] * $request->dispo_tv;
        $totalKwDispo += $dataKwh['dvd'] * $request->dispo_dvd;
        $totalKwDispo += $dataKwh['tondeuse_electrique'] * $request->dispo_tondeuse;
        $totalKwDispo += $dataKwh['machine_broder'] * $request->dispo_machine_broder;
        $totalKwDispo += $dataKwh['machine_pleinte'] * $request->dispo_machine_pleinte;
        $totalKwDispo += $dataKwh['machine_coudre'] * $request->dispo_machine_coudre;
        $totalKwDispo += $dataKwh['scie_circulaire'] * $request->dispo_scie_circulaire;
        $totalKwDispo += $dataKwh['scie_sauteuse'] * $request->dispo_scie_sauteuse;
        $totalKwDispo += $dataKwh['toupie'] * $request->dispo_toupie;
        $totalKwDispo += $dataKwh['raboteuse'] * $request->dispo_raboteuse;
        $totalKwDispo += $dataKwh['fraise_electrique'] * $request->dispo_fraise;
        $totalKwDispo += $dataKwh['moulin_electrique'] * $request->dispo_moulin;
        $totalKwDispo += $dataKwh['arc_souder'] * $request->dispo_arc_souder;
        $totalKwDispo += $dataKwh['ponceuse'] * $request->dispo_ponceuse;

        $totalKwWish = 0;
        $totalKwWish += $dataKwh['ampoules'] * $request->wish_ampoule;
        $totalKwWish += $dataKwh['ventilateur'] * $request->wish_ventilateur;
        $totalKwWish += $dataKwh['telephone'] * $request->wish_tel;
        $totalKwWish += $dataKwh['climatisation'] * $request->wish_clim;
        $totalKwWish += $dataKwh['radio'] * $request->wish_radio;
        $totalKwWish += $dataKwh['machine_laver'] * $request->wish_machine_laver;
        $totalKwWish += $dataKwh['frigo'] * $request->wish_frigo;
        $totalKwWish += $dataKwh['congelateur'] * $request->wish_congelateur;
        $totalKwWish += $dataKwh['tv'] * $request->wish_tv;
        $totalKwWish += $dataKwh['dvd'] * $request->wish_dvd;
        $totalKwWish += $dataKwh['tondeuse_electrique'] * $request->wish_tondeuse;
        $totalKwWish += $dataKwh['machine_broder'] * $request->wish_machine_broder;
        $totalKwWish += $dataKwh['machine_pleinte'] * $request->wish_machine_pleinte;
        $totalKwWish += $dataKwh['machine_coudre'] * $request->wish_machine_coudre;
        $totalKwWish += $dataKwh['scie_circulaire'] * $request->wish_scie_circulaire;
        $totalKwWish += $dataKwh['scie_sauteuse'] * $request->wish_scie_sauteuse;
        $totalKwWish += $dataKwh['toupie'] * $request->wish_toupie;
        $totalKwWish += $dataKwh['raboteuse'] * $request->wish_raboteuse;
        $totalKwWish += $dataKwh['fraise_electrique'] * $request->wish_fraise;
        $totalKwWish += $dataKwh['moulin_electrique'] * $request->wish_moulin;
        $totalKwWish += $dataKwh['arc_souder'] * $request->wish_arc_souder;
        $totalKwWish += $dataKwh['ponceuse'] * $request->wish_ponceuse;


        // ENREGISTREMENT DE L'ENQUETE
        // Survey
        $survey = new SurveyProspect;
        $survey->enqueteur_id = $request->enqueteurId;
        $survey->village_id = $request->village;
        $survey->firstname = $request->clientFirstname;
        $survey->lastname = $request->clientLastname;
        $survey->telephone = $request->clientTel;
        if($request->clientJob != "Autre") {
            $survey->job = $request->clientJob;
        } else {
            $survey->job = $request->clientJob2;
        }
        $survey->situation = $request->clientSituation;
        $survey->foyer = $request->clientFoyer;
        $survey->kit = $request->clientKit;
        $survey->kit_puissance = $request->clientKitP;
        $survey->ceet = $request->clientCeet;
        $survey->ceet_tranche = $request->clientCeetTranche;
        $survey->groupe_electrogene = $request->clientGE;
        $survey->groupe_electrogene_puissance = $request->clientGEP;
        $survey->reseau = $request->clientReseau;
        $survey->reseau_puissance = $request->clientReseauP;
        $survey->telephone_operator = $request->telephoneOperator;
        $survey->telephone_operator2 = $request->telephoneOperator2;
        $survey->telephone_cost = $request->telephoneCost;
        $survey->longitude = $request->longitude;
        $survey->latitude = $request->latitude;
        if(NULL != $request->date && $request->date != "") {
            $survey->date = Carbon::createFromTimestamp($request->date)->toDateTimeString();
        } else {
            $survey->date = Carbon::now();
        }
        $survey->status = 1;
        $survey->save();

        // SurveyDispo
        $surveyDispo = new SurveyDispo;
        $surveyDispo->survey_prospect_id = $survey->id;
        $surveyDispo->dispo_lampe = $request->dispo_lampe;
        $surveyDispo->dispo_torche = $request->dispo_torche;
        $surveyDispo->dispo_bougie = $request->dispo_bougie;
        $surveyDispo->dispo_ampoule = $request->dispo_ampoule;
        $surveyDispo->dispo_ventilateur = $request->dispo_ventilateur;
        $surveyDispo->dispo_tel = $request->dispo_tel;
        $surveyDispo->dispo_clim = $request->dispo_clim;
        $surveyDispo->dispo_radio = $request->dispo_radio;
        $surveyDispo->dispo_machine_laver = $request->dispo_machine_laver;
        $surveyDispo->dispo_frigo = $request->dispo_frigo;
        $surveyDispo->dispo_congelateur = $request->dispo_congelateur;
        $surveyDispo->dispo_tv = $request->dispo_tv;
        $surveyDispo->dispo_dvd = $request->dispo_dvd;
        $surveyDispo->dispo_tondeuse = $request->dispo_tondeuse;
        $surveyDispo->dispo_machine_broder = $request->dispo_machine_broder;
        $surveyDispo->dispo_machine_pleinte = $request->dispo_machine_pleinte;
        $surveyDispo->dispo_machine_coudre = $request->dispo_machine_coudre;
        $surveyDispo->dispo_scie_circulaire = $request->dispo_scie_circulaire;
        $surveyDispo->dispo_scie_sauteuse = $request->dispo_scie_sauteuse;
        $surveyDispo->dispo_toupie = $request->dispo_toupie;
        $surveyDispo->dispo_raboteuse = $request->dispo_raboteuse;
        $surveyDispo->dispo_fraise = $request->dispo_fraise;
        $surveyDispo->dispo_moulin = $request->dispo_moulin;
        $surveyDispo->dispo_arc_souder = $request->dispo_arc_souder;
        $surveyDispo->dispo_ponceuse = $request->dispo_ponceuse;
        $surveyDispo->status = 1;
        $surveyDispo->save();

        // SurveyWish
        $surveyWish = new SurveyWish;
        $surveyWish->survey_prospect_id = $survey->id;
        $surveyWish->wish_ampoule = $request->wish_ampoule;
        $surveyWish->wish_ventilateur = $request->wish_ventilateur;
        $surveyWish->wish_tel = $request->wish_tel;
        $surveyWish->wish_clim = $request->wish_clim;
        $surveyWish->wish_radio = $request->wish_radio;
        $surveyWish->wish_machine_laver = $request->wish_machine_laver;
        $surveyWish->wish_frigo = $request->wish_frigo;
        $surveyWish->wish_congelateur = $request->wish_congelateur;
        $surveyWish->wish_tv = $request->wish_tv;
        $surveyWish->wish_dvd = $request->wish_dvd;
        $surveyWish->wish_tondeuse = $request->wish_tondeuse;
        $surveyWish->wish_machine_broder = $request->wish_machine_broder;
        $surveyWish->wish_machine_pleinte = $request->wish_machine_pleinte;
        $surveyWish->wish_machine_coudre = $request->wish_machine_coudre;
        $surveyWish->wish_scie_circulaire = $request->wish_scie_circulaire;
        $surveyWish->wish_scie_sauteuse = $request->wish_scie_sauteuse;
        $surveyWish->wish_toupie = $request->wish_toupie;
        $surveyWish->wish_raboteuse = $request->wish_raboteuse;
        $surveyWish->wish_fraise = $request->wish_fraise;
        $surveyWish->wish_moulin = $request->wish_moulin;
        $surveyWish->wish_arc_souder = $request->wish_arc_souder;
        $surveyWish->wish_ponceuse = $request->wish_ponceuse;
        $surveyWish->status = 1;
        $surveyWish->save();

        // SurveyResult
        $surveyResult = new SurveyResult;
        $surveyResult->survey_prospect_id = $survey->id;
        $surveyResult->besoin_actuel = $totalKwDispo;
        $surveyResult->besoin_futur = $totalKwWish;
        $surveyResult->status = 1;
        $surveySaved = $surveyResult->save();


        if($surveySaved) {
            Mail::send('emails.survey', ['data' => $request, 'type' => 'Prospect', "dispoKw" => $totalKwDispo, "wishKw" => $totalKwWish], function ($m) {
                $m->from('contact@benoo-energies.com', 'Benoo Energies');

                $m->to(["contact@benoo-energies.com"])->subject('Une nouvelle enquête a été enregistrée (Prospect)');
            });
            // Redirection vers la page de création de profil client
            $result = array(
                "status" => true,
                "data" => array(
                    'dispoKwh' => $totalKwDispo,
                    'wishKwh' => $totalKwWish,
                )
            );
            return response()->json($result);
        } else {
            // Redirection vers la page de création de profil client
            $result = array(
                "status" => false,
                "error" => "Une erreur s'est produite, veuillez réessayer. Si le problème persiste contactez votre support Benoo Energies."
            );
            return response()->json($result);
        }
    }

}
