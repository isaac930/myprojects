<?php

namespace App\Http\Controllers;

use Throwable;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;


class SmsController extends Controller
{

public function sendsms(Request $request){


    $from = $request->from;
    $to = $request->to;
    $sms = $request->sms;

    Nexmo::message()->send([
        'to' => $to,
        'from' => $from,
        'text' => $sms
    ]);

    return response()->json(['message' => 'Message has been sent']); 

}
}
