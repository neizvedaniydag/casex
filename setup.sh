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

if [ ! -f "$CONFIG_FILE" ]; then
    cp "$SAMPLE_FILE" "$CONFIG_FILE"
    echo "Создан $CONFIG_FILE. Откройте admin.php для настройки."
fi

echo "Запускаем локальный сервер на http://localhost:8000"
php -S localhost:8000 &
PID=$!
echo "Нажмите Ctrl+C чтобы остановить сервер"
wait $PID
