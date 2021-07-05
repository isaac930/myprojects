<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\SignupEmail;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\SendEmailJob;

class MailController extends Controller 
{
 
    public static function  sendEmail(Request $request) {

        
        $email = $request->email;
        $name= $request->name;
        $subject= $request->subject;
        $body= $request->body;
   
        $mailData = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'body' => $body
        ];
        
        // Mail::to($email)->send(new SignupEmail($mailData));

        $job = (new SendEmailJob($email,$mailData))

                         ->delay(Carbon::now()->addSeconds(5));

                dispatch($job);          

    
        return response()->json([
            'message' => 'Email has been sent.'
        ], Response::HTTP_OK);
    }

}
