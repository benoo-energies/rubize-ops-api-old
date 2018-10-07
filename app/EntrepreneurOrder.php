<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrepreneurOrder extends Model
{
    protected $table = 'entrepreneur_order';

    public function entrepreneur()
    {
        return $this->belongsTo('App\Entrepreneur');
    }
    

    public function orderDetails()
    {
        return $this->hasMany('App\EntrepreneurOrderDetail');
    }    
}