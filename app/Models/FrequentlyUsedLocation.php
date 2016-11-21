<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FrequentlyUsedLocation
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

    public function user(){
        return $this->belongsTo(User::class);
    }
}