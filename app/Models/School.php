<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class School
 *
 * 用户所属的学校
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

    /**
     * 该学校的用户们
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users() {
        return $this->hasMany(User::class);
    }
}