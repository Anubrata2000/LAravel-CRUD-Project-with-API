<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return response()->json(['todos' => $todos]);
    }

    public function show($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        return response()->json(['todo' => $todo]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $todo = Todo::create($request->all());

        return response()->json(['todo' => $todo], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        $todo->update($request->all());

        return response()->json(['todo' => $todo]);
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully']);
    }
}
