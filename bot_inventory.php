<?php
$config = require 'config.php';
$steamid = $config['BOT_STEAM_ID'] ?? null;
if (!$steamid) {
    http_response_code(500);
    echo json_encode(['error' => 'BOT_STEAM_ID not set']);
    return;
}
$url = "https://steamcommunity.com/inventory/{$steamid}/730/2?l=russian&count=5000";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$response = curl_exec($ch);
$err = null;
if ($response === false) {
    $err = curl_error($ch);
}
curl_close($ch);
if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => $err]);
    return;
}
header('Content-Type: application/json');
echo $response;
