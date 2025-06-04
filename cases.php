<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$dir = __DIR__ . '/images';
$files = [];
if (is_dir($dir)) {
    foreach (scandir($dir) as $file) {
        if (is_file($dir . '/' . $file) && preg_match('/\.(svg|png)$/i', $file)) {
            $files[] = $file;
        }
    }
}
header('Content-Type: application/json');
echo json_encode($files);
echo '\n<pre>' . htmlspecialchars(print_r($files, true)) . '</pre>';
