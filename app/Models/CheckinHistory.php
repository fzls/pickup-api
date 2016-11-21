<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CheckinHistory
 *
 * 签到历史记录
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

    /**
     * 返回本条签到记录的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}