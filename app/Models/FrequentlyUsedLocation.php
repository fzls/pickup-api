<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FrequentlyUsedLocation
 *
 * 用户常用的地址
 */
class FrequentlyUsedLocation extends Model
{
    protected $table = 'frequently_used_locations';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'name',
        'latitude',
        'longitude'
    ];

    protected $guarded = [];

    /**
     * 返回本常用地址所属的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}