<?php

use App\Http\Controllers\UserController;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/todos', function () {
    $todos = Todo::all();
    return response()->json($todos);
});

Route::middleware('auth:sanctum')->put('/todos', function (Request $request) {
    $todo = new Todo();
    $todo->text = $request->input('text');
    $todo->save();
    return response()->json($todo);
});

Route::middleware('auth:sanctum')->post('/todo/{id}', function (Request $request, $id) {
    $todo = Todo::find($id);
    $todo->text = $request->input('text');
    $todo->save();
    return response()->json($todo);
});

Route::middleware('auth:sanctum')->delete('/todo/{id}', function (Request $request, $id) {
    $todo = Todo::find($id);
    $todo->delete();
    return response()->json($todo);
});

Route::put('/users', [UserController::class, 'register']);

Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->post('/auth/logout', [UserController::class, 'logout']);
