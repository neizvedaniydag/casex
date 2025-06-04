<?php
session_start();
if(!isset($_SESSION['steamid'])) {
    header('Location: login.php');
    exit;
}

$config = require 'config.php';
$steamid = $_SESSION['steamid'];
$url = "https://steamcommunity.com/inventory/{$steamid}/730/2?l=russian&count=5000";
// Use cURL with a browser-like user agent to avoid HTTP 400/403 errors
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
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
}
?>
</div>
</body>
</html>
