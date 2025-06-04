# Case Exchange Example

This repository provides a minimal PHP demo for exchanging CS:GO cases for skins. Users authenticate via Steam and you manage the site settings in a small admin panel.

## Prerequisites

* PHP 7.4 or newer with the `curl` extension.

## Quick start

1. Run `./setup.sh` to launch a local PHP server. The script will create `config.php` from `config.sample.php` if needed.
2. Open `http://localhost:8000/admin.php` in your browser and fill in your Steam API key, domain and admin password.
3. Visit `index.php` to log in through Steam and try the demo inventory exchange.

To deploy on another server, copy the project to any PHP-enabled hosting and ensure `config.php` is writable by the web server.

## License

This project is released under the MIT License. See [LICENSE](LICENSE) for details.

## Contributing

Pull requests and improvements are welcome.
