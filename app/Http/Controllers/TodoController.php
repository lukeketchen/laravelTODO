<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth('sanctum')->user();
        return Todo::where('user_id',$user->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth('sanctum')->user();
        $todo = new Todo();
        $todo->name = $request->name;
        $todo->user_id = $user->id;
        $todo->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $todoId)
    {
        
        $todo = Todo::find($todoId);

        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($todoId)
    {
        Todo::find($todoId)->delete();
    }
}
