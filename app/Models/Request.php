<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-24
 * Time: 22:00
 */

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;


class Request extends Model {
    protected $table      = 'requests';

    public    $timestamps = true;

    protected $fillable
                          = [
            'start_name',
            'start_latitude',
            'start_longitude',
            'end_name',
            'end_latitude',
            'end_longitude',
            'expected_vehicle_type',
            'activity',
            'phone_number',
            'estimated_cost',
            'reserved_at'
        ];

    protected $guarded    = [];

    protected $dates = ['reserved_at'];
}