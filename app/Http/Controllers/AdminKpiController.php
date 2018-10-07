<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\SurveyResult;

class AdminKpiController extends Controller
{
    public function getProspectionKpi() {
        $dataEnergy = "";
        return view('kpi-prospection', ['dataEnergy' => $dataEnergy]);
    }

    public function getProspectionKpiData($period = "total") {

        
 
        echo "TEST";

        if($period == "total") {
            $results = SurveyResult::where('status', 1)->get();
            $result = array( "status" => true);
        } elseif($period == "week") {
            $result = array( "status" => true);
        } elseif($period == "month") {            
            $result = array( "status" => true);
        } elseif($period == "year"){            
            $result = array( "status" => true);
        } else {
            $result = array(
                "status" => false,
                "error" => "Une erreur s'est produite lors de la récupération des données.",
            );
            return response()->json($result);
        }

        $jobData = array();
        foreach($results as $res) {
            if(NULL != $res->getJob()) {
                if(isset($jobData[$res->getJob()])) {
                    $jobData[$res->getJob()]['actual'] = $jobData[$res->getJob()]['actual'] + $res->besoin_actuel;
                    $jobData[$res->getJob()]['wish'] = $jobData[$res->getJob()]['wish'] + $res->besoin_futur;
                } else {
                    $jobData[$res->getJob()] = array(
                        'actual' => $res->besoin_actuel,
                        'wish' => $res->besoin_futur,
                        'job' => $res->getJob()
                    );
                }
            } else {
                if(isset($jobData[$res->getJob()])) {
                    $jobData["N.C."]['actual'] = $jobData["N.C."] + $res->besoin_actuel;
                    $jobData["N.C."]['wish'] = $jobData["N.C."]['wish'] + $res->besoin_futur;
                } else {
                    $jobData["N.C."] = array(
                        'actual' => $res->besoin_actuel,
                        'wish' => $res->besoin_futur,
                        'job' => "N.C."
                    );
                }
            }
        }
        $result['data'] = $jobData;
        return response()->json($result);
    }
}