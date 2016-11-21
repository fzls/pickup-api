<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Withdraw
 *
 * 提现记录
 */
class Withdraw extends Model
{
    protected $table = 'withdraws';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'amount'
    ];

    protected $guarded = [];

    /**
     * 本次提现的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}