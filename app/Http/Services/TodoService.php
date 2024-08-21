<?php

namespace App\Http\Services;

use App\Models\Todo;
use App\Models\UserTodo;
use Illuminate\Support\Facades\Auth;

class TodoService {
    protected $todo;

    public function __construct() {
        $this->todo = new Todo();
    }

    public function getAllTodos( $rowsPerPage = 10 ) {
        return $this->todo->paginate( $rowsPerPage );
    }

    public function getTodoById( $id ) {
        return $this->todo->find( $id );
    }

    public function createTodo( $data ) {
        // Create the todo
        $todo = $this->todo->create( $data );

        // Associate the created todo with the authenticated user in the pivot table
        UserTodo::create( [
            'user_id' => Auth::id(),
            'todo_id' => $todo->id,
        ] );

        return $todo;
    }

    public function updateTodo( $id, $data ) {
        $todo = $this->getTodoById( $id );
        if ( $todo ) {
            $todo->update( $data );
        }
        return $todo;
    }

    public function deleteTodo( $id ) {
        $todo = $this->getTodoById( $id );
        if ( $todo ) {
            // Delete related UserTodo records
            $todo->userTodos()->delete(); // Soft delete related UserTodo records
            $todo->delete();
            return true;
        }
        return false;
    }
}