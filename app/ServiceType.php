<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $table = 'service_type';

    // Relation services
    public function services()
    {
        return $this->belongsTo('App\Service', 'service_type_id', 'id');
    }


}