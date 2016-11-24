<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace PickupApi\Models{
/**
 * Class Chat
 * 
 * 聊天记录
 *
 * @property integer $id
 * @property integer $sender_id 发送者id
 * @property integer $receiver_id 接收者id
 * @property string $content 消息内容
 * @property \Carbon\Carbon $recalled_at 召回于
 * @property string $deleted_at 删除于
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $sender
 * @property-read \PickupApi\Models\User $receiver
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Chat whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Chat whereSenderId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Chat whereReceiverId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Chat whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Chat whereRecalledAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Chat whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Chat whereUpdatedAt($value)
 */
	class Chat extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class CheckinHistory
 * 
 * 签到历史记录
 *
 * @property integer $id
 * @property integer $user_id 用户id
 * @property integer $obtained_credit 本次签到获得的积分数目
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\CheckinHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\CheckinHistory whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\CheckinHistory whereObtainedCredit($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\CheckinHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\CheckinHistory whereUpdatedAt($value)
 */
	class CheckinHistory extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class FrequentlyUsedLocation
 * 
 * 用户常用的地址
 *
 * @property integer $id
 * @property integer $user_id 该常用地点所属的用户的id
 * @property string $name 常用地点的名称
 * @property float $latitude 纬度
 * @property float $longitude 经度
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\FrequentlyUsedLocation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\FrequentlyUsedLocation whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\FrequentlyUsedLocation whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\FrequentlyUsedLocation whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\FrequentlyUsedLocation whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\FrequentlyUsedLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\FrequentlyUsedLocation whereUpdatedAt($value)
 */
	class FrequentlyUsedLocation extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class GiftBundle
 * 
 * 礼品包，即 礼品 X n
 *
 * @property integer $id
 * @property integer $history_id 这个礼品包在哪次行程中送出
 * @property integer $gift_id 这个礼品包包含的礼品的id
 * @property integer $amount 这个礼品包包含的礼品的个数
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\History $history
 * @property-read \PickupApi\Models\GiftCategory $gift
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftBundle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftBundle whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftBundle whereGiftId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftBundle whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftBundle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftBundle whereUpdatedAt($value)
 */
	class GiftBundle extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class GiftCategory
 * 
 * 礼品类别
 *
 * @property integer $id
 * @property string $name 礼物名称
 * @property string $description 礼物的详细介绍
 * @property string $pic 礼物的图片
 * @property float $price 礼物的价格
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\GiftBundle[] $gift_bundles
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftCategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftCategory wherePic($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftCategory wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\GiftCategory whereUpdatedAt($value)
 */
	class GiftCategory extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class History
 * 
 * 用户的历史行程
 *
 * @property integer $id
 * @property integer $passenger_id 乘客id
 * @property integer $driver_id 司机id
 * @property string $start_name 起点名称
 * @property float $start_latitude 起点纬度
 * @property float $start_longitude 起点经度
 * @property string $end_name 终点名称
 * @property float $end_latitude 终点纬度
 * @property float $end_longitude 终点经度
 * @property float $distance 行程距离
 * @property integer $elapsed_time 行程时间
 * @property float $base_amount 基本金额
 * @property float $gift_amount 额外礼物金额
 * @property float $penalty_amount 超时未支付罚金
 * @property \Carbon\Carbon $started_at 开始于,若为null则表明未开始
 * @property \Carbon\Carbon $finished_at 结束于
 * @property \Carbon\Carbon $paid_at 支付于
 * @property \Carbon\Carbon $reserved_at 预约于
 * @property \Carbon\Carbon $canceled_at 取消于
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $passenger
 * @property-read \PickupApi\Models\User $driver
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\HistorySnapshot[] $snapshots
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\GiftBundle[] $gift_bundles
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Review[] $reviews
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History wherePassengerId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereDriverId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereStartName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereStartLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereStartLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereEndName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereEndLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereEndLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereDistance($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereElapsedTime($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereBaseAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereGiftAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History wherePenaltyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereStartedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereFinishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History wherePaidAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereReservedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereCanceledAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\History whereUpdatedAt($value)
 */
	class History extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class HistorySnapshot
 * 
 * 行程的快照，用于构建行程路线
 *
 * @property integer $id
 * @property integer $history_id 快照所属行程id
 * @property float $latitude 纬度
 * @property float $longitude 经度
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\History $history
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\HistorySnapshot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\HistorySnapshot whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\HistorySnapshot whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\HistorySnapshot whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\HistorySnapshot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\HistorySnapshot whereUpdatedAt($value)
 */
	class HistorySnapshot extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class Notification
 * 
 * 系统通知
 *
 * @property integer $id
 * @property integer $receiver_id 接收者id
 * @property string $content 通知内容
 * @property \Carbon\Carbon $read_at 已读于
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Notification whereReceiverId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Notification whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Notification whereReadAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Notification whereUpdatedAt($value)
 */
	class Notification extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class Recharge
 * 
 * 充值订单记录
 *
 * @property integer $id
 * @property integer $user_id 充值订单的用户id
 * @property float $amount 充值金额
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Recharge whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Recharge whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Recharge whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Recharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Recharge whereUpdatedAt($value)
 */
	class Recharge extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * PickupApi\Models\Request
 *
 * @property integer $id
 * @property integer $user_id 发出请求的用户的id
 * @property string $start_name 出发地点名
 * @property float $start_latitude 出发地点经度
 * @property float $start_longitude 出发地点经度
 * @property string $end_name 终点地名
 * @property float $end_latitude 终点纬度
 * @property float $end_longitude 终点经度
 * @property integer $expected_vehicle_type 用户期待的车辆类型
 * @property string $activity 活动
 * @property string $phone_number 用户的联系方式
 * @property float $estimated_cost 预计金额
 * @property \Carbon\Carbon $reserved_at 预约于
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereStartName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereStartLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereStartLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereEndName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereEndLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereEndLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereExpectedVehicleType($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereActivity($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request wherePhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereEstimatedCost($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereReservedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Request whereUpdatedAt($value)
 */
	class Request extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class Review
 * 
 * 评价与评论
 *
 * @property integer $id
 * @property integer $history_id 评论对应行程id
 * @property integer $reviewer_id 评论者id
 * @property integer $reviewee_id 被评论者id
 * @property integer $rating 评分
 * @property string $comment 评论
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $reviewer
 * @property-read \PickupApi\Models\User $reviewee
 * @property-read \PickupApi\Models\History $history
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Review whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Review whereHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Review whereReviewerId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Review whereRevieweeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Review whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Review whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Review whereUpdatedAt($value)
 */
	class Review extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class School
 * 
 * 用户所属的学校
 *
 * @property integer $id
 * @property string $name 学校名称
 * @property string $description 学校简介
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\School whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\School whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\School whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\School whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\School whereUpdatedAt($value)
 */
	class School extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class User
 * 
 * 用户
 *
 * @property integer $id 继承自认证服务器(当利用token去服务器取回有效用户，发现该用户在本地不存在，则在本地创建该用户,并且将公共信息加入缓存中user_id->common_info)
 * @property integer $school_id 学校id
 * @property string $description 自我介绍
 * @property float $money 余额
 * @property integer $checkin_points 签到赠送的积分，可在购买礼物时使用(1000积分等于1RMB，每次赠送100~500(暂定))
 * @property integer $charm_points 魅力值 //仅更新，和当redis中无该记录时取回
 * @property \Carbon\Carbon $freezed_at 冻结于
 * @property \Carbon\Carbon $deleted_at 注销于
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\FrequentlyUsedLocation[] $frequent_used_locations
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Vehicle[] $vehicles
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\History[] $history
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\History[] $drive_history
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Recharge[] $recharges
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Withdraw[] $withdraws
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\GiftBundle[] $gift_bundles_sent
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\GiftBundle[] $gift_bundles_received
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Review[] $ratings
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Review[] $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\UserFeedbackSession[] $feedback_sessions
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Notification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\CheckinHistory[] $checkin_history
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Chat[] $message_sent
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Chat[] $message_received
 * @property-read \PickupApi\Models\Request $request
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereCheckinPoints($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereCharmPoints($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereFreezedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class UserFeedback
 * 
 * 用户的反馈会话中的一个记录
 *
 * @property integer $id
 * @property integer $user_feedback_session_id 用户反馈单号
 * @property integer $user_id 用户id，可能是反馈的用户，也可以是回复的客服的用户id{比如1}
 * @property string $content 内容
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @property-read \PickupApi\Models\UserFeedbackSession $session
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedback whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedback whereUserFeedbackSessionId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedback whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedback whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedback whereUpdatedAt($value)
 */
	class UserFeedback extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class UserFeedbackSession
 * 
 * 用户的反馈会话
 *
 * @property integer $id
 * @property integer $type_id 反馈类型id
 * @property integer $user_id 用户id
 * @property string $title 标题
 * @property string $content 内容
 * @property string $processed_at 处理于，由客服人员触发
 * @property \Carbon\Carbon $finished_at 完成于，由用户触发
 * @property integer $rating 用户对本次服务的评价
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @property-read \PickupApi\Models\UserFeedbackType $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\UserFeedback[] $feedbacks
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereProcessedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereFinishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackSession whereUpdatedAt($value)
 */
	class UserFeedbackSession extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class UserFeedbackType
 * 
 * 反馈类型
 *
 * @property integer $id
 * @property string $name 反馈类型名称，如投诉用户，bug反馈，新功能建议，功能咨询等
 * @property string $description 补充说明
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\UserFeedbackSession[] $sessions
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\UserFeedbackType whereUpdatedAt($value)
 */
	class UserFeedbackType extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class Vehicle
 * 
 * 车辆
 *
 * @property integer $id
 * @property integer $user_id 用户id
 * @property integer $type_id 车辆类型id
 * @property string $name 车辆名称
 * @property string $pic 车辆照片的URL
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @property-read \PickupApi\Models\VehicleType $type
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Vehicle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Vehicle whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Vehicle whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Vehicle whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Vehicle wherePic($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Vehicle whereUpdatedAt($value)
 */
	class Vehicle extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class VehicleType
 * 
 * 车辆的类型，包括小龟，自行车（后续可能有新的）
 *
 * @property integer $id
 * @property string $name 车辆名字
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\PickupApi\Models\Vehicle[] $vehicles
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\VehicleType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\VehicleType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\VehicleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\VehicleType whereUpdatedAt($value)
 */
	class VehicleType extends \Eloquent {}
}

namespace PickupApi\Models{
/**
 * Class Withdraw
 * 
 * 提现记录
 *
 * @property integer $id
 * @property integer $user_id 提现订单的用户id
 * @property float $amount 提现金额
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PickupApi\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Withdraw whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Withdraw whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Withdraw whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Withdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\PickupApi\Models\Withdraw whereUpdatedAt($value)
 */
	class Withdraw extends \Eloquent {}
}

