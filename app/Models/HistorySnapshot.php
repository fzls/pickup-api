<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HistorySnapshot
 */
class HistorySnapshot extends Model
{
    protected $table = 'history_snapshots';

    public $timestamps = true;

    protected $fillable = [
        'history_id',
        'latitude',
        'longitude'
    ];

    protected $guarded = [];

    public function history(){
        return $this->belongsTo(History::class);
    }
}