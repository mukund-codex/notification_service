<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class NotificationRequestModel extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'notification_request';
    protected $fillable = ['request_id', 'request', 'response'];
}
