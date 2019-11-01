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
        $requestData->uid = $uid = $request->input('uid');
        $requestData->device_id = $device_id = $request->input('device_id');
        $requestData->device_type = $device_type = $request->input('device_type');
        $requestData->title = $title = $request->input('title');
        $requestData->description = $description = $request->input('description');
        $requestData->image = $image = $request->input('image');
        $requestData->pdf_file = $pdf_file = $request->input('pdf_file');
        $requestData->ppt_file = $ppt_file = $request->input('ppt_file');
        $requestData->video_file = $video_file = $request->input('video_file');
        $requestData->file_type = $file_type = $request->input('file_type');
        $requestData->callback = $callback = $request->input('callback');

        if(empty($device_id)){
            $requestData->status = 'fail';
            $requestData->error = 'Empty Mobile Number';

            $requestData->save();

            return response()->json(['status' => 'Fail', 'message' => 'Empty Device ID', 'data' => ['request_id' => $request_id, 'uid' => $uid] ]);
        }

        if(empty($device_type)){
            $requestData->status = 'fail';
            $requestData->error = 'Empty Device Type';

            $requestData->save();

            return response()->json(['status' => 'Fail', 'message' => 'Empty Device Type', 'data' => ['request_id' => $request_id, 'uid' => $uid] ]);
        }

        if(empty($title)){
            $requestData->status = 'fail';
            $requestData->error = 'Empty Title';

            $requestData->save();

            return response()->json(['status' => 'Fail', 'message' => 'Empty Title', 'data' => ['request_id' => $request_id, 'uid' => $uid] ]);
        }

        if(empty($callback)){
            $requestData->status = 'fail';
            $requestData->error = 'Empty Callback URL';

            $requestData->save();

            return response()->json(['status' => 'Fail', 'message' => 'Empty Callback URL', 'data' => ['request_id' => $request_id, 'uid' => $uid] ]);
        }

        $requestData->status = 'success';

        $requestData->save();

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
