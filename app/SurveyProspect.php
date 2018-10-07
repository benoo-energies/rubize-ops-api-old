<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyProspect extends Model
{
    protected $table = 'survey_prospect';

    
    public function village()
    {
        return $this->belongsTo('App\Village');
    }    

    
    public function enqueteur()
    {
        return $this->belongsTo('App\Enqueteur');
    }    

    
    public function surveyResult()
    {
        return $this->belongsTo('App\SurveyResult');
    }    

}