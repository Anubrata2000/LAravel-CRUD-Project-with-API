<?php

namespace App\Http\Services;

use App\Models\Todo;

class TodoService {
    protected $todo;

    public function __construct() {
        $this->todo = new Todo();
    }

    public function getAllTodos() {
        return $this->todo->all();
    }

    public function getTodoById( $id ) {
        return $this->todo->where( 'id', $id )->first();
    }

    public function createTodo( $data ) {
        return $this->todo->create( $data );
    }

    public function updateTodo( $id, $data ) {
        $todo = $this->todo->where( 'id', $id )->first();
        if ( $todo ) {
            $todo->update( $data );
        }
        return $todo;
    }

    public function deleteTodo( $id ) {
        $todo = $this->todo->where( 'id', $id )->first();
        if ( $todo ) {
            $todo->delete();
        }
        return $todo;
    }
}