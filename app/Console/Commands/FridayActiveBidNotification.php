<?php

namespace App\Console\Commands;

use App\Models\Bid;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendBidNotificationEmail;

class FridayActiveBidNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bidNotification:friday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send active bid notification to admin on every friday at 5pm via email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       
        $this->sendActiveBidNotification();
    }

    private function sendActiveBidNotification()
    {
        //\Log::info("Cron is starting fine!",date('Y-m-d H:i:s'));
        $bids = Bid::select(['bid_code', 'bid_name', 'commodity_id','publish_on','valid_till', 'created_at'])->active()->get();

        if($bids->count() > 0)
        {
            //\Log::info("Cron is executing fine!",date('Y-m-d H:i:s'));
            Mail::to(config('common.superAdminEmail'))->send(new SendBidNotificationEmail($bids));
            if (Mail::failures()) {
                return false;
            } else {
                return true;
            }
        }
        \Log::info("Cron is working fine!" . date('Y-m-d H:i:s'));
        $this->info('Successfully sent bid notification email to admin.');
    }
}
