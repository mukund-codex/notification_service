<?php

namespace App\Jobs;

use DB;
use App\Models\NotificationLogModel;
use App\Models\NotificationRequestModel;
use Illuminate\Support\Facades\Log;
use App\Helpers;

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
        $request_record = NotificationRequestModel::find(['id' => $this->ids, 'status' => 'success'])->first();

        $data['request_id'] = $request_id = $request_record->request_id;
        $data['uid'] = $uid = $request_record->uid;
        $data['device_id'] = $device_id = $request_record->device_id;
        $data['device_type'] = $device_type = $request_record->device_type;
        $data['title'] = $title = $request_record->title;
        $description = $request_record->description;
        $image = $request_record->image;
        $pdf_file = $request_record->pdf_file;
        $ppt_file = $request_record->ppt_file;
        $video_file = $request_record->video_file;
        $file_type = $request_record->file_type;
        $data['callback'] = $callback = $request_record->callback;

        //Notification Logic

        $requestNotification = Notification::send_notification($request_id, $uid, $device_id, $device_type, $title, $description, $image, $pdf_file, $ppt_file, $video_file, $callback);

        \dd($requestNotification);

    }
}
