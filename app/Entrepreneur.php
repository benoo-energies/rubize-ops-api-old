<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrepreneur extends Model
{
    protected $table = 'entrepreneur';

    public function surveys()
    {
        return $this->hasMany('App\Survey');
    }

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    public function ordersProvider()
    {
        return $this->hasMany('App\Order');
    }
    public function ordersProviderDetails()
    {
        return $this->hasMany('App\Order');
    }
    public function entrepreneurOrders()
    {
        return $this->hasMany('App\EntrepreneurOrder');
    }
    public function entrepreneurOrdersDetails()
    {
        return $this->hasMany('App\EntrepreneurOrderDetail');
    }

}