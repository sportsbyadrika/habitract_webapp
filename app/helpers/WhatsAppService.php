<?php

require_once __DIR__ . '/json_helper.php';
class WhatsAppService
{
    private string $apiKey;
    private string $apiUrl;

   public function __construct()
{
    $chatico = require __DIR__ . '/../../config/chatico.php';

    if (
        empty($chatico['api_key']) ||
        empty($chatico['api_url'])
    ) {
        throw new Exception('Chatico WhatsApp config missing');
    }

    $this->apiKey = $chatico['api_key'];
    $this->apiUrl = rtrim($chatico['api_url'], '/');
}
   public function sendWhatsAppCampaign(array $payload): array
{
   $ch = curl_init($this->apiUrl);
$payload['apiKey'] = $this->apiKey;
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode($payload),
]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

   if (curl_errno($ch)) {
    return [
        'success' => false,
        'error'   => curl_error($ch)
    ];
}
file_put_contents(
    __DIR__ . '/../../logs/chatico_debug.log',
    date('Y-m-d H:i:s') .
    "\nHTTP CODE: $httpCode\nRESPONSE:\n$response\n\n",
    FILE_APPEND
);
   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

/* ✅ JSON validation */
$json = decodeJsonSafely($response);

if (!$json['valid']) {
    return [
        'success' => false,
        'error'   => 'Invalid JSON from Chatico',
        'details' => $json
    ];
}
return [
    'success' => true,
    'data'    => $json['data']
];
}
}
