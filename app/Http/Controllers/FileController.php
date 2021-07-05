<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Exceptions\Handler;

use Exception;

class FileController extends Controller
{
    protected $user;

public function __construct(){
    $this->middleware('auth:api');
    $this->user = $this->guard()->user();
}

public function upload(Request $request){

    $validator = Validator::make($request->all(), [
        'file' => 'max:5120', //5MB 
    ]);

    if($validator->fails()){
        return response()->json([
            'errors' => $validator->errors()
        ], 400);
    }
    
    if(!$request->hasFile('file')) {
        return response()->json(['Upload_file_not_found, You Must Upload A File'], 400);
    }

    $allowedfileExtension=['pdf','jpg','png'];

    $extension = $request->file('file')->getClientOriginalExtension();

    $check = in_array($extension,$allowedfileExtension);

    if($check) {

    $image = $request->file('file');
    $new_name = rand().'.'.$image->getClientOriginalExtension();

    $image->move(public_path('/uploads/'),$new_name);

    $employee = new Employee;
    $employee->name = $request->name;
    $employee->email = $request->email;
    $employee->image_path = $new_name;
    $results = $employee->save();

    if($results){ 
    return response()->json(['message' => 'Employee created successfully', 'employee' => $employee]);
    }
   else{
    return response()->json(['message' => 'Employee creation failed']); 
   }

}

else {
    return response()->json(['invalid_file_format, only pdf,png and jpg are allowed'], 422);
}

   }

    protected function guard(){
        return Auth::guard();
    }
}
