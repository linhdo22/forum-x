<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION) || !isset($_SESSION['user'])) {
    header('Location: ./login/login.php');
}

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

$user = $_SESSION['user'];
$secret = "secret";
$headers = ['alg' => 'HS256', 'typ' => 'JWT'];
$headers_encoded = base64url_encode(json_encode($headers));
// echo $headers_encoded;
$payload = ['name' => $user['name'], "id" => $user['member_id']];
$payload_encoded = base64url_encode(json_encode($payload));
// echo $payload_encoded;

$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
$signature_encoded = base64url_encode($signature);
// echo $signature;
$token = "$headers_encoded.$payload_encoded.$signature_encoded";
echo $token;
