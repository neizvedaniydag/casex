<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/style.css">
    <title>ExchangeCases</title>
</head>
<body>
<h1>Обмен кейсов на скины</h1>
<?php if(!isset($_SESSION['steamid'])): ?>
    <a href="login.php">Войти через Steam</a>
<?php else: ?>
    <p>Вы вошли как <?php echo htmlspecialchars($_SESSION['steamid']); ?></p>
    <a href="inventory.php">Открыть инвентарь</a> |
    <a href="logout.php">Выйти</a>
<?php endif; ?>
</body>
</html>
