# ExchangeCases

This demo shows a basic website where users can log in through Steam and trade CS2 cases for skins. The application is written in PHP and uses Steam OpenID for authentication. Inventory data is loaded via Steam's JSON endpoint and, if necessary, Valve's newer Inventory Service API. As a last resort you can supply a key for SteamApis.com to fetch inventory through their proxy network.

## Requirements

- PHP 7 or higher with the cURL extension
- A web server capable of running PHP (the built-in server works for testing)

## Installation

1. Copy `config.sample.php` to `config.php`.
2. Start the server on port 8000:
   ```bash
   php -S localhost:8000
   ```
3. Open `http://localhost:8000/admin.php` to configure your Steam API key, optional SteamApis key and the domain. By default the site runs at `http://localhost:8000`.

## Contributing

Pull requests and improvements are welcome.

## License

This project is released under the MIT License. See [LICENSE](LICENSE) for details.
