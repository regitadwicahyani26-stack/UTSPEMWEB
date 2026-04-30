<?php
// api/alamat.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$api_key = "c8909a4eb41f1f05b852f7170f919a6d";
$url = "https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/0000/var/2221/th/126/key/{$api_key}";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_USERAGENT      => 'Mozilla/5.0',
    CURLOPT_FOLLOWLOCATION => true,
]);

$response = curl_exec($curl);
$err      = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($err) {
    echo json_encode(["status" => "ERROR", "message" => "cURL Error: " . $err]);
    exit;
}

if ($httpCode !== 200) {
    echo json_encode(["status" => "ERROR", "message" => "HTTP Error: " . $httpCode]);
    exit;
}

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["status" => "ERROR", "message" => "Response bukan JSON valid"]);
    exit;
}

echo json_encode($data);
?>