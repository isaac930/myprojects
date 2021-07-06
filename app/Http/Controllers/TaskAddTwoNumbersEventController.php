<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TaskAddTwoNumbersEvent;

class TaskAddTwoNumbersEventController extends Controller
{
    public function addnumbers(Request $request){
        $number1 = $request->number1;
        $number2 = $request->number2;
        $sum = $number1 + $number2;

        event(new TaskAddTwoNumbersEvent($sum));
    }
}
