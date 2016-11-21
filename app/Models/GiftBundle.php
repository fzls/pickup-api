<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GiftBundle
 */
class GiftBundle extends Model
{
    protected $table = 'gift_bundles';

    public $timestamps = true;

    protected $fillable = [
        'history_id',
        'gift_id',
        'amount'
    ];

    protected $guarded = [];

    public function history(){
        return $this->belongsTo(History::class);
    }

    public function gift(){
        return $this->belongsTo(GiftCategory::class, 'gift_id');
    }
}