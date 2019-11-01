<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class NotificationLogModel extends Model
{
    //
    protected $primaryKey = 'notification_id';
    protected $table = 'notification_log';
    protected $fillable = ['request_id', 'uid', 'device_id', 'device_type', 'title', 'callback', 'status'];
}
