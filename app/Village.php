<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'village';

    public function surveyProspect()
    {
        return $this->hasMany('App\SurveyProspect');
    }    
}