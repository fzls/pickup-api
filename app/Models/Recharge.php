<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Recharge
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

    public function user() {
        return $this->belongsTo(User::class);
    }
}