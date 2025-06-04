<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(!isset($_SESSION['steamid'])) {
    header('Location: login.php');
    exit;
}

$config = require 'config.php';
$steamid = $_SESSION['steamid'];

function fetch_url($url, &$info, &$error) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_ENCODING, '');
    $body = curl_exec($ch);
    $info = curl_getinfo($ch);
    $error = null;
    if ($body === false) {
        $error = curl_error($ch);
    }
    curl_close($ch);
    return $body;
}

$publicUrl = "https://steamcommunity.com/inventory/{$steamid}/730/2?l=russian&count=5000";
$response = fetch_url($publicUrl, $info, $curlError);
$inventory = json_decode($response, true);

if ($info['http_code'] !== 200 || !isset($inventory['descriptions'])) {
    $apiKey = $config['STEAM_API_KEY'] ?? '';
    if ($apiKey && $apiKey !== 'YOUR_STEAM_API_KEY') {
        $apiUrl = "https://api.steampowered.com/IEconItems_730/GetPlayerItems/v1/?key={$apiKey}&steamid={$steamid}";
        $response = fetch_url($apiUrl, $info, $curlError);
        $data = json_decode($response, true);
        if (isset($data['result']['status']) && $data['result']['status'] == 1) {
            $inventory = ['descriptions' => []];
            foreach ($data['result']['items'] as $item) {
                $inventory['descriptions'][] = ['market_hash_name' => $item['name'] ?? ''];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
</head>
<body>
<h1>Ваш инвентарь</h1>
<a href="logout.php">Выйти</a>
<div id="items">
<?php
if(isset($inventory['descriptions'])) {
    foreach($inventory['descriptions'] as $item) {
        $name = $item['market_hash_name'];
        echo '<div>' . htmlspecialchars($name) . '</div>';
    }
} else {
    echo '<p>Не удалось загрузить инвентарь.</p>';
    if($info) {
        echo '<pre>HTTP code: ' . $info['http_code'] . '</pre>';
    }
    if($curlError) {
        echo '<p style="color:red">' . htmlspecialchars($curlError) . '</p>';
    }
    echo '<pre>JSON error: ' . json_last_error_msg() . '</pre>';
    echo '<pre>Response snippet: ' . htmlspecialchars(substr($response, 0, 200)) . '</pre>';
}
?>
</div>
</body>
</html>
