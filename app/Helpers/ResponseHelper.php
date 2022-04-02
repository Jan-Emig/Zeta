<?php

namespace App\Helpers;

class ResponseHelper {

    /**
     * Builds an basic OK response
     * @param string $ok_message
     * @param int $http_code
     * @return Response
     */
    public function sendOkResponse($ok_message = '', $http_code = 200) {
        $response_data = array(
            'message' => $ok_message,
        );
        return response($response_data, $http_code);
    }

    /**
     * Builds an basic error response
     * @param string $error_message
     * @param int $http_code
     * @return Response
     */
    public function sendErrorResponse($error_message, $http_code = 500) {
        $response_data = array(
            'message' => $error_message,
        );
        return response($response_data, $http_code);
    }

}

?>
