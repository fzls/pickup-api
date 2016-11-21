<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CheckinHistory
 */
class CheckinHistory extends Model
{
    protected $table = 'checkin_history';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'obtained_credit'
    ];

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
}