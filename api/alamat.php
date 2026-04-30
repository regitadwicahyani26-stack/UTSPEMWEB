<?php

header("Content-Type: application/json");

$url="https://webapi.bps.go.id/v1/api/view/domain/0000/model/statictable/lang/ind/id/950/key/c8909a4eb41f1f05b852f7170f919a6d";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,

    // INI PENTING !!!
    CURLOPT_HTTPHEADER => [
        "User-Agent: Mozilla/5.0",
        "Accept: application/json"
    ]
]);

$response = curl_exec($curl);

if(curl_errno($curl)){
    echo json_encode([
        "error"=>curl_error($curl)
    ]);
    exit;
}

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

// cek kalau masih 403
if($httpCode == 403){
    echo json_encode([
        "error"=>"403 Forbidden - API BPS menolak request"
    ]);
    exit;
}

echo $response;
?>