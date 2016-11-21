<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Withdraw
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

    public function user() {
        return $this->belongsTo(User::class);
    }
}