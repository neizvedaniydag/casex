# Case Exchange Example

This project demonstrates a basic workflow for exchanging CS:GO cases for skins using Steam login.
It contains a minimal PHP front end and sample scripts.

## Setup


You can quickly configure the project with the `setup.sh` script. It installs PHP (if missing),
creates `config.php` and launches a local server.

```bash
./setup.sh
```

Follow the prompts to enter your Steam API key, domain and admin password.
If you prefer manual setup, copy `config.sample.php` to `config.php` and edit the values.
=======
1. Copy `config.sample.php` to `config.php` and fill in your Steam API key and domain.
2. Place the files on a PHP-enabled web server.
3. Ensure `openid.php` is available (already included).


## Usage

1. Open `index.php` in your browser.
2. Log in via Steam.
3. After login you will see a simple list of your inventory items.
4. Implement your own backend in `trade.php` to send trade offers with a 30% margin.

See `docs/steam_exchange_guide.md` for more detailed guidance on integrating with the Steam API.


After запуска `setup.sh` вы сможете войти в админ-панель по адресу `admin.php` и
изменять конфигурацию (API‑ключ, домен, пароль).
=======

