<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Handler;

class TodoController extends Controller
{

protected $user;

public function __construct(){
    $this->middleware('auth:api');
    $this->user = $this->guard()->user();
}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->user->todos()->get(['id','title', 'body', 'completed', 'created_by']);
        return response()->json($todos->toArray());
        if(!$todos){
            return respose()->json(['message' => 'Todo not found']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
            'completed' => 'required|boolean'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->completed = $request->completed;

        if($this->user->todos()->save($todo)){
            return response()->json([
                'message' => 'New Todo Added',
                'status' => true,
                'todo' => $todo,
            ]);
        }
        else{
            return respose()->json([
                'status' => false,
                'message' => 'Oops, the todo could not be saved.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return $todo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
            'completed' => 'required|boolean'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        
        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->completed = $request->completed;

        if($this->user->todos()->save($todo)){
            return response()->json([
                'message' => 'Todo Updated',
                'status' => true,
                'todo' => $todo,
            ]);

          
        }

        else{
            return respose()->json([
                'status' => false,
                'message' => 'Oops, the todo could not be updated.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
      if($todo->delete()){
          return response()->json([
              'message' => 'Todo Deleted',
              'status' => true,
              'todo'   => $todo,
          ]);
      }
      else{
        return respose()->json([
            'status' => false,
            'message' => 'Oops, the todo could not be deleted.'
        ]);
    } 
    }

    protected function guard(){
        return Auth::guard();

    }
}
