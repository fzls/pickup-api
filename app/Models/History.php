<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class History
 *
 * 用户的历史行程
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

    /**
     * 本次行程的乘客
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function passenger() {
        return $this->belongsTo(User::class,'passenger_id');
    }

    /**
     * 本次行程的司机
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver(){
        return $this->belongsTo(User::class,'driver_id');
    }

    /**
     * 本次行程所对应的快照，可用于在客户端重现行程所经过的路线
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function snapshots(){
        return $this->hasMany(HistorySnapshot::class);
    }

    /**
     * 本次行程中所送出的礼品包
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gift_bundles(){
        return $this->hasMany(GiftBundle::class);
    }

    /**
     * 本次行程中双方的评价，双向，可选
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(){
        return $this->hasMany(Review::class);
    }
}