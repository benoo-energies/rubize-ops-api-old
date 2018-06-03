<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    public function enntrepreneur()
    {
        return $this->belongsTo('App\Entrepreneur');
    }
    

}