<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * 系统通知
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

    protected $dates = ['read_at'];

    /**
     * 本通知的目标用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class,'receiver_id');
    }
}