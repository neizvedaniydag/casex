<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$action = $_GET['action'] ?? '';
if($action === 'logout') {
    unset($_SESSION['admin']);
    header('Location: admin.php');
    exit;
}
$configFile = 'config.php';
if (file_exists($configFile)) {
    $config = require $configFile;
} else {
    $config = require 'config.sample.php';
}

// handle login
if (!isset($_SESSION['admin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pass = $_POST['password'] ?? '';
        if ($pass === ($config['ADMIN_PASSWORD'] ?? '')) {
            $_SESSION['admin'] = true;
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Неверный пароль';
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Админ вход</title>
    </head>
    <body>
    <h1>Вход в админ-панель</h1>
    <?php
        if(isset($error)) {
            echo "<p style='color:red'>$error</p>";
            echo '<pre>' . htmlspecialchars(print_r($_POST, true)) . '</pre>';
        }
    ?>
    <form method="post">
        <input type="password" name="password" placeholder="Пароль">
        <button type="submit">Войти</button>
    </form>
    </body>
    </html>
    <?php
    return;
}

// handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config['STEAM_API_KEY'] = $_POST['STEAM_API_KEY'] ?? $config['STEAM_API_KEY'];
    $config['DOMAIN'] = $_POST['DOMAIN'] ?? $config['DOMAIN'];
    if (!empty($_POST['ADMIN_PASSWORD'])) {
        $config['ADMIN_PASSWORD'] = $_POST['ADMIN_PASSWORD'];
    }
    $export = "<?php\nreturn " . var_export($config, true) . ";\n";
    file_put_contents($configFile, $export);
    $message = 'Конфигурация сохранена';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
</head>
<body>
<h1>Настройки</h1>
<?php
    if(isset($message)) {
        echo "<p style='color:green'>$message</p>";
        echo '<pre>' . htmlspecialchars(print_r($config, true)) . '</pre>';
    }
?>
<form method="post">
    <label>Steam API Key:
        <input type="text" name="STEAM_API_KEY" value="<?php echo htmlspecialchars($config['STEAM_API_KEY']); ?>">
    </label><br>
    <label>Домен:
        <input type="text" name="DOMAIN" value="<?php echo htmlspecialchars($config['DOMAIN']); ?>">
    </label><br>
    <label>Новый пароль:
        <input type="password" name="ADMIN_PASSWORD" placeholder="Не менять">
    </label><br>
    <button type="submit">Сохранить</button>
</form>
<p>
    <a href="index.php">На главную</a> |
    <a href="admin.php?action=logout">Выйти</a>
</p>
</body>
</html>
