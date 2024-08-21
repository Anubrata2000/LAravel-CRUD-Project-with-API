<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Http\Services\TodoService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller {
    protected $todoService;

    public function __construct() {
        $this->todoService = new TodoService();
    }

    public function index( Request $request ) {
        $rowsPerPage = $request->input( 'rowsPerPage', 10 ); // Default to 10 rows per page if not provided
        $todos = $this->todoService->getAllTodos( $rowsPerPage );

        return renderJsonResponse( trans( 'message.todo.todos_retrieved_successfully' ), Response::HTTP_OK, $todos );
    }

    public function show( $id ) {
        $todo = $this->todoService->getTodoById( $id );

        if ( !$todo ) {
            return renderJsonResponse( trans( 'message.todo.not_found' ), Response::HTTP_NOT_FOUND );
        }

        return renderJsonResponse( trans( 'message.todo.retrieved_successfully' ), Response::HTTP_OK, $todo );
    }

    public function store( TodoRequest $request ) {
        $todo = $this->todoService->createTodo( $request->validated() );

        return renderJsonResponse( trans( 'message.todo.created_successfully' ), Response::HTTP_CREATED, $todo );
    }

    public function update( TodoRequest $request, $id ) {
        $todo = $this->todoService->updateTodo( $id, $request->validated() );

        if ( !$todo ) {
            return renderJsonResponse( trans( 'message.todo.not_found' ), Response::HTTP_NOT_FOUND );
        }

        return renderJsonResponse( trans( 'message.todo.updated_successfully' ), Response::HTTP_OK, $todo );
    }

    public function destroy( $id ) {
        $deleted = $this->todoService->deleteTodo( $id );

        if ( !$deleted ) {
            return renderJsonResponse( trans( 'message.todo.not_found' ), Response::HTTP_NOT_FOUND );
        }

        return renderJsonResponse( trans( 'message.todo.deleted_successfully' ), Response::HTTP_OK );
    }
}
