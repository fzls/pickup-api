<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleType
 */
class VehicleType extends Model
{
    protected $table = 'vehicle_types';

    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'type_id');
    }
}