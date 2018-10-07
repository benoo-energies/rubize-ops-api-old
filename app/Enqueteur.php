<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enqueteur extends Model
{
    protected $table = 'enqueteur';

    public function surveyProspect()
    {
        return $this->hasMany('App\SurveyProspect');
    }    
}