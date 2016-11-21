<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle
 */
class Vehicle extends Model {
    protected $table      = 'vehicles';

    public    $timestamps = true;

    protected $fillable
                          = [
            'user_id',
            'type_id',
            'name',
            'pic',
        ];

    protected $guarded    = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function type(){
        return $this->belongsTo(VehicleType::class,'type_id');
    }
}