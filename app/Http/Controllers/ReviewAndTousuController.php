<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Exceptions\UnauthorizedException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\History;
use PickupApi\Models\Review;
use PickupApi\Models\User;
use PickupApi\Models\UserFeedbackSession;
use PickupApi\Utils\TokenUtil;

/**
 * Class ReviewAndTousuController
 * @package PickupApi\Http\Controllers
 */
class ReviewAndTousuController extends Controller {
    /**
     * 用户对另一个用户进行评价
     *
     * @return RestResponse
     * @throws UnauthorizedException
     */
    public function rate() {
        $this->validate(
            $this->request,
            [
                'to'         => 'required|integer|exists:users,id',
                'history_id' => 'required|integer|exists:history,id',
                'rating'     => 'required|integer|min:0|max:5',
                'comment'    => 'required|string',
            ]
        );

        $user_id = TokenUtil::getUserId();
        $to_id   = (int)$this->request->get('to');
        $history = History::find($this->request->get('history_id'));

        if (! (($user_id === $history->passenger_id && $to_id === $history->driver_id) ||
            ($user_id === $history->driver_id && $to_id === $history->passenger_id))
        ) {
            throw new UnauthorizedException('不能替别人的订单进行评论哦');
        }

        $basic_info  = [
            'history_id'  => $history->id,
            'reviewer_id' => $user_id,
            'reviewee_id' => $to_id,
        ];
        $review_info = $this->request->only(['rating', 'comment']);


        $rate = Review::firstOrCreate($basic_info, $review_info);

        return RestResponse::created($rate);
    }

    /**
     * 用户进行反馈，包括投诉用户，提建议等等
     *
     * @return RestResponse
     */
    public function AddFeedbackSession() {
        $this->validate(
            $this->request,
            [
                'type_id'=>'required|integer|exists:user_feedback_types,id',
                'title'=>'required|string|max:255',
                'content'=>'required|string',
            ]
        );

        $feedback_session_info = array_merge(
            $this->request->only(['type_id', 'title', 'content']),
            ['user_id'=>TokenUtil::getUserId()]
        );

        $feedback_session = UserFeedbackSession::firstOrCreate($feedback_session_info);

        return RestResponse::created($feedback_session);
    }

    /*FIXME: 添加反馈后续回应及对话的功能*/
    /*TODO: 投诉用户通过在content里提及对应用户的id或username，由客服进行处理，所以应将用户名设置为unique*/
}
