<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle
 *
 * 车辆
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

    /**
     * 这辆车的主人
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * 这辆车的类型，小龟或者自行车
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(){
        return $this->belongsTo(VehicleType::class,'type_id');
    }
}