# ExchangeCases

This demo shows a basic website where users can log in through Steam and trade CS:GO cases for skins. The application is written in PHP and uses Steam OpenID for authentication.

## Requirements

- PHP 7 or higher with the cURL extension
- A web server capable of running PHP (the built in server is enough for testing)

## Installation

1. Copy `config.sample.php` to `config.php`.
2. Start the server:
   ```bash
   php -S localhost:8000
   ```
3. Open `http://localhost:8000/admin.php` and enter your Steam API key, domain and admin password. The admin page saves these values into `config.php`.

## Usage

- Visit `index.php` to log in via Steam.
- After logging in you can view your inventory and initiate a trade. The current trade stub in `trade.php` returns skins worth 70% of the value of the provided cases.
- Case buttons are loaded from `cases.php`, which returns available case images in JSON format for `scripts/js-choose.js`.

## Contributing

Feel free to open issues or pull requests with improvements.

## License

This project is licensed under the [Apache-2.0](LICENSE) License.
