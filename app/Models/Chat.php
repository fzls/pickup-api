<?php

namespace PickupApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Chat
 *
 * 聊天记录
 */
class Chat extends Model {
    protected $table      = 'chats';

    public    $timestamps = true;

    protected $fillable
                          = [
            'sender_id',
            'receiver_id',
            'content',
            'recalled_at',
        ];

    protected $guarded    = [];

    /**
     * 返回本条聊天记录的发送方
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * 返回本条聊天记录的接收方
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}