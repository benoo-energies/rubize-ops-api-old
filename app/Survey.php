<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'survey';

    public function enntrepreneur()
    {
        return $this->belongsTo('App\Entrepreneur');
    }
    public function surveyResult()
    {
        return $this->belongsTo('App\SurveyResult');
    }    
}