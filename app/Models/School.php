<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class School
 */
class School extends Model {
    protected $table      = 'schools';

    public    $timestamps = true;

    protected $fillable
                          = [
            'name',
            'description',
        ];

    protected $guarded    = [];

    public function users() {
        return $this->hasMany(User::class);
    }
}