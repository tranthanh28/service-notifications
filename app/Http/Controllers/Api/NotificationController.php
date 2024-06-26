<?php

namespace App\Http\Controllers\Api;

use App\Models\Monitaz\NotifyDataProcess\NotifyDataProcess;
use App\Models\Monitaz\NotifyDataProcessCompetitor\NotifyDataProcessCompetitor;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function __construct()
    {
    }

    public function alertNotification(Request $request)
    {
        $uid = $request->get('uid');
        $channelName = $request->get('channel');
        $timeNow = Carbon::now()->format("Y-m-d H:00:00");
        $timeStart = Carbon::now()->format("Y-m-d H:00:00");
        $halfTime = Carbon::now()->format("Y-m-d H:30:00");
        if ($timeNow >= $halfTime) {
            $timeStart = $halfTime;
        }

        $notification = NotifyDataProcess::where("created_at", ">", $timeStart)->where("role", 1)->where("is_confirm", 0)->where("uid", $uid)->first();
        if (empty($notification)) {
            return response()->json(
                [
                    "status" => false,
                    "data" => []
                ]
            );
        }
        $noti_id = $notification->id;
        $listObject = json_decode($notification->list_objects, true);
        $message = "";
        foreach ($listObject as $channel=>$valueChannel) {
            $this->info($channel);
            if ($channelName == $channel) {
                $message .= $channel . ":\n";
                foreach ($valueChannel as $value) {
                    $message .="\t" . $value["name"] . ": " . $value["count"] . "\n";
                }
                break;
            }
        }
        return response()->json(
            [
                "status" => true,
                "data" => [
                    "message" => $message,
                    "noti_id" => $noti_id
                ]
            ]
        );
    }

    public function alertNotificationAboutCompetitor(Request $request)
    {
        $uid = $request->get('uid');
        $channelName = $request->get('channel');
        $timeNow = Carbon::now()->format("Y-m-d H:00:00");
        $timeStart = Carbon::now()->format("Y-m-d H:00:00");
        $halfTime = Carbon::now()->format("Y-m-d H:30:00");
        if ($timeNow >= $halfTime) {
            $timeStart = $halfTime;
        }

        $notification = NotifyDataProcess::where("created_at", ">", $timeStart)->where("role", 1)->where("is_confirm", 0)->where("uid", $uid)->first();
        if (empty($notification)) {
            return response()->json(
                [
                    "status" => false,
                    "data" => []
                ]
            );
        }
        $noti_id = $notification->id;
        $listObject = json_decode($notification->list_objects, true);
        $message = "";
        foreach ($listObject as $channel=>$valueChannel) {
            $this->info($channel);
            if ($channelName == $channel) {
                $message .= $channel . ":\n";
                foreach ($valueChannel as $value) {
                    $message .="\t" . $value["name"] . ": " . $value["count"] . "\n";
                }
                break;
            }
        }
        return response()->json(
            [
                "status" => true,
                "data" => [
                    "message" => $message,
                    "noti_id" => $noti_id
                ]
            ]
        );
    }


    public function confirm(Request $request)
    {
        $notiId = $request->get('noti_id');
        $notice_by = $request->get('notice_by') ?? 0;
        $timeStart = Carbon::now()->format("Y-m-d H:00:00");
        $timeNow = Carbon::now()->format("Y-m-d H:i:s");
        $halfTime = Carbon::now()->format("Y-m-d H:30:00");
        if ($timeNow >= $halfTime) {
            $timeStart = $halfTime;
        }
        $notifications = NotifyDataProcess::where("id", $notiId)->where("created_at", ">", $timeStart)->where("is_confirm", 0)->first();
        if (empty($notifications)) {
            return response()->json(
                [
                    "status" => false,
                    "data" => []
                ]
            );
        }

        $notifications->update(["is_confirm"=> 1, "notice_by"=> $notice_by, "confirm_at"=> $timeNow]);
        return response()->json(
            [
                "status" => true,
                "data" => []
            ]
        );
    }
    public function confirmAbout()
    {

    }

}
