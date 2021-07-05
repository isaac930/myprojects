<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;

 
class MultipleUploadController extends Controller
{
  protected $user;

  public function __construct(){
      $this->middleware('auth:api');
      $this->user = $this->guard()->user();
  }
 
public function upload(Request $request)
{
  $validator = Validator::make($request->all(), [
    'file' => 'max:5120', //5MB 
]);

if($validator->fails()){
  return response()->json([
      'errors' => $validator->errors()
  ], 400);
}

  if(!$request->hasFile('file')) {
    return response()->json(['Upload_file(s)_not_found, You Must Upload A File(s)'], 400);
}

$images = $request->file('file');
$imageName = '';

$allowedfileExtension=['pdf','jpg','png'];

foreach($images as $image){

  $extension = $image->getClientOriginalExtension();

  $check = in_array($extension,$allowedfileExtension);

  if($check) {
  foreach($request->file as $mediaFiles) {
  $new_name = rand().'.'.$image->getClientOriginalExtension();
  $path = $mediaFiles->move(public_path('/uploads/'),$new_name);
  
  $employee = new Employee;
  $employee->name = $request->name;
  $employee->email = $request->email;
  $employee->image_path = $new_name;
  $results = $employee->save();

  $imagedb = $imageName;
    }
return response()->json(['Message' => 'Files Uploaded Successfully']);

  }
else {
return response()->json(['invalid_file_format'], 422);
}


}

}



protected function guard(){
  return Auth::guard();
}

}
