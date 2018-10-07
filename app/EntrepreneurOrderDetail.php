<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrepreneurOrderDetail extends Model
{
    protected $table = 'entrepreneur_order_detail';

    public function entrepreneur()
    {
        return $this->belongsTo('App\Entrepreneur');
    }

    public function product()
    {
        return $this->hasOne('App\EntrepreneurProduct', 'id', 'entrepreneur_product_id');
    }

        
}