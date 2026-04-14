<?php
// Test endpoint checkout/process langsung
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/checkout/process');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'subtotal' => 170000,
    'ongkir'   => 15000,
    'total'    => 185000,
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status : $httpCode\n";
echo "Response    : " . substr($resp, 0, 800) . "\n";
