<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyProspect extends Model
{
    protected $table = 'survey_prospect';

    
    public function surveyResult()
    {
        return $this->belongsTo('App\SurveyResult');
    }    

}