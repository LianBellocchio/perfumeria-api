<?php
require_once 'libs/jwt.php';

class AuthController {
    public function login() {
        $username = "usuario_de_prueba";  
        $user_id = 1;  
        
        // Crear el payload para el token
        $payload = [
            "exp" => time() + 3600,
            "user_id" => $user_id,
            "username" => $username
        ];

        // Generar el token
        $token = createJWT($payload);
        echo json_encode(["token" => $token]);
    }
    
}
?>
