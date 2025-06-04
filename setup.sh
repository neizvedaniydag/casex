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

# Create config if it doesn't exist
if [ ! -f "$CONFIG_FILE" ]; then
    cp "$SAMPLE_FILE" "$CONFIG_FILE"
    echo "Создан $CONFIG_FILE. Откройте admin.php для настройки."
fi

# Ask for domain or use localhost
read -p "Введите домен (ENTER для http://localhost:8000): " DOMAIN
DOMAIN=${DOMAIN:-http://localhost:8000}

# Update domain in config
if sed --version >/dev/null 2>&1; then
    sed -i "s|'DOMAIN' => '[^']*'|'DOMAIN' => '$DOMAIN'|" "$CONFIG_FILE"
else
    sed -i '' "s|'DOMAIN' => '[^']*'|'DOMAIN' => '$DOMAIN'|" "$CONFIG_FILE"
fi

echo "Запускаем сервер на $DOMAIN"
php -S 0.0.0.0:8000 &
PID=$!
echo "Нажмите Ctrl+C чтобы остановить сервер"
wait $PID
