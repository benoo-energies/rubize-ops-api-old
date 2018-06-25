<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Survey;
use App\SurveyProspect;
use App\SurveyResult;
use App\SurveyWish;
use App\SurveyDispo;
use Maatwebsite\Excel\Facades\Excel;
use App\Entrepreneur;
use App\Village;

class AdminSurveyController extends Controller
{

    public function getSurveys() {
        $villages = Village::where('status', 1)->get();
        return view('surveys', ['villages' => $villages]);
    }

    public function addVillage(Request $request) {
        $checkVillage = Village::where('name', $request->village)->first();
        if($checkVillage) {
            return Redirect::back()->with('status', 'addError');        
        }
        
        $village = new Village;
        $village->name = $request->village;
        $village->status = 1;
        $village->save();
        return Redirect::back()->with('status', 'addSuccess');        
    }

    public function updateVillage(Request $request, $id) {
        $village = Village::find($id);
        if(!$village) {
            return Redirect::back()->with('status', 'updateIdError');        
        }        
        $checkVillage = Village::where('name', $request->village)->first();
        if($checkVillage) {
            return Redirect::back()->with('status', 'updateError');        
        }
        
        $village->name = $request->village;
        $village->status = 1;
        $village->save();        
        return Redirect::back()->with('status', 'updateSuccess');        
    }
    
    public function deleteVillage(Request $request, $id) {
        $village = Village::find($id);
        if(!$village) {
            return Redirect::back()->with('status', 'deleteError');        
        }
        $village->status = 2;
        $village->save();
        return Redirect::back()->with('status', 'deleteSuccess');        

    }

    private function createGlobalExcel($filename, $dataSurvey) {
        Excel::create($filename, function($excel)  use ($dataSurvey) {
            // Our first sheet
            $excel->sheet('Enquêtes', function($sheet) use ($dataSurvey) {
                $sheet->row(1, array(
                    'Date',
                    'ID entrepreneur',
                    'ID prospect',
                    'Village enquêté',
                    'Prénom',
                    'NOM',
                    'Téléphone',
                    'Activité',
                    'Situation',
                    'Foyer',
                    'Longitude',
                    'Latitude',
                    'Actuel lampe à pétrole',
                    'Actuel torche électrique',
                    'Actuel bougies',
                    'Actuel ampoules',
                    'Actuel ventilateur',
                    'Actuel telephone',
                    'Actuel climatisation',
                    'Actuel radio',
                    'Actuel machine à laver',
                    'Actuel frigo',
                    'Actuel congelateur',
                    'Actuel tv',
                    'Actuel dvd',
                    'Actuel tondeuse électrique',
                    'Actuel machine à broder',
                    'Actuel machine à pleinte',
                    'Actuel machine à coudre',
                    'Actuel scie circulaire',
                    'Actuel scie sauteuse',
                    'Actuel toupie',
                    'Actuel raboteuse',
                    'Actuel fraise électrique',
                    'Actuel moulin électrique',
                    'Actuel arc à souder',
                    'Actuel ponceuse',
                    'Souhait ampoules',
                    'Souhait ventilateur',
                    'Souhait telephone',
                    'Souhait climatisation',
                    'Souhait radio',
                    'Souhait machine_laver',
                    'Souhait frigo',
                    'Souhait congelateur',
                    'Souhait tv',
                    'Souhait dvd',
                    'Souhait tondeuse électrique',
                    'Souhait machine à broder',
                    'Souhait machine à pleinte',
                    'Souhait machine à coudre',
                    'Souhait scie circulaire',
                    'Souhait scie sauteuse',
                    'Souhait toupie',
                    'Souhait raboteuse',
                    'Souhait fraise électrique',
                    'Souhait moulin électrique',
                    'Souhait arc à souder',
                    'Souhait ponceuse',
                    'Kit solaire',
                    'Puissance Kit',
                    'CEET',
                    'Tranche CEET',
                    'Groupe électrongène',
                    'Puissance groupe électrongène',
                    'Réseau',
                    'Puissance réseau',
                    'Opérateur 1',
                    'Opérateur 2',
                    'Coût recharge/sem.',
                    'Besoin wh actuel',
                    'Besoin wh futur',
                ));
                if(count($dataSurvey)> 0) {
                    foreach ($dataSurvey as $key => $surveyResult) {
                        if($surveyResult->survey_id == NULL) {
                            $surveyType = "prospect";
                            $survey = SurveyProspect::where('id', $surveyResult->survey_prospect_id)->first();
                            $surveyWish = SurveyWish::where('survey_prospect_id', $surveyResult->survey_prospect_id)->first();
                            $surveyDispo = SurveyDispo::where('survey_prospect_id', $surveyResult->survey_prospect_id)->first();
                            $prospectId = $survey->prospect_id;
                            $village = $survey->village;
                            if("0000-00-00 00:00:00" != $survey->date && "" != $survey->date && NULL != $survey->date) {
                                $date = $survey->date;
                            } else {
                                $date = $survey->created_at;
                            }
                            $entrepreneurId = "";
                        } else {
                            $surveyType = "entrepreneur";
                            $survey = Survey::where('id', $surveyResult->survey_id)->first();
                            $surveyWish = SurveyWish::where('survey_id', $surveyResult->survey_id)->first();
                            $surveyDispo = SurveyDispo::where('survey_id', $surveyResult->survey_id)->first();
                            $entrepreneurId = $survey->entrepreneur_id;
                            $prospectId = "";
                            $date = $survey->created_at;
                            $village = "";
                        }
                        $sheet->appendRow(array(
                            $date,
                            $entrepreneurId,
                            $prospectId,
                            $village,
                            $survey->firstname,
                            $survey->lastname,
                            $survey->telephone,
                            $survey->job,
                            $survey->situation,
                            $survey->foyer,
                            $survey->longitude,
                            $survey->latitude,
                            $surveyDispo->dispo_lampe,
                            $surveyDispo->dispo_torche,
                            $surveyDispo->dispo_bougie,
                            $surveyDispo->dispo_ampoule,
                            $surveyDispo->dispo_ventilateur,
                            $surveyDispo->dispo_tel,
                            $surveyDispo->dispo_clim,
                            $surveyDispo->dispo_radio,
                            $surveyDispo->dispo_machine_laver,
                            $surveyDispo->dispo_frigo,
                            $surveyDispo->dispo_congelateur,
                            $surveyDispo->dispo_tv,
                            $surveyDispo->dispo_dvd,
                            $surveyDispo->dispo_tondeuse,
                            $surveyDispo->dispo_machine_broder,
                            $surveyDispo->dispo_machine_pleinte,
                            $surveyDispo->dispo_machine_coudre,
                            $surveyDispo->dispo_scie_circulaire,
                            $surveyDispo->dispo_scie_sauteuse,
                            $surveyDispo->dispo_toupie,
                            $surveyDispo->dispo_raboteuse,
                            $surveyDispo->dispo_fraise,
                            $surveyDispo->dispo_moulin,
                            $surveyDispo->dispo_arc_souder,
                            $surveyDispo->dispo_ponceuse,
                            $surveyWish->wish_ampoule,
                            $surveyWish->wish_ventilateur,
                            $surveyWish->wish_tel,
                            $surveyWish->wish_clim,
                            $surveyWish->wish_radio,
                            $surveyWish->wish_machine_laver,
                            $surveyWish->wish_frigo,
                            $surveyWish->wish_congelateur,
                            $surveyWish->wish_tv,
                            $surveyWish->wish_dvd,
                            $surveyWish->wish_tondeuse,
                            $surveyWish->wish_machine_broder,
                            $surveyWish->wish_machine_pleinte,
                            $surveyWish->wish_machine_coudre,
                            $surveyWish->wish_scie_circulaire,
                            $surveyWish->wish_scie_sauteuse,
                            $surveyWish->wish_toupie,
                            $surveyWish->wish_raboteuse,
                            $surveyWish->wish_fraise,
                            $surveyWish->wish_moulin,
                            $surveyWish->wish_arc_souder,
                            $surveyWish->wish_ponceuse,
                            $survey->kit,
                            $survey->kit_puissance,
                            $survey->ceet,
                            $survey->ceet_tranche,
                            $survey->groupe_electrogene,
                            $survey->groupe_electrogene_puissance,
                            $survey->reseau,
                            $survey->reseau_puissance,
                            $survey->telephone_operator,
                            $survey->telephone_operator2,
                            $survey->telephone_cost,
                            $surveyResult->besoin_actuel,
                            $surveyResult->besoin_futur,
                        )); 
                    }
                }
            });
        })->export('xls');
    }


    private function createSelectExcel($type, $filename, $dataSurvey) {
        Excel::create($filename, function($excel)  use ($dataSurvey, $type, $filename) {
            // Our first sheet
            $excel->sheet('Enquêtes', function($sheet) use ($dataSurvey, $type, $filename) {
                $sheet->row(1, array(
                    'Date',
                    'ID entrepreneur',
                    'ID prospect',
                    'Village enquêté',
                    'Prénom',
                    'NOM',
                    'Téléphone',
                    'Activité',
                    'Situation',
                    'Foyer',
                    'Longitude',
                    'Latitude',
                    'Actuel lampe à pétrole',
                    'Actuel torche électrique',
                    'Actuel bougies',
                    'Actuel ampoules',
                    'Actuel ventilateur',
                    'Actuel telephone',
                    'Actuel climatisation',
                    'Actuel radio',
                    'Actuel machine à laver',
                    'Actuel frigo',
                    'Actuel congelateur',
                    'Actuel tv',
                    'Actuel dvd',
                    'Actuel tondeuse électrique',
                    'Actuel machine à broder',
                    'Actuel machine à pleinte',
                    'Actuel machine à coudre',
                    'Actuel scie circulaire',
                    'Actuel scie sauteuse',
                    'Actuel toupie',
                    'Actuel raboteuse',
                    'Actuel fraise électrique',
                    'Actuel moulin électrique',
                    'Actuel arc à souder',
                    'Actuel ponceuse',
                    'Souhait ampoules',
                    'Souhait ventilateur',
                    'Souhait telephone',
                    'Souhait climatisation',
                    'Souhait radio',
                    'Souhait machine_laver',
                    'Souhait frigo',
                    'Souhait congelateur',
                    'Souhait tv',
                    'Souhait dvd',
                    'Souhait tondeuse électrique',
                    'Souhait machine à broder',
                    'Souhait machine à pleinte',
                    'Souhait machine à coudre',
                    'Souhait scie circulaire',
                    'Souhait scie sauteuse',
                    'Souhait toupie',
                    'Souhait raboteuse',
                    'Souhait fraise électrique',
                    'Souhait moulin électrique',
                    'Souhait arc à souder',
                    'Souhait ponceuse',
                    'Kit solaire',
                    'Puissance Kit',
                    'CEET',
                    'Tranche CEET',
                    'Groupe électrongène',
                    'Puissance groupe électrongène',
                    'Réseau',
                    'Puissance réseau',
                    'Opérateur 1',
                    'Opérateur 2',
                    'Coût recharge/sem.',
                    'Besoin wh actuel',
                    'Besoin wh futur',
                ));
                if(count($dataSurvey)> 0) {
                    foreach ($dataSurvey as $key => $survey) {
                        if($type == "prospect") {
                            $date = $survey->date;
                            $village = $survey->village;
                            $surveyResult = SurveyResult::where('survey_prospect_id', $survey->id)->first();                    
                            $surveyWish = SurveyWish::where('survey_prospect_id', $survey->id)->first();                    
                            $surveyDispo = SurveyDispo::where('survey_prospect_id', $survey->id)->first();                            
                            $prospectId = $survey->prospect_id;
                            $entrepreneurId = ""; 
                        } else {
                            $date = $survey->created_at;
                            $village = "";
                            $surveyResult = SurveyResult::where('survey_id', $survey->id)->first();
                            $surveyWish = SurveyWish::where('survey_id', $survey->id)->first();
                            $surveyDispo = SurveyDispo::where('survey_id', $survey->id)->first();
                            $entrepreneurId = $survey->entrepreneur_id;
                            $prospectId = "";
                        }
                        $sheet->appendRow(array(
                            $entrepreneurId,
                            $prospectId,
                            $survey->firstname,
                            $survey->lastname,
                            $survey->telephone,
                            $survey->job,
                            $survey->situation,
                            $survey->foyer,
                            $survey->longitude,
                            $survey->latitude,
                            $surveyDispo->dispo_lampe,
                            $surveyDispo->dispo_torche,
                            $surveyDispo->dispo_bougie,
                            $surveyDispo->dispo_ampoule,
                            $surveyDispo->dispo_ventilateur,
                            $surveyDispo->dispo_tel,
                            $surveyDispo->dispo_clim,
                            $surveyDispo->dispo_radio,
                            $surveyDispo->dispo_machine_laver,
                            $surveyDispo->dispo_frigo,
                            $surveyDispo->dispo_congelateur,
                            $surveyDispo->dispo_tv,
                            $surveyDispo->dispo_dvd,
                            $surveyDispo->dispo_tondeuse,
                            $surveyDispo->dispo_machine_broder,
                            $surveyDispo->dispo_machine_pleinte,
                            $surveyDispo->dispo_machine_coudre,
                            $surveyDispo->dispo_scie_circulaire,
                            $surveyDispo->dispo_scie_sauteuse,
                            $surveyDispo->dispo_toupie,
                            $surveyDispo->dispo_raboteuse,
                            $surveyDispo->dispo_fraise,
                            $surveyDispo->dispo_moulin,
                            $surveyDispo->dispo_arc_souder,
                            $surveyDispo->dispo_ponceuse,
                            $surveyWish->wish_ampoule,
                            $surveyWish->wish_ventilateur,
                            $surveyWish->wish_tel,
                            $surveyWish->wish_clim,
                            $surveyWish->wish_radio,
                            $surveyWish->wish_machine_laver,
                            $surveyWish->wish_frigo,
                            $surveyWish->wish_congelateur,
                            $surveyWish->wish_tv,
                            $surveyWish->wish_dvd,
                            $surveyWish->wish_tondeuse,
                            $surveyWish->wish_machine_broder,
                            $surveyWish->wish_machine_pleinte,
                            $surveyWish->wish_machine_coudre,
                            $surveyWish->wish_scie_circulaire,
                            $surveyWish->wish_scie_sauteuse,
                            $surveyWish->wish_toupie,
                            $surveyWish->wish_raboteuse,
                            $surveyWish->wish_fraise,
                            $surveyWish->wish_moulin,
                            $surveyWish->wish_arc_souder,
                            $surveyWish->wish_ponceuse,
                            $survey->kit,
                            $survey->kit_puissance,
                            $survey->ceet,
                            $survey->ceet_tranche,
                            $survey->groupe_electrogene,
                            $survey->groupe_electrogene_puissance,
                            $survey->reseau,
                            $survey->reseau_puissance,
                            $survey->telephone_operator,
                            $survey->telephone_operator2,
                            $survey->telephone_cost,
                            $surveyResult->besoin_actuel,
                            $surveyResult->besoin_futur,
                        )); 
                    }
                }
            });
        })->export('xls');
    }

    public function exportAllSurvey() {
        $surveyResults = SurveyResult::where('status', 1)->orderBy('created_at', 'ASC')->get();
        $this->createGlobalExcel("Export_all_".date('YmdHis'), $surveyResults);
    }

    public function exportEntrepreneurSurvey(Request $request) {
        $entrepreneur = Entrepreneur::where('telephone', $request->idEntrepreneur)->where('status',1)->first();
        if(count($entrepreneur) > 0) {
            $survey = Survey::where('status', 1)->orderBy('created_at', 'ASC')->where('entrepreneur_id', $entrepreneur->id)->get();
        } else {
            $survey = array();
        }
        $this->createSelectExcel("entrepreneur", "Export_entrepreneur_".$request->idEntrepreneur."_".date('YmdHis'), $survey);
    }

    public function exportProspectSurvey(Request $request) {
        $survey = SurveyProspect::where('status', 1)->orderBy('created_at', 'ASC')->where('prospect_id', $request->idProspect)->get();
        $this->createSelectExcel("prospect", "Export_prospect_".$request->idProspect."_".date('YmdHis'), $survey);
    }

}