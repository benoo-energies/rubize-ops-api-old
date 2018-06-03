<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    
    public function order()
    {
        return $this->hasOne('App\Order');
    }
    
    public function entrepreneur()
    {
        return $this->belongsTo('App\Entrepreneur');
    }
    
    public function customer()
    {
        return $this->hasOne('App\Customer');
    }

    public function details()
    {
        return $this->hasMany('App\OrderDetail');
    }

}