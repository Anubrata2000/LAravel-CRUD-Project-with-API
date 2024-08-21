<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller {
    protected $user;

    public function __construct() {
        $this->middleware( 'auth' );
        $this->user = new User();
    }

    /**
     * Display a listing of the users.
     */
    public function index() {
        $users = $this->user->paginate( 10 );

        return renderJsonResponse(
            trans( 'message.user.users_retrieved_successfully' ),
            Response::HTTP_OK,
            $users
        );
    }

    /**
     * Store a newly created user in storage.
     */
    public function store( UserRequest $request ) {
        $user = $this->user->create( [
            'name'     => $request->input( 'name' ),
            'email'    => $request->input( 'email' ),
            'password' => bcrypt( $request->input( 'password' ) ),
        ] );

        return renderJsonResponse(
            trans( 'message.user.created_successfully' ),
            Response::HTTP_CREATED,
            $user
        );
    }

    /**
     * Display the specified user.
     */
    public function show( $id ) {
        $user = $this->user->find( $id );

        if ( !$user ) {
            return renderJsonResponse(
                trans( 'message.user.not_found' ),
                Response::HTTP_NOT_FOUND
            );
        }

        return renderJsonResponse(
            trans( 'message.user.retrieved_successfully' ),
            Response::HTTP_OK,
            $user
        );
    }

    /**
     * Update the specified user in storage.
     */
    public function update( UserRequest $request, $id ) {
        $user = $this->user->find( $id );

        if ( !$user ) {
            return renderJsonResponse(
                trans( 'message.user.not_found' ),
                Response::HTTP_NOT_FOUND
            );
        }

        $user->update( [
            'name'     => $request->input( 'name' ),
            'email'    => $request->input( 'email' ),
            'password' => $request->has( 'password' ) ? bcrypt( $request->input( 'password' ) ) : $user->password,
        ] );

        return renderJsonResponse(
            trans( 'message.user.updated_successfully' ),
            Response::HTTP_OK,
            $user
        );
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy( $id ) {
        $user = $this->user->find( $id );

        if ( !$user ) {
            return renderJsonResponse(
                trans( 'message.user.not_found' ),
                Response::HTTP_NOT_FOUND
            );
        }

        $user->delete();

        return renderJsonResponse(
            trans( 'message.user.deleted_successfully' ),
            Response::HTTP_OK
        );
    }
}
