<?php
require_once 'libs/jwt.php';

class JWTAuthMiddleware {
    public function run($req, $res) {
        $auth_header = $_SERVER['HTTP_AUTHORIZATION']; // "Bearer un.token.firma"
        if (!$auth_header) {
            http_response_code(401);
            echo json_encode(["message" => "Autenticación requerida"]);
            exit();
        }

        $auth_header = explode(' ', $auth_header); // ["Bearer", "un.token.firma"]
        if (count($auth_header) != 2 || $auth_header[0] != 'Bearer') {
            http_response_code(401);
            echo json_encode(["message" => "Autenticación inválida"]);
            exit();
        }

        $jwt = $auth_header[1];
        $res->user = validateJWT($jwt);

        if (!$res->user) {
            http_response_code(401);
            echo json_encode(["message" => "Token inválido o expirado"]);
            exit();
        }
    }
}
?>
