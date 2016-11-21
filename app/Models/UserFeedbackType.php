<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFeedbackType
 *
 * 反馈类型
 */
class UserFeedbackType extends Model
{
    protected $table = 'user_feedback_types';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $guarded = [];

    /**
     * 所有这种类型的反馈会话
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions(){
        return $this->hasMany(UserFeedbackSession::class,'type_id');
    }
}