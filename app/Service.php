<?php 

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\EntrepreneurPrice;

class Service extends Model
{
    protected $table = 'service';

    // Relation service_type
    public function serviceType()
    {
        return $this->hasOne('App\ServiceType', 'id', 'service_type_id');
    }

    public function entrepreneurPrice($entrepreneurId) {
        $price = EntrepreneurPrice::where('service_id', $this->id)
            ->where('entrepreneur_id', $entrepreneurId)
            ->where('status', 1)->first();
            if($price) {
                return $price->price_fcfa;
            } else {
                return $this->price_fcfa;
            }
    }

}