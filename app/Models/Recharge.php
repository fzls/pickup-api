<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Recharge
 *
 * 充值订单记录
 */
class Recharge extends Model
{
    protected $table = 'recharges';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'amount'
    ];

    protected $guarded = [];

    /**
     * 本次充值的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}