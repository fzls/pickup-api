<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 *
 * 评价与评论
 */
class Review extends Model
{
    protected $table = 'reviews';

    public $timestamps = true;

    protected $fillable = [
        'history_id',
        'reviewer_id',
        'reviewee_id',
        'rating',
        'comment'
    ];

    protected $guarded = [];

    /**
     * 评价者，可以是司机或乘客
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer(){
        return $this->belongsTo(User::class,'reviewer_id');
    }

    /**
     * 被评价者，可以是司机或乘客
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewee(){
        return $this->belongsTo(User::class,'reviewee_id');
    }

    /**
     * 本评论所对应的行程
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function history(){
        return $this->belongsTo(History::class);
    }
}