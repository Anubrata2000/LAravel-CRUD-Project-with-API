<?php
/**
 * Formatting json result
 * @param type $httpStatusCode
 * @param type $data
 * @param type $message
 * @param type $http_response only sent when exception is thrown
 * @return type
 */
function renderJSONResponse( $message, $httpStatusCode, $data = null ) {

    $response = [];

    if ( !is_null( $data ) ) {
        $response['data'] = $data;
    }

    $response['message'] = $message;
    $response['status_code'] = $httpStatusCode;

    return response()->json( $response, $httpStatusCode );
}