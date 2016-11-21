<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Chat
 */
class Chat extends Model
{
    protected $table = 'chats';

    public $timestamps = true;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'recalled_at'
    ];

    protected $guarded = [];

    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver(){
        return $this->belongsTo(User::class,'receiver_id');
    }
}