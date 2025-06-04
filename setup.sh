#!/usr/bin/env bash
set -e

CONFIG_FILE="config.php"
SAMPLE_FILE="config.sample.php"

# Detect OS for package manager
if [ -f /etc/os-release ]; then
    . /etc/os-release
    OS=$ID
else
    OS="unknown"
fi

install_php() {
    if command -v php >/dev/null; then
        return
    fi
    case "$OS" in
        ubuntu|debian)
            sudo apt-get update && sudo apt-get install -y php php-curl || true
            ;;
        centos|fedora|rhel)
            sudo yum install -y php php-cli php-curl || sudo dnf install -y php php-cli php-curl || true
            ;;
        *)
            echo "Не удалось определить пакетный менеджер. Установите PHP вручную.";
            ;;
    esac
}

install_php

read -p "Введите Steam API Key: " API_KEY
read -p "Введите домен (example.com): " DOMAIN
read -p "Задайте пароль для админки: " ADMIN_PASS

cat > "$CONFIG_FILE" <<CFG
<?php
return [
    'STEAM_API_KEY' => '$API_KEY',
    'DOMAIN' => '$DOMAIN',
    'ADMIN_PASSWORD' => '$ADMIN_PASS'
];
CFG

echo "Конфигурация сохранена в $CONFIG_FILE"

echo "Запускаем локальный сервер на http://localhost:8000"
php -S localhost:8000 &
PID=$!
echo "Нажмите Ctrl+C чтобы остановить сервер"
wait $PID
