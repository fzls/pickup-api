<?php

namespace PickupApi\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use PickupApi\Util;

/**
 * Class User
 */
class User extends Model {
    protected $table      = 'users';

    public    $timestamps = true;

    protected $fillable
                          = [
            'school_id',
            'description',
            'money',
            'checkin_points',
            'charm_points',
            'freezed_at',
        ];

    protected $guarded    = [];

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function frequent_used_locations() {
        return $this->hasMany(FrequentlyUsedLocation::class);
    }

    public function vehicles() {
        return $this->hasMany(Vehicle::class);
    }

    public function history() {
        return $this->hasMany(History::class, 'passenger_id');
    }

    public function drive_history() {
        return $this->hasMany(History::class, 'driver_id');
    }

    public function recharges() {
        return $this->hasMany(Recharge::class);
    }

    public function withdraws() {
        return $this->hasMany(Withdraw::class);
    }

    public function gift_bundles_sent() {
        return $this->hasManyThrough(GiftCategory::class, History::class, 'passenger_id');
    }

    public function gift_bundles_received() {
        return $this->hasManyThrough(GiftCategory::class, History::class, 'driver_id');
    }

    public function ratings() {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function average_ratings() {
        return $this->ratings->avg('rating');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function feedback_sessions() {
        return $this->hasMany(UserFeedbackSession::class);
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'receiver_id')
    }

    public function checkin_history() {
        return $this->hasMany(CheckinHistory::class);
    }

    public function message_sent() {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function message_received() {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function messages() {
        return $this->message_sent->union($this->message_received);
    }

    public function messages_with($other_id) {
        return $this->message_sent()->where('receiver_id', $other_id)->get()->union(
            $this->message_received()->where('sender_id', $other_id)->get()
        )
    }

    // RE: below is not eloquent relations

    public function read_notifications() {
        return $this->notifications()->whereNotNull('read_at');
    }

    public function unread_notifications() {
        return $this->notifications()->whereNull('read_at');
    }


    public function chats() {
        return Chat::where('sender_id', $this->id)->orWhere('receiver_id', $this->id);
    }

    public function chats_with($other_id) {
        $user_id = Util::getUserId();

        return Chat::where(function ($query) use ($user_id, $other_id) {
            $query->where('sender_id', $user_id)->Where('receiver_id', $other_id);
        })->orWhere(function ($query) use ($user_id, $other_id) {
            $query->where('sender_id', $other_id)->Where('receiver_id', $user_id);
        })
                   ->latest();
    }

    /* RE: above all return query builder, below return results*/
    public function is_checked_in() {
        return \Redis::getbit('checkin:' . Carbon::today()->toDateString(), Util::getUserId());
    }

    public function checked_in() {
        if (! $this->is_checked_in()) {
            \Redis::setbit('checkin:' . Carbon::today()->toDateString(), Util::getUserId(), 1);
            /*TODO: add credit points for user*/
        }
    }

    public function current_position() {
        return \Redis::get('current_position:' . Util::getUserId());
    }

    public function permissions() {
        return Util::getUserInfo()['permissions'];
    }
}