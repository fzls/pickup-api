<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFeedback
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

    public function user() {
        return $this->belongsTo(User::class);
    }
}