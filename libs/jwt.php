<?php
function createJWT($payload) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode($payload);

    $header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $signature = hash_hmac('sha256', "$header.$payload", 'mi1secreto', true);
    $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    return "$header.$payload.$signature";
}

function validateJWT($jwt) {
    $jwt_parts = explode('.', $jwt);
    if (count($jwt_parts) !== 3) {
        return null;
    }

    [$header, $payload, $signature] = $jwt_parts;
    $valid_signature = hash_hmac('sha256', "$header.$payload", 'mi1secreto', true);
    $valid_signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($valid_signature));

    if ($signature !== $valid_signature) {
        return null;
    }

    $payload = json_decode(base64_decode($payload));
    return $payload->exp > time() ? $payload : null;
}

?>
