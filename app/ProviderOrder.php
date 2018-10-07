<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderOrder extends Model
{
    protected $table = 'provider_order';
    
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function entrepreneur()
    {
        return $this->belongsTo('App\Entrepreneur');
    }

    public function details()
    {
        return $this->hasMany('App\ProviderOrderDetail');
    }

}