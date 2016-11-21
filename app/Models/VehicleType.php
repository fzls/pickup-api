<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleType
 *
 * 车辆的类型，包括小龟，自行车（后续可能有新的）
 */
class VehicleType extends Model
{
    protected $table = 'vehicle_types';

    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

    /**
     * 系统中注册的所有这种类型的车辆
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles(){
        return $this->hasMany(Vehicle::class, 'type_id');
    }
}