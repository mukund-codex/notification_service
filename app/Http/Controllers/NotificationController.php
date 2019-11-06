<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationRequestModel;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Classes\ErrorsClass;
use App\Events\NotificationEvent;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        
        $requestData = new NotificationRequestModel();

        $requestData->request_id = $request_id = $this->random_num(12);
        $requests = $request->input('request');
        $requestData->request = json_encode($request->input('request'));

        //\dd($requests['device_info']);
        if(empty($requests)){
            $requestData->response = json_encode([
                "status" => 'fail',
                "error" => 'Empty Request Data'
            ]);

            $requestData->save();

            return response()->json(['status' => 'Fail', 'message' => 'Empty Request Data', 'data' => ['request_id' => $request_id]]);
        }

        if(!array_key_exists('title', $requests)){
            $requestData->response = json_encode([
                "status" => 'fail',
                "error" => 'Empty Title'
            ]);

            $requestData->save();

            return response()->json(['status' => 'Fail', 'message' => 'Empty Title', 'data' => ['request_id' => $request_id]]);
        }

        if(!array_key_exists('server_key', $requests)){
            $requestData->response = json_encode([
                "status" => 'fail',
                "error" => 'Empty Server Key'
            ]);

            $requestData->save();

            return response()->json(['status' => 'Fail', 'message' => 'Empty Server Key', 'data' => ['request_id' => $request_id]]);
        }

        if(!array_key_exists('uid', $requests)){
            $requestData->response = json_encode([
                "status" => 'fail',
                "error" => 'Empty Unique ID(uid)'
            ]);           
            $requestData->save();

            return response()->json(['status' => 'Fail', 'message' => 'Empty Unique ID(uid)', 'data' => ['request_id' => $request_id]]);
        }

        $requestData->response = json_encode([
            "status" => 'success'
        ]);
        
        $requestData->save();
        //\dd($requestData->id);
        event(new NotificationEvent($requestData->id));

    }

    public function random_num($size) {
        $alpha_key = '';
        $keys = range('A', 'Z');
        
        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }
        
        $length = $size - 2;
        
        $key = '';
        $keys = range(0, 9);
        
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        
        return $alpha_key . $key;
    }

}
