<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrepreneurProduct extends Model
{
    protected $table = 'entrepreneur_product';

    public function orderDetail()
    {
        return $this->hasMany('App\EntrepreneurOrderDetail');
    }
    
    public function serviceType()
    {
        return $this->hasOne('App\ServiceType', 'id', 'service_type_id');
    }

}