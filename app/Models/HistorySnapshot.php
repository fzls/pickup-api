<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HistorySnapshot
 *
 * 行程的快照，用于构建行程路线
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

    /**
     * 返回本快照对应的行程
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function history(){
        return $this->belongsTo(History::class);
    }
}