<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderOrderDetail extends Model
{
    protected $table = 'provider_order_detail';
    
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
    
    public function entrepreneur()
    {
        return $this->belongsTo('App\Entrepreneur');
    }

    public function order()
    {
        return $this->belongsTo('App\ProviderOrder');
    }
}