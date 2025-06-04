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
$url = "https://steamcommunity.com/inventory/{$steamid}/730/2?l=russian&count=5000";

$ch = curl_init($url);
// Request gzip content and let cURL decode it automatically
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
curl_setopt($ch, CURLOPT_ENCODING, '');
$response = curl_exec($ch);
$curlError = null;
if($response === false) {
    $curlError = curl_error($ch);
}
curl_close($ch);

$inventory = json_decode($response, true);
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
