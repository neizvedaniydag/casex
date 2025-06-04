<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['steamid'])) {
    header('Location: login.php');
    exit;
}

$config = require 'config.php';
$steamid = $_SESSION['steamid'];
$apiKey = $config['STEAM_API_KEY']; // ✅ НЕ МЕНЯЕМ, как ты просил

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

// ⚡ Переход на стабильный API от Steamwebapi
$usedUrl = "https://www.steamwebapi.com/steam/api/inventory?key={$apiKey}&steam_id={$steamid}";
$response = fetch_url($usedUrl, $info, $curlError);
$inventory = json_decode($response, true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ваш инвентарь</title>
</head>
<body>
<h1>Ваш инвентарь</h1>
<a href="logout.php">Выйти</a>
<div id="items">
<?php
if (is_array($inventory)) {
    foreach ($inventory as $item) {
        $name = $item['markethashname'] ?? 'Неизвестный предмет';
        echo '<div>' . htmlspecialchars($name) . '</div>';
    }
} else {
    echo '<p>Не удалось загрузить инвентарь.</p>';
    if ($info) {
        echo '<pre>HTTP code: ' . $info['http_code'] . '</pre>';
        echo '<pre>' . htmlspecialchars(print_r($info, true)) . '</pre>';
    }
    if ($curlError) {
        echo '<p style="color:red">' . htmlspecialchars($curlError) . '</p>';
    }
    echo '<pre>JSON error: ' . json_last_error_msg() . '</pre>';
    echo '<pre>URL: ' . htmlspecialchars($usedUrl) . '</pre>';
    echo '<pre>Response snippet: ' . htmlspecialchars(substr($response, 0, 500)) . '</pre>';
    echo '<pre>SESSION: ' . htmlspecialchars(print_r($_SESSION, true)) . '</pre>';
}
?>
</div>
</body>
</html>
