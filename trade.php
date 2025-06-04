<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(!isset($_SESSION['steamid'])) {
    header('Location: login.php');
    exit;
}

// Placeholder logic for calculating trade with 30% margin
$userItems = $_POST['items'] ?? [];
if(empty($userItems)) {
    echo json_encode(['error' => 'No items selected']);
    exit;
}

// Pretend each case costs 1 unit
$totalValue = count($userItems);
// 30% profit means we give back items worth 70% of user value
$botValue = $totalValue * 0.7;

// This is where you'd select skins from the bot inventory worth <= $botValue
// and create a trade offer via your backend.

$result = [
    'receivedValue' => $botValue,
    'status' => 'offer_created'
];

header('Content-Type: application/json');
echo json_encode($result);
echo '\n<pre>' . htmlspecialchars(print_r($_POST, true)) . '</pre>';
