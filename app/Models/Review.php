<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
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

    public function reviewer(){
        return $this->belongsTo(User::class,'reviewer_id');
    }

    public function reviewee(){
        return $this->belongsTo(User::class,'reviewee_id');
    }

    public function history(){
        return $this->belongsTo(History::class);
    }
}