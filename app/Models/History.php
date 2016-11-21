<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class History
 */
class History extends Model
{
    protected $table = 'history';

    public $timestamps = true;

    protected $fillable = [
        'passenger_id',
        'driver_id',
        'start_name',
        'start_latitude',
        'start_longitude',
        'end_name',
        'end_latitude',
        'end_longitude',
        'distance',
        'elapsed_time',
        'base_amount',
        'gift_amount',
        'penalty_amount',
        'started_at',
        'finished_at',
        'paid_at',
        'reserved_at',
        'canceled_at'
    ];

    protected $guarded = [];

    public function passenger() {
        return $this->belongsTo(User::class,'passenger_id');
    }

    public function driver(){
        return $this->belongsTo(User::class,'driver_id');
    }

    public function snapshots(){
        return $this->hasMany(HistorySnapshot::class);
    }

    public function gift_bundles(){
        return $this->hasMany(GiftBundle::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}