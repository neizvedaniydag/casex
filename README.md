# ExchangeCases

This demo shows a basic website where users can log in through Steam and trade CS:GO cases for skins. The application is written in PHP and uses Steam OpenID for authentication.

## Requirements

- PHP 7 or higher with the cURL extension
- A web server capable of running PHP (the built-in server works for testing)

## Installation

1. Copy `config.sample.php` to `config.php`.
2. Start the server:
   ```bash
   php -S localhost:8000
   ```
3. Open `http://localhost:8000/admin.php` to set your Steam API key, domain and admin password. Settings are saved in `config.php`.

## Contributing

Pull requests and improvements are welcome.

## License

This project is released under the MIT License. See [LICENSE](LICENSE) for details.
