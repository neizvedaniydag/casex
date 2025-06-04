# Steam Case Exchange Site Guide

This document provides an overview of the steps required to turn the prototype in this repository into a basic site for exchanging CS:GO 2 cases for skins from your service account. It assumes you have a server running PHP and access to a Steam account that will act as your bot for trading.

## 1. Steam Login via OpenID

1. Register an API key at <https://steamcommunity.com/dev/apikey> for your domain.
2. Use an OpenID library for PHP (for example `lightopenid`) to authenticate users with their Steam account.
3. After authentication, obtain the user's Steam ID (`steamid64`) from the returned data.
4. Store the Steam ID in the session so you know which inventory to load.

## 2. Fetching User Inventory

1. First try the public JSON endpoint for CS2 inventories:
   ```
   https://steamcommunity.com/inventory/<STEAM_ID>/730/2?l=russian&count=5000
   ```
   Steam may occasionally reject direct requests or hide private inventories. In that case use the Web API `IEconItems_730/GetPlayerItems` with your API key:
   ```
   https://api.steampowered.com/IEconItems_730/GetPlayerItems/v1/?key=YOUR_KEY&steamid=<STEAM_ID>
   ```
2. Parse the JSON response to list the user's cases on the site. Each item contains an ID, class information and market hash name.
3. Display the cases in your existing modal or create a separate inventory page.

## 3. Bot Account Inventory

1. Log in to your service (bot) account using a trading library (for instance [SteamKit2](https://github.com/SteamRE/SteamKit) for C# or [node-steam-tradeoffer-manager](https://github.com/DoctorMcKay/node-steam-tradeoffer-manager) for Node.js).
2. Retrieve the bot's inventory the same way as the user inventory.
3. Keep a catalog of items and prices on your server so you know how much each skin costs.

## 4. Exchange Logic with 30% Margin

1. Calculate the total price of the user's offered cases based on market prices.
2. Determine which skins from the bot inventory you will send back. Ensure the total value of the skins is **no more than 70%** of the user's offer so your service earns a 30% margin.
3. Create a trade offer via the Steam trading API with the selected items from both sides.
4. Send the trade offer to the user's Steam ID and wait for them to accept.

## 5. Putting It Together

- Build PHP endpoints that:
  - Authenticate the user via Steam.
  - Fetch and display both inventories.
  - Allow the user to select cases to trade.
  - Call your backend (Node.js, C#, etc.) that controls the bot to create a trade offer.
- Use AJAX calls from your front end (for example in `scripts/js-choose.js`) to communicate with these endpoints without reloading the page.

## 6. Security Considerations

- Do not store Steam credentials in your repository. Use environment variables or a config file outside the web root.
- Validate all input from the user. Confirm the trade contents server-side before sending any offer.
- Monitor trade logs to detect errors or suspicious activity.

This guide only outlines the main steps. Implementing a secure and fully featured trading site requires additional work such as error handling, price management, and a user interface for confirming trades.
