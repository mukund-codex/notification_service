<?php

namespace App\Jobs;

use DB;
use App\Models\NotificationLogModel;
use App\Models\NotificationRequestModel;
use Illuminate\Support\Facades\Log;
use App\Helpers\Notification;

class NotificationSender extends Job
{   

    public $ids;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ids)
    {
        //
        $this->ids = $ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::info('Job - Request ID: '.$this->ids);
        $data = [];
        $uid;
        $request_record = NotificationRequestModel::find(['id' => $this->ids])->first();
        
        //Notification Logic

        $request_id = $request_record->request_id;  
        $request_data = $request_record->request;
        
        $requestNotification = Notification::send_notification($request_id, $request_data);

        \dd($requestNotification);

    }
}
