<?php

namespace PickupApi\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use PickupApi\TokenUtil;

/**
 * Class User
 *
 * 用户
 */
class User extends Model {
    protected $table      = 'users';

    public    $timestamps = true;

    protected $fillable
                          = [
            'id',
            'school_id',
            'description',
            'money',
            'checkin_points',
            'charm_points',
            'freezed_at',
        ];

    protected $guarded    = [];

    /*因为这里的id是跟随认证服务器那边的id，不是本地自增，所以需要设置该值为false*/
    public $incrementing = false;

    /**
     * 用户所属的学校
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school() {
        return $this->belongsTo(School::class);
    }

    /**
     * 用户所设置的常用地址
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function frequent_used_locations() {
        return $this->hasMany(FrequentlyUsedLocation::class);
    }

    /**
     * 用户所注册的车辆们
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles() {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * 用户的历史出行行程记录（作为乘客）
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history() {
        return $this->hasMany(History::class, 'passenger_id');
    }

    /**
     * 用户的历史出车行程记录（作为司机）
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drive_history() {
        return $this->hasMany(History::class, 'driver_id');
    }

    /**
     * 用户的充值记录
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recharges() {
        return $this->hasMany(Recharge::class);
    }

    /**
     * 用户的提现记录
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function withdraws() {
        return $this->hasMany(Withdraw::class);
    }

    /**
     * 用户送出的礼物包记录
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function gift_bundles_sent() {
        return $this->hasManyThrough(GiftBundle::class, History::class, 'passenger_id');
    }

    /**
     * 用户收到的礼物包记录
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function gift_bundles_received() {
        return $this->hasManyThrough(GiftBundle::class, History::class, 'driver_id');
    }

    /**
     * 用户收到的评价与评论信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings() {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    /**
     * 用户的平均评分
     *
     * @return mixed
     */
    public function average_ratings() {
        return $this->ratings()->avg('rating');/*TODO: 可能有问题*/
    }

    /**
     * 用户对他人的评价记录
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews() {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * 该用户的反馈会话集
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedback_sessions() {
        return $this->hasMany(UserFeedbackSession::class);
    }

    /**
     * 该用户接收到的系统通知
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications() {
        return $this->hasMany(Notification::class, 'receiver_id');
    }

    /**
     * 该用户的签到历史
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkin_history() {
        return $this->hasMany(CheckinHistory::class);
    }

    /**
     * 该用户发送的消息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message_sent() {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    /**
     * 该用户接收到的消息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message_received() {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    /**
     * 该用户发送或接收到的消息
     *
     * @return mixed
     */
    public function messages() {
        return $this->message_sent->union($this->message_received);
    }

    /**
     * 该用户与某用户的聊天记录
     *
     * @param int $other_id 另一个用户的id
     *
     * @return mixed
     */
    public function messages_with($other_id) {
        return $this->message_sent()->where('receiver_id', $other_id)->get()->union(
            $this->message_received()->where('sender_id', $other_id)->get()
        );
    }

    // RE: below is not eloquent relations

    /**
     * 用户的已读通知
     *
     * @return mixed
     */
    public function read_notifications() {
        return $this->notifications()->whereNotNull('read_at');
    }

    /**
     * 用户的未读通知
     *
     * @return mixed
     */
    public function unread_notifications() {
        return $this->notifications()->whereNull('read_at');
    }


    /**
     * 用户的聊天记录 TODO:可能会用上面的messages替代
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function chats() {
        return Chat::where('sender_id', $this->id)->orWhere('receiver_id', $this->id);
    }

    /**
     * 用户与某用户的聊天记录  TODO:可能会用上面的messages替代
     *
     * @param int $other_id 另一个用户的id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function chats_with($other_id) {
        $user_id = $this->id;

        return Chat::where(function ($query) use ($user_id, $other_id) {
            $query->where('sender_id', $user_id)->Where('receiver_id', $other_id);
        })->orWhere(function ($query) use ($user_id, $other_id) {
            $query->where('sender_id', $other_id)->Where('receiver_id', $user_id);
        })
                   ->latest();
    }

    /* RE: above all return query builder, below return results*/
    /**
     * 用户今日是否已经签到过
     *
     * @return int
     */
    public function is_checked_in() {
        return \Redis::getbit('checkin:' . Carbon::today()->toDateString(), $this->id);
    }

    /**
     * 若用户今日尚未签到，则将用户签到，并随机赠送一定额度的签到积分（可以用于赠送礼物）
     *
     */
    public function checked_in() {
        if (! $this->is_checked_in()) {
            \Redis::setbit('checkin:' . Carbon::today()->toDateString(), $this->id, 1);
            /*TODO: add credit points for user*/
        }
    }

    /**
     * 用户当前的位置，用于在另一端同步
     *
     * @return string json-string
     */
    public function current_position() {
        return \Redis::get('current_position:' . $this->id);
    }

    /**
     * 用户所拥有的权限列表，通过利用客户端发送的token去认证服务器查询获得，存在本地的缓存中，key为token
     *
     * @return mixed
     */
    public function permissions() {
        return TokenUtil::getUserInfo()['permissions'];
    }
}