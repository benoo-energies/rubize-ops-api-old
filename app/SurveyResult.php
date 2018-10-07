<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Survey;
use App\SurveyProspect;

class SurveyResult extends Model
{
    protected $table = 'survey_result';

    public function survey()
    {
        return $this->hasOne('App\Survey');
    }    

    public function surveyProspect()
    {
        return $this->hasOne('App\SurveyProspect');
    }

    public function getJob() {
        if(NULL != $this->survey_prospect_id) {
            $job = SurveyProspect::find($this->survey_prospect_id);
            if(NULL != $job) { return $job->job; } else { return NULL; }
        } elseif(NULL != $this->survey_id) {
            $job = Survey::find($this->survey_id);
            if(NULL != $job) { return $job->job; } else { return NULL; }            
        } else {
            return NULL;
        }
    }

    /* public function scopeSurveydata($query)
    {
        return $query
              ->when($this->survey_id == NULL,function($q){
                  return $q->with('surveyProspect');
             })
             ->when(NULL == $this->survey_prospect_id ,function($q){
                  return $q->with('survey');
             });
            
    } */

}