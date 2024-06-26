<?php

namespace App\Console\Commands;

use App\Events\NotificationsToDataEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Monitaz\NotifyDataProcess\NotifyDataProcess;
class SendNotificationsToData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-noti:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("test notification to data");
        $this->info("notification to data");
        $timeStart = Carbon::now()->format("Y-m-d H:00:00");
//        $allNotify = NotifyDataProcess::where("created_at", ">", $timeStart)->where("status_confirm", 0)->where("status", 1)->get();
        $allNotify = NotifyDataProcess::where("uid", "=", 314)->get();
        if ($allNotify->isEmpty()) {
            $this->info("No notification");
            return 0;
        }
        $message = "";
        foreach ($allNotify as $notification) {
            $noti_id = $notification->id;
            $uid = $notification->uid;
            $listObject = json_decode($notification->list_objects, true);
            foreach ($listObject as $channel=>$valueChannel) {
                $this->info($channel);
                $message .= $channel . ":\n";
                foreach ($valueChannel as $value) {
                    $message .="\t" . $value["name"] . ": " . $value["count"] . "\n";
                }
                $nameChannel = $channel . "-" . $uid;
                event(new NotificationsToDataEvent($message, $noti_id, $uid, $nameChannel));
                break;
            }
//            $this->info("uid ". $notification->uid);
//            $this->info($message);
        }
    }
}
