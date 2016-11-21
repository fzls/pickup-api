<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GiftCategory
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

    public function gift_bundles(){
        return $this->hasMany(GiftBundle::class,'gift_id');
    }
}