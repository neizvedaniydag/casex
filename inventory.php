<?php
session_start();
if(!isset($_SESSION['steamid'])) {
    header('Location: login.php');
    exit;
}

$config = require 'config.php';
$steamid = $_SESSION['steamid'];
$url = "https://steamcommunity.com/inventory/{$steamid}/730/2?l=russian&count=5000";
$response = file_get_contents($url);
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
}
?>
</div>
</body>
</html>
