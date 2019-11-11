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
        
        $requests = $request;//$request->input('request');
        $requestData->request = json_encode($requests);
        
        $validation = $this->validation($requests, $request_id);        
        
        $requestData->response = json_encode($validation);
        
        return response()->json(['status' => '', 'message' => $validation, 'data' => ['request_id' => $request_id]]);
        
        if($requestData->save()):
            event(new NotificationEvent($requestData->id));
        endif;

    }

    public function validation($request, $request_id){
        //\dd($request->all());
        $validator = Validator::make($request->all(), [
            'request.title' => 'required',
            'request.server_key' => 'required',
            'request.uid' => 'required',
            'request.callback' => 'required',
            'request.device_info.device_id' => 'required',
            'request.device_info.device_type' => 'required',
        ]);

        $errors = $validator->errors()->messages();
        
        $status = empty($errors) ? 'Success' : 'Fail';

        return response()->json(['status' => $status, 'message' => $errors, 'data' => ['request_id' => $request_id]]);
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
