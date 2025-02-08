<?php
// AuthMiddleware.php only for testing purposes

class Authentication {

    public function before() {
        $headers = Flight::request()->getHeaders();
        $error = '';
        if (!isset($headers['Authorization'])) {
            $error =  "Authorization header is missing";
        } else {
            if (substr($headers['Authorization'], 0, 7) !== 'Bearer ') {
                $error = "Bearer keyword is missing";
            } else {
                $token = trim(substr($headers['Authorization'], 7));
                if ($token !== 'secret') {
                    $error = "Invalid token";
                }
            }
        }

        if ($error !== '') {
            Flight::jsonHalt([ 'message' => $error ], 401);
        } else {
            return true;
        }
    }
}