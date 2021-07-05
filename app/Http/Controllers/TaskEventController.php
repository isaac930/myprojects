<?php

namespace App\Http\Controllers;

use App\Events\TaskEvent;
use Illuminate\Http\Request;

class TaskEventController extends Controller
{
    public function gettaskevent(){
        event(new TaskEvent('Hello Kirumira Isaac the event together with the listener works'));
    }
}
