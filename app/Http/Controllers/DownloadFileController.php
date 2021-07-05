<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Exceptions\Handler;

class DownloadFileController extends Controller
{
    protected $user;

    public function __construct(){
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
        
    }

    public function downloadfile(Request $request){

        $validator = Validator::make($request->all(), [
            'file' => 'max:5120', //5MB 
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

    if(!$request->input('file')) {
    return response()->json(['File Not Found To Be Downloaded, The File You Requested Does Not Availabel'], 400);
        }

        $filename = $request->input('file');
     
        $path = public_path('/uploads/'.$filename);
     
        return response()->download($path);
        
     }

     protected function guard(){
        return Auth::guard();
    }

}
