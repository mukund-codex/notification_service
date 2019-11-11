<?php

namespace App\Events;

use App\Models\NotificationRequestModel;
use Illuminate\Support\Facades\Log;
class NotificationEvent extends Event
{   

    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->id = $id;
        Log::info('Event - Request ID: '.$this->id);
    }
}
