<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GiftCategory
 *
 * 礼品类别
 */
class GiftCategory extends Model
{
    protected $table = 'gift_categories';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'pic',
        'price'
    ];

    protected $guarded = [];

    /**
     * 返回本礼品所对应的所有礼品包
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gift_bundles(){
        return $this->hasMany(GiftBundle::class,'gift_id');
    }
}