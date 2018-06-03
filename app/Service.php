<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';

    // Relation service_type
    public function serviceType()
    {
        return $this->hasOne('App\ServiceType', 'id', 'service_type_id');
    }


}