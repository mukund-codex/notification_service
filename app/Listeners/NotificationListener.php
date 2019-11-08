<?php

namespace App\Listeners;

use App\Events\NotificationEvent;
use App\Jobs\NotificationSender; 
use Illuminate\Support\Facades\Log;

class NotificationListener
{   
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationEvent  $event
     * @return void
     */
    public function handle(NotificationEvent $event)
    {
        //
        $id = $event->id;
        if(!empty($id)){
            \dispatch(new NotificationSender($id));
            Log::info('Listener - Request ID: '.$id);
        }
    }
}
