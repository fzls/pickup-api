<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFeedbackSession
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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function type(){
        return $this->belongsTo(UserFeedbackType::class, 'type_id');
    }
}