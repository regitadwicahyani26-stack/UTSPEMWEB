<?php

header("Content-Type: application/json");

$url = "https://webapi.bps.go.id/v1/api/list/domain/lang/ind/key/c8909a4eb41f1f05b852f7170f919a6d";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER => [
        "User-Agent: Mozilla/5.0"
    ]
]);

$response = curl_exec($curl);

if(curl_errno($curl)){
    echo json_encode([
        "error"=>curl_error($curl)
    ]);
    exit;
}

curl_close($curl);

$data = json_decode($response, true);

// ambil bagian domain (wilayah)
if(isset($data['data'][1])){
    echo json_encode([
        "data"=>$data['data'][1]
    ]);
}else{
    echo json_encode([
        "data"=>[]
    ]);
}
?>