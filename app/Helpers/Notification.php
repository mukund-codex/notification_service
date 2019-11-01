<?php

namespace App\Helpers;

use DB;
use App\Models\NotificationLogModel;

class Notification{

    function send_notification($request_id, $uid, $registration_ids, $device_type, $title, $desc, $image, $pdf_file, $ppt_file, $video_file, $callback){
        $url = 'https://fcm.googleapis.com/fcm/send';
  
        $fields = [];
        if($device_type) {
  
            $notification_data = array(
            'title'           => $title,  
            "body"            => $desc, 
            'image'            => $image,
            'pdf_file'        => $pdf_file,
            'ppt_file'        => $ppt_file,
            'video_file'      => $video_file,
            'date'            => $date,
            );
    
            switch (strtolower($device_type)) {
            case 'android':          
                $fields['registration_ids'] = (array)$registration_ids;
                // $fields['notification'] = $notification_data;
                $fields['data'] = $notification_data;
                $fields['priority'] = 'high';
                break;
    
            case 'ios':
                $fields['registration_ids'] = (array)$registration_ids;
                $fields['notification'] = $notification_data;
                $fields['mutable_content'] = TRUE;
                $fields['content_available'] = TRUE;
                break;
            
            default:
                return response()->json(['status' => 'Fail', 'message' => 'Empty Device Type', 'data' => ['request_id' => $request_id, 'uid' => $uid] ]);
                break;
            }
        }
  
        //  echo "<pre>";
        //  print_r($fields);exit;
            
        $headers = array('Authorization: key='.API_ACCESS_KEY,'Content-Type: application/json');
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        
        $log = 'message: ' . json_encode($fields) . ' :: response: ' . $result . PHP_EOL;
    
        if ($result === FALSE) {
            return;
        }else{
    
            //save data in notification log

            $logData = new NotificationLogModel();

            $logData->request_id = $request_id;
            $logData->uid = $uid;
            $logData->device_id = $registration_ids;
            $logData->device_type = $device_type;
            $logData->title = $title;
            $logData->callback = $callback;

            $logData->save();

            return response()->json(['status' => 'Success', 'message' => '', 'data' => ['request_id' => $request_id, 'uid' => $uid] ]);

        }
    }

}


?>