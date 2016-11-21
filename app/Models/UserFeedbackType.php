<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFeedbackType
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

    public function sessions(){
        return $this->hasMany(UserFeedbackSession::class,'type_id');
    }
}