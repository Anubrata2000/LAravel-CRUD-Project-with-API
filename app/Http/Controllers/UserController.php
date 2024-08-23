<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller {
    protected $user;

    public function __construct() {
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
            'name'              => $request->input( 'name' ),
            'email'             => $request->input( 'email' ),
            'password'          => bcrypt( $request->input( 'password' ) ),
            'email_verified_at' => Carbon::now(),
        ] );

        return renderJsonResponse(
            trans( 'message.user.created_successfully' ),
            Response::HTTP_CREATED,
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

    /**
     * Login the user and return a token.
     */
    public function login( LoginRequest $request ) {
        $credentials = $request->only( 'email', 'password' );

        if ( Auth::attempt( $credentials ) ) {
            $user = Auth::user();
            $token = $user->createToken( 'authToken' )->plainTextToken;

            return renderJsonResponse(
                trans( 'message.user.login_successful' ),
                Response::HTTP_OK,
                [
                    'token' => $token,
                    'user'  => $user,
                ]
            );
        }

        return renderJsonResponse(
            trans( 'message.user.login_failed' ),
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Log the user out and invalidate the token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        // Get the currently authenticated user
        $user = Auth::user();

        // Revoke the user's current token
        $user->tokens()->delete();

        return renderJsonResponse(
            trans( 'message.user.logout_successful' ),
            Response::HTTP_OK
        );
    }

}