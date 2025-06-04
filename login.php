<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'openid.php';
$config = require 'config.php';
$openid = new LightOpenID($config['DOMAIN']);
if(!$openid->mode){
    $openid->identity = 'https://steamcommunity.com/openid';
    header('Location: ' . $openid->authUrl());
} elseif($openid->mode == 'cancel') {
    echo 'Login cancelled';
} else {
    if($openid->validate()) {
        $id = $openid->identity;
        $matches = array();
        preg_match('/\/(\d+)$/', $id, $matches);
        $_SESSION['steamid'] = $matches[1];
        header('Location: inventory.php');
    } else {
        echo 'Failed to authenticate';
        echo '<pre>' . htmlspecialchars(print_r($_GET, true)) . '</pre>';
        echo '<pre>SERVER: ' . htmlspecialchars(print_r($_SERVER, true)) . '</pre>';
    }
}
