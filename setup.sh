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

# Try to guess domain automatically if none provided
read -p "Введите домен (оставьте пустым для локального): " DOMAIN
if [ -z "$DOMAIN" ]; then
    if hostname -I >/dev/null 2>&1; then
        DOMAIN=$(hostname -I | awk '{print $1}')
    elif command -v ipconfig >/dev/null; then
        DOMAIN=$(ipconfig getifaddr en0 2>/dev/null || true)
    fi
    DOMAIN=${DOMAIN:-127.0.0.1}
    echo "Определён локальный адрес: $DOMAIN"
fi

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
=======
if [ ! -f "$CONFIG_FILE" ]; then
    cp "$SAMPLE_FILE" "$CONFIG_FILE"
    echo "Создан $CONFIG_FILE. Откройте admin.php для настройки."
fi


echo "Запускаем сервер на http://$DOMAIN:8000"
php -S 0.0.0.0:8000 &
PID=$!
echo "Нажмите Ctrl+C чтобы остановить сервер"
wait $PID
