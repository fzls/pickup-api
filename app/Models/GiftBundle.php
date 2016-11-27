<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GiftBundle
 *
 * 礼品包，即 礼品 X n
 */
class GiftBundle extends Model
{
    protected $table = 'gift_bundles';

    public $timestamps = true;

    protected $fillable = [
        'history_id',
        'passenger_id',
        'driver_id',
        'gift_id',
        'amount'
    ];

    protected $guarded = [];

    /**
     * 返回本礼品包在哪次行程中被送出
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function history(){
        return $this->belongsTo(History::class);
    }

    /**
     * 返回本礼品包所包含的礼品的信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gift(){
        return $this->belongsTo(GiftCategory::class, 'gift_id');
    }

    /**
     * 获取礼品包的送出者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function passenger(){
        return $this->belongsTo(User::class, 'passenger_id');
    }

    /**
     * 获取礼品包的接收者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver(){
        return $this->belongsTo(User::class, 'driver_id');
    }
}