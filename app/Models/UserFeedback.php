<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFeedback
 *
 * 用户的反馈会话中的一个记录
 */
class UserFeedback extends Model
{
    protected $table = 'user_feedbacks';

    public $timestamps = true;

    protected $fillable = [
        'user_feedback_session_id',
        'user_id',
        'content'
    ];

    protected $guarded = [];

    /**
     * 该反馈记录的发送方，可能是提出反馈的用户，也可能是我们的客服
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}