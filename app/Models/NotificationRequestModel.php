<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class NotificationRequestModel extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'notification_request';
    protected $fillable = ['request_id', 'uid', 'device_id', 'device_type', 'title', 'description', 'image', 'pdf_file', 'ppt_file', 'video_file', 'file_type', 'callback', 'download_status', 'request_status'];
}
