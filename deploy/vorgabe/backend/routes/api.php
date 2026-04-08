<?php

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/todos', function(){
    $todos = Todo::all();
    return response()->json($todos);
});

Route::put('/todos', function(Request $request){
    $todo = new Todo();
    $todo->text = $request->input('text');
    $todo->save();
    return response()->json($todo);
});

Route::post('/todo/{id}', function(Request $request, $id){
    $todo = Todo::find($id);
    $todo->text = $request->input('text');
    $todo->save();
    return response()->json($todo);
});

Route::delete('/todo/{id}', function(Request $request, $id){
    $todo = Todo::find($id);
    $todo->delete();
    return response()->json($todo);
});







