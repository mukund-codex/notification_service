<?php

namespace App\Helpers;

use DB;
use App\Models\NotificationLogModel;
use App\Helpers\Curl;

class Notification{

    /**
   * Gets Result Array with Key (Register Ids) <=> Value (Notification Result) Pair
   * @param register_ids[] Registration Ids  List Of Registration Ids
   * @param notification_result Result Json registration result
   * 
   * @return registration_result[] Registration with result
   */
    public static function get_notification_status($register_ids,$notification_json_result){
        $notification_result = json_decode($notification_json_result,TRUE);
        if(count($notification_result) < 0 || !is_array($notification_result)){ return; }
        $keys1  = [];
        foreach ($notification_result["results"] as $key => $value) {
            if(array_key_exists("error", $value) || array_key_exists("message_id",$value)){
                foreach ($value as $k1 => $v1) {
                    array_push($keys1,$v1);
                }
            }
        }   
        return array_combine($register_ids,$keys1);
    }

    public static function send_notification($request_id, $request_data){      
        
        $request_data = json_decode($request_data);
        
        $server_key = $request_data->server_key;
        $title = $request_data->title;
        $desc = $request_data->description;
        $image = $request_data->image;
        $pdf_file = $request_data->pdf_file;
        $ppt_file = $request_data->ppt_file;
        $video_file = $request_data->video_file;
        $device_info = $request_data->device_info;
        $android_ids = [];
        $ios_ids = [];
        
        //\dd("Devices", $device_info);

        $fields = [];

        $device_ids = array_column($request_data->device_info, 'device_id');

        foreach($device_info as $device){
            if(strtolower($device->device_type) == 'android'){
                array_push($android_ids, $device->device_id);                
            }
            if(strtolower($device->device_type) == 'ios'){
                array_push($ios_ids, $device->device_id);                
            }
        }

        $register_ids = array_merge($android_ids, $ios_ids);

        //$notification_data = $request_data;
        
        $notification_data = array(
            'title'           => $title,  
            "body"            => $desc, 
            'image'           => $image,
            'pdf_file'        => $pdf_file,
            'ppt_file'        => $ppt_file,
            'video_file'      => $video_file,
            );
        
        $fields['registration_ids'] = (array)$register_ids;
        $fields['data'] = $notification_data;
        //$fields['priority'] = 'high';
        //$fields['notification'] = $notification_data;
        $fields['mutable_content'] = TRUE;
        $fields['content_available'] = TRUE;    
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array('Authorization: key='.$server_key,'Content-Type: application/json');

        $result = Curl::curl_request($headers, $url, $fields);

        $registration_log_ids = Notification::get_notification_status((array)$device_ids,$result);
                
        $logData = new NotificationLogModel();

        $logData->request_id = $request_id;
        $logData->response = json_encode($registration_log_ids);
        $logData->save();

        return $registration_log_ids; //response()->json(['status' => 'Success', 'message' => '', 'data' => $registration_log_ids ]);

    }

}


?>