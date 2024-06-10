<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Http\Services\TodoService;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller {
    protected $todoService;

    public function __construct() {
        $this->todoService = new TodoService();
    }

    public function index() {
        $todos = $this->todoService->getAllTodos();
        // return response()->json( [
        //     'message' => __( 'message.todo.todos_retrieved_successfully' ),
        //     'todos'   => $todos,
        // ] );
        return renderJsonResponse( trans( 'message.todo.todos_retrieved_successfully' ), Response::HTTP_OK );
    }

    public function show( $id ) {
        $todo = $this->todoService->getTodoById( $id );

        if ( !$todo ) {
            return response()->json( ['error' => __( 'message.todo.not_found' )], 404 );
        }

        return response()->json( [
            'message' => __( 'message.todo.retrieved_successfully' ),
            'todo'    => $todo,
        ] );
    }

    public function store( TodoRequest $request ) {
        $todo = $this->todoService->createTodo( $request->validated() );

        $response = [
            'id'          => $todo->id,
            'title'       => $todo->title,
            'description' => $todo->description,
            'updated_at'  => $todo->updated_at,
            'created_at'  => $todo->created_at,
        ];

        return response()->json( [
            'message' => __( 'message.todo.created_successfully' ),
            'todo'    => $response,
        ], 201 );
    }

    public function update( TodoRequest $request, $id ) {
        $todo = $this->todoService->getTodoById( $id );

        if ( !$todo ) {
            return response()->json( ['error' => __( 'message.todo.not_found' )], 404 );
        }

        $todo = $this->todoService->updateTodo( $id, $request->validated() );

        return response()->json( [
            'message' => __( 'message.todo.updated_successfully' ),
            'todo'    => $todo,
        ] );
    }

    public function destroy( $id ) {
        $todo = $this->todoService->getTodoById( $id );

        if ( !$todo ) {
            return response()->json( ['error' => __( 'message.todo.not_found' )], 404 );
        }

        $this->todoService->deleteTodo( $id );

        return response()->json( ['message' => __( 'message.todo.deleted_successfully' )] );
    }
}
