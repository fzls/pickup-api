<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 */
class Notification extends Model
{
    protected $table = 'notifications';

    public $timestamps = true;

    protected $fillable = [
        'receiver_id',
        'content',
        'read_at'
    ];

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class,'receiver_id');
    }
}