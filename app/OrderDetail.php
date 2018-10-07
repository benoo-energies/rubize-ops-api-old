<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    
    public function entrepreneur()
    {
        return $this->hasOne('App\Entrepreneur');
    }
    
    public function customer()
    {
        return $this->hasOne('App\Customer');
    }
    
    public function service()
    {
        return $this->hasOne('App\Service');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
        

}