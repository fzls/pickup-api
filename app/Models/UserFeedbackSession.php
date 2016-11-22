<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFeedbackSession
 *
 * 用户的反馈会话
 */
class UserFeedbackSession extends Model
{
    protected $table = 'user_feedback_sessions';

    public $timestamps = true;

    protected $fillable = [
        'type_id',
        'user_id',
        'title',
        'content',
        'processed_at',
        'finished_at',
        'rating'
    ];

    protected $guarded = [];

    /**
     * 提出反馈的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * 该反馈的类型，如投诉另一用户，新功能建议，操作疑问等等
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(){
        return $this->belongsTo(UserFeedbackType::class, 'type_id');
    }

    /**
     * 获取该会话所对应的所有用户与客服之间的对话
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks(){
        return $this->hasMany(UserFeedback::class);
    }
}