<p align="center">
  <br>
  <a href="https://bitvavo.com"><img src="https://bitvavo.com/assets/static/ext/logo-shape.svg" width="100" title="Bitvavo Logo"></a>
</p>

# PHP Bitvavo API
This is the PHP wrapper for the Bitvavo API. This project can be used to build your own projects which interact with the Bitvavo platform. Every function available on the API can be called through a REST request or over websockets. For info on the specifics of every parameter consult the [Bitvavo API documentation](https://docs.bitvavo.com/)

* Getting started       [REST](https://github.com/bitvavo/php-bitvavo-api#getting-started) [Websocket](https://github.com/bitvavo/php-bitvavo-api#getting-started-1)
* General
  * Time                [REST](https://github.com/bitvavo/php-bitvavo-api#get-time) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-time-1)
  * Markets             [REST](https://github.com/bitvavo/php-bitvavo-api#get-markets) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-markets-1)
  * Assets              [REST](https://github.com/bitvavo/php-bitvavo-api#get-assets) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-assets-1)
* Market Data
  * Book                [REST](https://github.com/bitvavo/php-bitvavo-api#get-book-per-market) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-book-per-market-1)
  * Public Trades       [REST](https://github.com/bitvavo/php-bitvavo-api#get-trades-per-market) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-trades-per-market-1)
  * Candles             [REST](https://github.com/bitvavo/php-bitvavo-api#get-candles-per-market) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-candles-per-market-1)
  * Price Ticker        [REST](https://github.com/bitvavo/php-bitvavo-api#get-price-ticker) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-price-ticker-1)
  * Book Ticker         [REST](https://github.com/bitvavo/php-bitvavo-api#get-book-ticker) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-book-ticker-1)
  * 24 Hour Ticker      [REST](https://github.com/bitvavo/php-bitvavo-api#get-24-hour-ticker) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-24-hour-ticker-1)
* Private 
  * Place Order         [REST](https://github.com/bitvavo/php-bitvavo-api#place-order) [Websocket](https://github.com/bitvavo/php-bitvavo-api#place-order-1)
  * Update Order        [REST](https://github.com/bitvavo/php-bitvavo-api#update-order) [Websocket](https://github.com/bitvavo/php-bitvavo-api#update-order-1)
  * Get Order           [REST](https://github.com/bitvavo/php-bitvavo-api#get-order) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-order-1)
  * Cancel Order        [REST](https://github.com/bitvavo/php-bitvavo-api#cancel-order) [Websocket](https://github.com/bitvavo/php-bitvavo-api#cancel-order-1)
  * Get Orders          [REST](https://github.com/bitvavo/php-bitvavo-api#get-orders) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-orders-1)
  * Cancel Orders       [REST](https://github.com/bitvavo/php-bitvavo-api#cancel-orders) [Websocket](https://github.com/bitvavo/php-bitvavo-api#cancel-orders-1)
  * Orders Open         [REST](https://github.com/bitvavo/php-bitvavo-api#get-orders-open) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-orders-open-1)
  * Trades              [REST](https://github.com/bitvavo/php-bitvavo-api#get-trades) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-trades-1)
  * Balance             [REST](https://github.com/bitvavo/php-bitvavo-api#get-balance) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-balance-1)
  * Deposit Assets     [REST](https://github.com/bitvavo/php-bitvavo-api#deposit-assets) [Websocket](https://github.com/bitvavo/php-bitvavo-api#deposit-assets-1)
  * Withdraw Assets   [REST](https://github.com/bitvavo/php-bitvavo-api#withdraw-assets) [Websocket](https://github.com/bitvavo/php-bitvavo-api#withdraw-assets-1)
  * Deposit History     [REST](https://github.com/bitvavo/php-bitvavo-api#get-deposit-history) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-deposit-history-1)
  * Withdrawal History  [REST](https://github.com/bitvavo/php-bitvavo-api#get-withdrawal-history) [Websocket](https://github.com/bitvavo/php-bitvavo-api#get-withdrawal-history-1)
* [Subscriptions](https://github.com/bitvavo/php-bitvavo-api#subscriptions)
  * [Ticker Subscription](https://github.com/bitvavo/php-bitvavo-api#ticker-subscription)
  * [Ticker 24 Hour Subscription](https://github.com/bitvavo/php-bitvavo-api#ticker-24-hour-subscription)
  * [Account Subscription](https://github.com/bitvavo/php-bitvavo-api#account-subscription)
  * [Candles Subscription](https://github.com/bitvavo/php-bitvavo-api#candles-subscription)
  * [Trades Subscription](https://github.com/bitvavo/php-bitvavo-api#trades-subscription)
  * [Book Subscription](https://github.com/bitvavo/php-bitvavo-api#book-subscription)
  * [Book subscription with local copy](https://github.com/bitvavo/php-bitvavo-api#book-subscription-with-local-copy)

## Installation

Get the package and it's dependencies:

`composer require bitvavo/php-bitvavo-api:dev-master`

Run the example:

`cd vendor/bitvavo/php-bitvavo-api/example`

`php example.php`


## REST requests

The general convention used in all functions (both REST and websockets), is that all optional parameters are passed as an associative array, while required parameters are passed as separate values. Only when [placing orders](https://github.com/bitvavo/php-bitvavo-api#place-order) some of the optional parameters are required, since a limit order requires more information than a market order. The returned responses are all converted to associative arrays as well, such that `$response['<key>'] = '<value>'`.

### Getting started

The API key and secret are required for private calls and optional for public calls. The access window and debugging parameter are optional for all calls. The access window is used to determine whether the request arrived within time, the value is specified in milliseconds. You can use the [time](https://github.com/bitvavo/php-bitvavo-api#get-time) function to synchronize your time to our server time if errors arise. Debugging should be set to true when you want to log additional information and full responses. Any parameter can be omitted, private functions will return an error when the api key and secret have not been set.
```PHP
require_once('bitvavo.php');

$bitvavo = new Bitvavo([
  "APIKEY" => "<APIKEY>", 
  "APISECRET" => "<APISECRET>",
  "ACCESSWINDOW" => 10000,
  "DEBUGGING" => false
]);
```
For demonstration purposes we encode back to json when printing. This is because PHP does not allow pretty printing of arrays. Normally you would access the required values in the following manner:

```PHP
$response = $bitvavo->time();
$currentTime = $response["time"];

// Do something with time
echo $currentTime
```

### General

#### Get time
```PHP
$response = $bitvavo->time();
echo json_encode($response);
```
<details>
 <summary>View Response</summary>

```PHP
{
    "time": 1548686055654
}
```
</details>

#### Get markets
```PHP
// options: market
foreach ($bitvavo->markets([]) as $market) {
  echo json_encode($market) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "ADA-BTC",
    "status": "trading",
    "base": "ADA",
    "quote": "BTC",
    "pricePrecision": 5,
    "minOrderInBaseAsset": "100",
    "minOrderInQuoteAsset": "0.001",
    "orderTypes": [
        "market",
        "limit"
    ]
}
{
    "market": "ADA-EUR",
    "status": "trading",
    "base": "ADA",
    "quote": "EUR",
    "pricePrecision": 5,
    "minOrderInBaseAsset": "100",
    "minOrderInQuoteAsset": "10",
    "orderTypes": [
        "market",
        "limit"
    ]
}
{
    "market": "AE-BTC",
    "status": "trading",
    "base": "AE",
    "quote": "BTC",
    "pricePrecision": 5,
    "minOrderInBaseAsset": "10",
    "minOrderInQuoteAsset": "0.001",
    "orderTypes": [
        "market",
        "limit"
    ]
}
{
    "market": "AE-EUR",
    "status": "trading",
    "base": "AE",
    "quote": "EUR",
    "pricePrecision": 5,
    "minOrderInBaseAsset": "10",
    "minOrderInQuoteAsset": "10",
    "orderTypes": [
        "market",
        "limit"
    ]
}
...
```
</details>

#### Get assets
```PHP
// options: symbol
foreach ($bitvavo->assets([]) as $asset) {
  echo json_encode($asset) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "symbol": "ADA",
    "name": "Cardano",
    "decimals": 6,
    "depositFee": "0",
    "depositConfirmations": 20,
    "depositStatus": "OK",
    "withdrawalFee": "0.2",
    "withdrawalMinAmount": "0.2",
    "withdrawalStatus": "OK",
    "networks": [
        "Mainnet"
    ],
    "message": ""
}
{
    "symbol": "AE",
    "name": "Aeternity",
    "decimals": 8,
    "depositFee": "0",
    "depositConfirmations": 30,
    "depositStatus": "OK",
    "withdrawalFee": "2",
    "withdrawalMinAmount": "2",
    "withdrawalStatus": "OK",
    "networks": [
        "Mainnet"
    ],
    "message": ""
}
{
    "symbol": "AION",
    "name": "Aion",
    "decimals": 8,
    "depositFee": "0",
    "depositConfirmations": 0,
    "depositStatus": "",
    "withdrawalFee": "3",
    "withdrawalMinAmount": "3",
    "withdrawalStatus": "",
    "networks": [
        "Mainnet"
    ],
    "message": ""
}
{
    "symbol": "ANT",
    "name": "Aragon",
    "decimals": 8,
    "depositFee": "0",
    "depositConfirmations": 30,
    "depositStatus": "OK",
    "withdrawalFee": "2",
    "withdrawalMinAmount": "2",
    "withdrawalStatus": "OK",
    "networks": [
        "Mainnet"
    ],
    "message": ""
}
...
```
</details>

### Market Data

#### Get book per market
```PHP
// options: depth
$response = $bitvavo->book("BTC-EUR", []);
echo json_encode($response) . "\n";
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "BTC-EUR",
    "nonce": 5111,
    "bids": [
        [
            "2998.9",
            "2.14460302"
        ],
        [
            "2998.4",
            "0.35156557"
        ],
        [
            "2997",
            "0.97089768"
        ],
        [
            "2996.5",
            "0.74129861"
        ],
        [
            "2996",
            "0.33746089"
        ],
        ...
    ],
    "asks": [
        [
            "2999",
            "0.34445088"
        ],
        [
            "2999.5",
            "0.32306421"
        ],
        [
            "3000",
            "0.37908805"
        ],
        [
            "3000.6",
            "0.85330708"
        ],
        [
            "3001.7",
            "0.31230068"
        ],
        ...
    ]
}
```
</details>

#### Get trades per market
```PHP
// options: limit, start, end, tradeIdFrom, tradeIdTo
foreach ($bitvavo->publicTrades("BTC-EUR", []) as $trade) {
  echo json_encode($trade) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "id": "99cee743-1a9b-4dd4-8337-2a384e490554",
    "timestamp": 1548685961053,
    "amount": "0.55444771",
    "price": "2996.3",
    "side": "buy"
}
{
    "id": "12d442cf-23a2-43c4-ae20-4b3d61a5993c",
    "timestamp": 1548685961047,
    "amount": "0.44555229",
    "price": "2995.7",
    "side": "buy"
}
{
    "id": "75335db3-5b94-48af-bdc9-8716e0a3d6ae",
    "timestamp": 1548685918958,
    "amount": "1",
    "price": "2996.1",
    "side": "buy"
}
{
    "id": "616bfa4e-b3ff-4b3f-a394-1538a49eb9bc",
    "timestamp": 1548685870299,
    "amount": "1",
    "price": "2996",
    "side": "buy"
}
{
    "id": "34cdda49-3e9d-4d8f-a1aa-3176f61d9c27",
    "timestamp": 1548684756948,
    "amount": "0.79946345",
    "price": "2996.3",
    "side": "buy"
}
{
    "id": "525a2ae0-7c0d-4945-9e4f-cf5729b44c5c",
    "timestamp": 1548684756939,
    "amount": "0.06202504",
    "price": "2995.6",
    "side": "buy"
}
...
```
</details>

#### Get candles per market
```PHP
// options: limit, start, end
foreach ($bitvavo->candles("LTC-EUR", "1h", []) as $candle) {
  echo json_encode($candle) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
[
    1548684000000,
    "2993.7",
    "2996.9",
    "2992.5",
    "2993.7",
    "9"
]
[
    1548684000000,
    "2993.7",
    "2996.9",
    "2992.5",
    "2993.7",
    "9"
]
[
    1548676800000,
    "2999.3",
    "3002.6",
    "2989.2",
    "2999.3",
    "63.00046504"
]
[
    1548669600000,
    "3012.9",
    "3015.8",
    "3000",
    "3012.9",
    "8"
]
[
    1548417600000,
    "3124",
    "3125.1",
    "3124",
    "3124",
    "0.1"
]
...
```
</details>

#### Get price ticker
```PHP
// options: market
foreach ($bitvavo->tickerPrice([]) as $price) {
  echo json_encode($price) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "EOS-EUR",
    "price": "2.0142"
}
{
    "market": "XRP-EUR",
    "price": "0.25193"
}
{
    "market": "ETH-EUR",
    "price": "91.1"
}
{
    "market": "IOST-EUR",
    "price": "0.005941"
}
{
    "market": "BCH-EUR",
    "price": "106.57"
}
{
    "market": "BTC-EUR",
    "price": "3000.2"
}
{
    "market": "STORM-EUR",
    "price": "0.0025672"
}
{
    "market": "EOS-BTC",
    "price": "0.00066289"
}
{
    "market": "BSV-EUR",
    "price": "57.6"
}
...
```
</details>

#### Get book ticker
```PHP
// options: market
foreach ($bitvavo->tickerBook([]) as $book) {
  echo json_encode($book) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "XVG-BTC",
    "bid": "0.00000045",
    "ask": "0.00000046",
    "bidSize": "28815.01275017",
    "askSize": "38392.85089495"
}
{
    "market": "XVG-EUR",
    "bid": "0.0042213",
    "ask": "0.0043277",
    "bidSize": "1695671.24837763",
    "askSize": "792229.47382889"
}
{
    "market": "ZIL-BTC",
    "bid": "0.00000082",
    "ask": "0.00000083",
    "bidSize": "140980.13397262",
    "askSize": "98839.99285373"
}
{
    "market": "ZIL-EUR",
    "bid": "0.0076923",
    "ask": "0.0077929",
    "bidSize": "348008.13304576",
    "askSize": "151544.09942432"
}
{
    "market": "ZRX-BTC",
    "bid": "0.00001679",
    "ask": "0.0000168",
    "bidSize": "633.12153002",
    "askSize": "1280.07668593"
}
{
    "market": "ZRX-EUR",
    "bid": "0.1575",
    "ask": "0.15774",
    "bidSize": "875.01315351",
    "askSize": "1013.62085819"
}
...
```
</details>

#### Get 24 hour ticker
```PHP
// options: market
foreach ($bitvavo->ticker24h([]) as $ticker) {
  echo json_encode($ticker) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "XVG-EUR",
    "open": "0.0043222",
    "high": "0.0044139",
    "low": "0.0040849",
    "last": "0.0041952",
    "volume": "1237140.82971657",
    "volumeQuote": "5267.56",
    "bid": "0.0042245",
    "bidSize": "1704411.59895476",
    "ask": "0.0043217",
    "askSize": "2419888.08209617",
    "timestamp": 1565777160307
}
{
    "market": "ZIL-EUR",
    "open": "0.008125",
    "high": "0.0082359",
    "low": "0.0076094",
    "last": "0.0077285",
    "volume": "738574.75091114",
    "volumeQuote": "5724.92",
    "bid": "0.007698",
    "bidSize": "347552.37282041",
    "ask": "0.0077977",
    "askSize": "151544.09942432",
    "timestamp": 1565777159934
}
{
    "market": "ZRX-EUR",
    "open": "0.16326",
    "high": "0.16326",
    "low": "0.15812",
    "last": "0.15858",
    "volume": "4855.99528525",
    "volumeQuote": "779.72",
    "bid": "0.15748",
    "bidSize": "874.65298311",
    "ask": "0.15775",
    "askSize": "545.84965752",
    "timestamp": 1565777159932
}
...
```
</details>

### Private

#### Place order
When placing an order, make sure that the correct optional parameters are set. For a limit order it is required to set both the amount and price. A market order is valid if either the amount or the amountQuote has been set.
```PHP
// optional parameters: limit:(amount, price, postOnly), market:(amount, amountQuote, disableMarketProtection),
// both: timeInForce, selfTradePrevention, responseRequired
$response = $bitvavo->placeOrder("BTC-EUR", "buy", "limit", ["amount" => "1", "price" => "2000"]);
echo json_encode($response) . "\n";
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686752319,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "1",
    "price": "2000",
    "onHold": "2005",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
```
</details>

#### Update order
When updating an order make sure that at least one of the optional parameters has been set. Otherwise nothing can be updated.
```PHP
// Optional parameters: limit:(amount, amountRemaining, price, timeInForce, selfTradePrevention, postOnly)
// (set at least 1) (responseRequired can be set as well, but does not update anything)
$response = $bitvavo->updateOrder("BTC-EUR", "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b", ["amount" => "1.1"]);
echo json_encode($response) . "\n";
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686829227,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1.1",
    "amountRemaining": "1.1",
    "price": "2000",
    "onHold": "2205.5",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
```
</details>

#### Get order
```PHP
$response = $bitvavo->getOrder("BTC-EUR", "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b");
echo json_encode($response) . "\n";
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686752319,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "1",
    "price": "2000",
    "onHold": "2005",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
```
</details>

#### Cancel order
```PHP
$response = $bitvavo->cancelOrder("BTC-EUR", "2557ace7-f9f3-4c15-8911-46022f01cf72");
echo json_encode($response) . "\n";
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId":"2557ace7-f9f3-4c15-8911-46022f01cf72"
}
```
</details>

#### Get orders
Returns the same as get order, but can be used to return multiple orders at once.
```PHP
// options: limit, start, end, orderIdFrom, orderIdTo
foreach ($bitvavo->getOrders("BTC-EUR", []) as $order) {
  echo json_encode($order) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686829227,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1.1",
    "amountRemaining": "1.1",
    "price": "2000",
    "onHold": "2205.5",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
{
    "orderId": "d0471852-d753-44a9-bc9a-a3f0ddb7c209",
    "market": "BTC-EUR",
    "created": 1548685870294,
    "updated": 1548685870294,
    "status": "filled",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "0",
    "price": "3000",
    "onHold": "0",
    "onHoldCurrency": "EUR",
    "filledAmount": "1",
    "filledAmountQuote": "2996",
    "feePaid": "7.49",
    "feeCurrency": "EUR",
    "fills": [
        {
            "id": "616bfa4e-b3ff-4b3f-a394-1538a49eb9bc",
            "timestamp": 1548685870299,
            "amount": "1",
            "price": "2996",
            "taker": true,
            "fee": "7.49",
            "feeCurrency": "EUR",
            "settled": true
        }
    ],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
{
    "orderId": "80b5f04d-21fc-4ebe-9c5f-6d34f78ee477",
    "market": "BTC-EUR",
    "created": 1548684420771,
    "updated": 1548684420771,
    "status": "filled",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "0",
    "price": "3000",
    "onHold": "0",
    "onHoldCurrency": "EUR",
    "filledAmount": "1",
    "filledAmountQuote": "2994.47228569",
    "feePaid": "7.48771431",
    "feeCurrency": "EUR",
    "fills": [
        {
            "id": "ae9b627c-3e64-4c71-b80a-9f674498b478",
            "timestamp": 1548684420781,
            "amount": "0.82771431",
            "price": "2994.3",
            "taker": true,
            "fee": "6.205041567",
            "feeCurrency": "EUR",
            "settled": true
        },
        {
            "id": "64cc0e3d-6e7b-451c-9034-9a6dc6c4665a",
            "timestamp": 1548684420790,
            "amount": "0.17228569",
            "price": "2995.3",
            "taker": true,
            "fee": "1.282672743",
            "feeCurrency": "EUR",
            "settled": true
        }
    ],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
...
```
</details>

#### Cancel orders
Cancels all orders in a market. If no market is specified, all orders of an account will be canceled.
```PHP
// options: market
foreach ($bitvavo->cancelOrders([]) as $order) {
  echo json_encode($order) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId":"8b1c491b-13bd-40e1-b4fa-7d8ecf1f4fc3"
}
{
    "orderId":"95313ae5-ad65-4430-a0fb-63591bbc337c"
}
{
    "orderId":"2465c3ab-5ae2-4d4d-bec7-345f51b3494d"
}
...
```
</details>

#### Get orders open
Returns all orders which are not filled or canceled.
```PHP
// options: market
foreach ($bitvavo->ordersOpen([]) as $order) {
  echo json_encode($order) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686829227,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1.1",
    "amountRemaining": "1.1",
    "price": "2000",
    "onHold": "2205.5",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
{
    "orderId": "2465c3ab-5ae2-4d4d-bec7-345f51b3494d",
    "market": "BTC-EUR",
    "created": 1548686566366,
    "updated": 1548686789695,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1.0",
    "amountRemaining": "1.0",
    "price": "2200",
    "onHold": "2205",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
 ...
```
</details>

#### Get trades
Returns all trades within a market for this account.
```PHP
// options: limit, start, end, tradeIdFrom, tradeIdTo
foreach ($bitvavo->trades("BTC-EUR", []) as $trade) {
  echo json_encode($trade) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "id": "616bfa4e-b3ff-4b3f-a394-1538a49eb9bc",
    "timestamp": 1548685870299,
    "market": "BTC-EUR",
    "side": "buy",
    "amount": "1",
    "price": "2996",
    "taker": true,
    "fee": "7.49",
    "feeCurrency": "EUR",
    "settled": true
}
{
    "id": "64cc0e3d-6e7b-451c-9034-9a6dc6c4665a",
    "timestamp": 1548684420790,
    "market": "BTC-EUR",
    "side": "buy",
    "amount": "0.17228569",
    "price": "2995.3",
    "taker": true,
    "fee": "1.282672743",
    "feeCurrency": "EUR",
    "settled": true
}
{
    "id": "ae9b627c-3e64-4c71-b80a-9f674498b478",
    "timestamp": 1548684420781,
    "market": "BTC-EUR",
    "side": "buy",
    "amount": "0.82771431",
    "price": "2994.3",
    "taker": true,
    "fee": "6.205041567",
    "feeCurrency": "EUR",
    "settled": true
}
{
    "id": "f78cc2d2-6044-4a6d-a86f-ff7d307142fb",
    "timestamp": 1548683023452,
    "market": "BTC-EUR",
    "side": "sell",
    "amount": "0.74190125",
    "price": "2992.5",
    "taker": true,
    "fee": "5.549490625",
    "feeCurrency": "EUR",
    "settled": true
}
 ...
```
</details>

#### Get balance
Returns the balance for this account.
```PHP
// options: symbol
foreach ($bitvavo->balance([]) as $balance) {
  echo json_encode($balance) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
  "symbol": "EUR",
  "available": "2599.95",
  "inOrder": "2022.65"
}
{
  "symbol": "BTC",
  "available": "1.65437",
  "inOrder": "0.079398"
}
{
  "symbol": "ADA",
  "available": "4.8",
  "inOrder": "0"
}
{
  "symbol": "BCH",
  "available": "0.00952811",
  "inOrder": "0"
}
{
  "symbol": "BSV",
  "available": "0.00952811",
  "inOrder": "0"
}
...
```
</details>

#### Deposit assets
Returns the address which can be used to deposit funds.
```PHP
$response = $bitvavo->depositAssets("BTC");
echo json_encode($response) . "\n";
```
<details>
 <summary>View Response</summary>

```PHP
{
    "address": "BitcoinAddress"
}
```
</details>

#### Withdraw assets
Can be used to withdraw funds from Bitvavo.
```PHP
// optional parameters: paymentId, internal, addWithdrawalFee
$response = $bitvavo->withdrawAssets("BTC", "1", "BitcoinAddress", []);
echo json_encode($response) . "\n";
```
<details>
 <summary>View Response</summary>

```PHP
{
    "success": true,
    "symbol": "BTC",
    "amount": "1"
}
```
</details>

#### Get deposit history
Returns the deposit history of your account.
```PHP
// options: symbol, limit, start, end
foreach ($bitvavo->depositHistory([]) as $deposit) {
  echo json_encode($deposit) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "timestamp": 1521550025000,
    "symbol": "EUR",
    "amount": "1",
    "fee": "0",
    "status": "completed",
    "address": "NL12RABO324234234"
}
{
    "timestamp": 1511873910000,
    "symbol": "BTC",
    "amount": "0.099",
    "fee": "0",
    "status": "completed",
    "txId": "0c6497e608212a516b8218674cb0ca04f65b67a00fe8bddaa1ecb03e9b029255"
}
...
```
</details>

#### Get withdrawal history
Returns the withdrawal history of an account.
```PHP
// options: symbol, limit, start, end
foreach ($bitvavo->withdrawalHistory([]) as $withdrawal) {
  echo json_encode($withdrawal) . "\n";
}
```
<details>
 <summary>View Response</summary>

```PHP
{
    "timestamp": 1548687467000,
    "symbol": "BTC",
    "amount": "0.99994",
    "fee": "0.00006",
    "status": "awaiting_processing",
    "address": "1CqtG5z55x7bYD5GxsAXPx59DEyujs4bjm"
}
{
    "timestamp": 1548682993000,
    "symbol": "BTC",
    "amount": "0.99994",
    "fee": "0.00006",
    "status": "awaiting_processing",
    "address": "1CqtG5z55x7bYD5GxsAXPx59DEyujs4bjm"
}
{
    "timestamp": 1548425559000,
    "symbol": "BTC",
    "amount": "0.09994",
    "fee": "0.00006",
    "status": "awaiting_processing",
    "address": "1CqtG5z55x7bYD5GxsAXPx59DEyujs4bjm"
}
{
    "timestamp": 1548409721000,
    "symbol": "EUR",
    "amount": "50",
    "fee": "0",
    "status": "completed",
    "address": "NL123BIM"
}
{
    "timestamp": 1537803091000,
    "symbol": "BTC",
    "amount": "0.01939",
    "fee": "0.00002",
    "status": "completed",
    "txId": "da2299c86fce67eb899aeaafbe1f81cf663a3850cf9f3337c92b2d87945532db",
    "address": "3QpyxeA7yWWsSURXEmuBBzHpxjqn7Rbyme"
}
...
```
</details>

## Websockets

All requests which can be done through REST requests can also be performed over websockets. Bitvavo also provides six [subscriptions](https://github.com/bitvavo/php-bitvavo-api#subscriptions). If subscribed to these, updates specific for that type/market are pushed immediately. Our experience with php is that it performs slightly worse than our other SDK's, therefore we recommend to implement programs, which require constant synchronisation with the exchange, in another language. For simple operations or any functions integrated into a website php suffices.

### Getting started

The websocket object should be intialised through the `$websock = $bitvavo->newWebSocket();` function. After which a callback for the errors should be set through the `setErrorCallback()` function. After this any desired function can be called. Finally the websocket should be started through the `startSocket()` function. This call is blocking, this means that any code after the `startSocket()` call will not be executed. When it is required to use the response of one function as input for another function, the second function should be called in the callback of the first function.

```PHP
$websock = $bitvavo->newWebSocket();

$websock->setErrorCallback(function($msg) {
  echo "Handle errors here " . json_encode($msg) . "\n";
});

// Call your functions here, like:
$websock->time(function($msg) {
  echo json_encode($msg) . "\n";
});

// When the response of the first call is required for the second call, make the second call in the callback.
// For demonstration purposes only, since the same could be achieved through cancelOrders().
$websock->ordersOpen(["market"=>"BTC-EUR" ], function($orderResponse) use ($webSock) {
  foreach ($orderResponse as $order) {
    $websock->cancelOrder("BTC-EUR", $order["orderId"], function($cancelResponse) {
      echo json_encode($cancelResponse) . "\n";
    });
  }
});

$websock->startSocket();

// Any code written here will not be executed until the websocket has been closed.
```

The api key and secret are copied from the bitvavo object. Therefore if you want to use the private portion of the websockets API, you should set both the key and secret as specified in [REST requests](https://github.com/bitvavo/php-bitvavo-api#rest-requests).

### Public

#### Get time
```PHP
$websock->time(function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "time": 1548686055654
}
```
</details>

#### Get markets
```PHP
// options: market
$websock->markets([], function($response) {
  foreach ($response as $market) {
    echo json_encode($market) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "ADA-BTC",
    "status": "trading",
    "base": "ADA",
    "quote": "BTC",
    "pricePrecision": 5,
    "minOrderInBaseAsset": "100",
    "minOrderInQuoteAsset": "0.001",
    "orderTypes": [
        "market",
        "limit"
    ]
}
{
    "market": "ADA-EUR",
    "status": "trading",
    "base": "ADA",
    "quote": "EUR",
    "pricePrecision": 5,
    "minOrderInBaseAsset": "100",
    "minOrderInQuoteAsset": "10",
    "orderTypes": [
        "market",
        "limit"
    ]
}
{
    "market": "AE-BTC",
    "status": "trading",
    "base": "AE",
    "quote": "BTC",
    "pricePrecision": 5,
    "minOrderInBaseAsset": "10",
    "minOrderInQuoteAsset": "0.001",
    "orderTypes": [
        "market",
        "limit"
    ]
}
{
    "market": "AE-EUR",
    "status": "trading",
    "base": "AE",
    "quote": "EUR",
    "pricePrecision": 5,
    "minOrderInBaseAsset": "10",
    "minOrderInQuoteAsset": "10",
    "orderTypes": [
        "market",
        "limit"
    ]
}
...
```
</details>

#### Get assets
```PHP
// options: symbol
$websock->assets([], function($response) {
  foreach ($response as $asset) {
    echo json_encode($asset) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "symbol": "ADA",
    "name": "Cardano",
    "decimals": 6,
    "depositFee": "0",
    "depositConfirmations": 20,
    "depositStatus": "OK",
    "withdrawalFee": "0.2",
    "withdrawalMinAmount": "0.2",
    "withdrawalStatus": "OK",
    "networks": [
        "Mainnet"
    ],
    "message": ""
}
{
    "symbol": "AE",
    "name": "Aeternity",
    "decimals": 8,
    "depositFee": "0",
    "depositConfirmations": 30,
    "depositStatus": "OK",
    "withdrawalFee": "2",
    "withdrawalMinAmount": "2",
    "withdrawalStatus": "OK",
    "networks": [
        "Mainnet"
    ],
    "message": ""
}
{
    "symbol": "AION",
    "name": "Aion",
    "decimals": 8,
    "depositFee": "0",
    "depositConfirmations": 0,
    "depositStatus": "",
    "withdrawalFee": "3",
    "withdrawalMinAmount": "3",
    "withdrawalStatus": "",
    "networks": [
        "Mainnet"
    ],
    "message": ""
}
{
    "symbol": "ANT",
    "name": "Aragon",
    "decimals": 8,
    "depositFee": "0",
    "depositConfirmations": 30,
    "depositStatus": "OK",
    "withdrawalFee": "2",
    "withdrawalMinAmount": "2",
    "withdrawalStatus": "OK",
    "networks": [
        "Mainnet"
    ],
    "message": ""
}
...
```
</details>

#### Get book per market
```PHP
// options: depth
$websock->book("BTC-EUR", [], function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "BTC-EUR",
    "nonce": 5111,
    "bids": [
        [
            "2998.9",
            "2.14460302"
        ],
        [
            "2998.4",
            "0.35156557"
        ],
        [
            "2997",
            "0.97089768"
        ],
        [
            "2996.5",
            "0.74129861"
        ],
        [
            "2996",
            "0.33746089"
        ],
        ...
    ],
    "asks": [
        [
            "2999",
            "0.34445088"
        ],
        [
            "2999.5",
            "0.32306421"
        ],
        [
            "3000",
            "0.37908805"
        ],
        [
            "3000.6",
            "0.85330708"
        ],
        [
            "3001.7",
            "0.31230068"
        ],
        ...
    ]
}
```
</details>

#### Get trades per market
```PHP
// options: limit, start, end
$websock->publicTrades("BTC-EUR", [], function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "id": "99cee743-1a9b-4dd4-8337-2a384e490554",
    "timestamp": 1548685961053,
    "amount": "0.55444771",
    "price": "2996.3",
    "side": "buy"
}
{
    "id": "12d442cf-23a2-43c4-ae20-4b3d61a5993c",
    "timestamp": 1548685961047,
    "amount": "0.44555229",
    "price": "2995.7",
    "side": "buy"
}
{
    "id": "75335db3-5b94-48af-bdc9-8716e0a3d6ae",
    "timestamp": 1548685918958,
    "amount": "1",
    "price": "2996.1",
    "side": "buy"
}
{
    "id": "616bfa4e-b3ff-4b3f-a394-1538a49eb9bc",
    "timestamp": 1548685870299,
    "amount": "1",
    "price": "2996",
    "side": "buy"
}
{
    "id": "34cdda49-3e9d-4d8f-a1aa-3176f61d9c27",
    "timestamp": 1548684756948,
    "amount": "0.79946345",
    "price": "2996.3",
    "side": "buy"
}
{
    "id": "525a2ae0-7c0d-4945-9e4f-cf5729b44c5c",
    "timestamp": 1548684756939,
    "amount": "0.06202504",
    "price": "2995.6",
    "side": "buy"
}
...
```
</details>

#### Get candles per market
```PHP
// options: limit
$websock->candles("LTC-EUR", "1h", [], function($response) {
  foreach ($response as $candle) {
    echo json_encode($candle) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
[
    1548684000000,
    "2993.7",
    "2996.9",
    "2992.5",
    "2993.7",
    "9"
]
[
    1548684000000,
    "2993.7",
    "2996.9",
    "2992.5",
    "2993.7",
    "9"
]
[
    1548676800000,
    "2999.3",
    "3002.6",
    "2989.2",
    "2999.3",
    "63.00046504"
]
[
    1548669600000,
    "3012.9",
    "3015.8",
    "3000",
    "3012.9",
    "8"
]
[
    1548417600000,
    "3124",
    "3125.1",
    "3124",
    "3124",
    "0.1"
]
...
```
</details>

#### Get price ticker
```PHP
// options: market
$websock->tickerPrice([], function($response) {
  foreach ($response as $price) {
    echo json_encode($price) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "EOS-EUR",
    "price": "2.0142"
}
{
    "market": "XRP-EUR",
    "price": "0.25193"
}
{
    "market": "ETH-EUR",
    "price": "91.1"
}
{
    "market": "IOST-EUR",
    "price": "0.005941"
}
{
    "market": "BCH-EUR",
    "price": "106.57"
}
{
    "market": "BTC-EUR",
    "price": "3000.2"
}
{
    "market": "STORM-EUR",
    "price": "0.0025672"
}
{
    "market": "EOS-BTC",
    "price": "0.00066289"
}
{
    "market": "BSV-EUR",
    "price": "57.6"
}
...
```
</details>

#### Get book ticker
```PHP
// options: market
$websock->tickerBook([], function($response) {
  foreach ($response as $book) {
    echo json_encode($book) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "XVG-BTC",
    "bid": "0.00000045",
    "ask": "0.00000046",
    "bidSize": "28815.01275017",
    "askSize": "38392.85089495"
}
{
    "market": "XVG-EUR",
    "bid": "0.0042213",
    "ask": "0.0043277",
    "bidSize": "1695671.24837763",
    "askSize": "792229.47382889"
}
{
    "market": "ZIL-BTC",
    "bid": "0.00000082",
    "ask": "0.00000083",
    "bidSize": "140980.13397262",
    "askSize": "98839.99285373"
}
{
    "market": "ZIL-EUR",
    "bid": "0.0076923",
    "ask": "0.0077929",
    "bidSize": "348008.13304576",
    "askSize": "151544.09942432"
}
{
    "market": "ZRX-BTC",
    "bid": "0.00001679",
    "ask": "0.0000168",
    "bidSize": "633.12153002",
    "askSize": "1280.07668593"
}
{
    "market": "ZRX-EUR",
    "bid": "0.1575",
    "ask": "0.15774",
    "bidSize": "875.01315351",
    "askSize": "1013.62085819"
}
...
```
</details>

#### Get 24 hour ticker
```PHP
// options: market
$websock->ticker24h([], function($response) {
  foreach ($response as $ticker) {
    echo json_encode($ticker) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "XVG-EUR",
    "open": "0.0043222",
    "high": "0.0044139",
    "low": "0.0040849",
    "last": "0.0041952",
    "volume": "1237140.82971657",
    "volumeQuote": "5267.56",
    "bid": "0.0042245",
    "bidSize": "1704411.59895476",
    "ask": "0.0043217",
    "askSize": "2419888.08209617",
    "timestamp": 1565777160307
}
{
    "market": "ZIL-EUR",
    "open": "0.008125",
    "high": "0.0082359",
    "low": "0.0076094",
    "last": "0.0077285",
    "volume": "738574.75091114",
    "volumeQuote": "5724.92",
    "bid": "0.007698",
    "bidSize": "347552.37282041",
    "ask": "0.0077977",
    "askSize": "151544.09942432",
    "timestamp": 1565777159934
}
{
    "market": "ZRX-EUR",
    "open": "0.16326",
    "high": "0.16326",
    "low": "0.15812",
    "last": "0.15858",
    "volume": "4855.99528525",
    "volumeQuote": "779.72",
    "bid": "0.15748",
    "bidSize": "874.65298311",
    "ask": "0.15775",
    "askSize": "545.84965752",
    "timestamp": 1565777159932
}
...
```
</details>

### Private

#### Place order
When placing an order, make sure that the correct optional parameters are set. For a limit order it is required to set both the amount and price. A market order is valid if either the amount or the amountQuote has been set.
```PHP
// optional parameters: limit:(amount, price, postOnly), market:(amount, amountQuote, disableMarketProtection),
// both: timeInForce, selfTradePrevention, responseRequired
$websock->placeOrder("BTC-EUR", "buy", "limit", ["amount" => "0.1", "price" => "5000"], function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686752319,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "1",
    "price": "2000",
    "onHold": "2005",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
```
</details>

#### Update order
When updating an order make sure that at least one of the optional parameters has been set. Otherwise nothing can be updated.
```PHP
// Optional parameters: limit:(amount, amountRemaining, price, timeInForce, selfTradePrevention, postOnly)
// (set at least 1) (responseRequired can be set as well, but does not update anything)
$websock->updateOrder("BTC-EUR", "68322e0d-1a41-4e39-bc26-8c9b9a268a81", ["amount" => "0.2"], function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686829227,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1.1",
    "amountRemaining": "1.1",
    "price": "2000",
    "onHold": "2205.5",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
```
</details>

#### Get order
```PHP
$websock->getOrder("BTC-EUR", "68322e0d-1a41-4e39-bc26-8c9b9a268a81", function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686752319,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "1",
    "price": "2000",
    "onHold": "2005",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
```
</details>

#### Cancel order
```PHP
$websock->cancelOrder("BTC-EUR", "68322e0d-1a41-4e39-bc26-8c9b9a268a81", function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId":"2557ace7-f9f3-4c15-8911-46022f01cf72"
}
```
</details>

#### Get orders
Returns the same as get order, but can be used to return multiple orders at once.
```PHP
// options: limit, start, end, orderIdFrom, orderIdTo
$websock->getOrders("BTC-EUR", [], function($response) {
  foreach ($response as $order) {
    echo json_encode($order) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686829227,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1.1",
    "amountRemaining": "1.1",
    "price": "2000",
    "onHold": "2205.5",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
{
    "orderId": "d0471852-d753-44a9-bc9a-a3f0ddb7c209",
    "market": "BTC-EUR",
    "created": 1548685870294,
    "updated": 1548685870294,
    "status": "filled",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "0",
    "price": "3000",
    "onHold": "0",
    "onHoldCurrency": "EUR",
    "filledAmount": "1",
    "filledAmountQuote": "2996",
    "feePaid": "7.49",
    "feeCurrency": "EUR",
    "fills": [
        {
            "id": "616bfa4e-b3ff-4b3f-a394-1538a49eb9bc",
            "timestamp": 1548685870299,
            "amount": "1",
            "price": "2996",
            "taker": true,
            "fee": "7.49",
            "feeCurrency": "EUR",
            "settled": true
        }
    ],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
{
    "orderId": "80b5f04d-21fc-4ebe-9c5f-6d34f78ee477",
    "market": "BTC-EUR",
    "created": 1548684420771,
    "updated": 1548684420771,
    "status": "filled",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "0",
    "price": "3000",
    "onHold": "0",
    "onHoldCurrency": "EUR",
    "filledAmount": "1",
    "filledAmountQuote": "2994.47228569",
    "feePaid": "7.48771431",
    "feeCurrency": "EUR",
    "fills": [
        {
            "id": "ae9b627c-3e64-4c71-b80a-9f674498b478",
            "timestamp": 1548684420781,
            "amount": "0.82771431",
            "price": "2994.3",
            "taker": true,
            "fee": "6.205041567",
            "feeCurrency": "EUR",
            "settled": true
        },
        {
            "id": "64cc0e3d-6e7b-451c-9034-9a6dc6c4665a",
            "timestamp": 1548684420790,
            "amount": "0.17228569",
            "price": "2995.3",
            "taker": true,
            "fee": "1.282672743",
            "feeCurrency": "EUR",
            "settled": true
        }
    ],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
...
```
</details>

#### Cancel orders
Cancels all orders in a market. If no market is specified, all orders of an account will be canceled.
```PHP
// options: market
$websock->cancelOrders(["market" => "BTC-EUR"], function($response) {
  foreach ($response as $deletion) {
    echo json_encode($deletion) . "\n"; 
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId":"8b1c491b-13bd-40e1-b4fa-7d8ecf1f4fc3"
}
{
    "orderId":"95313ae5-ad65-4430-a0fb-63591bbc337c"
}
{
    "orderId":"2465c3ab-5ae2-4d4d-bec7-345f51b3494d"
}
...
```
</details>

#### Get orders open
Returns all orders which are not filled or canceled.
```PHP
// options: market
$websock->ordersOpen([], function($response) {
  foreach ($response as $order) {
    echo json_encode($order) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "orderId": "97d89ffc-2339-4e8f-8032-bf7b8c9ee65b",
    "market": "BTC-EUR",
    "created": 1548686752319,
    "updated": 1548686829227,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1.1",
    "amountRemaining": "1.1",
    "price": "2000",
    "onHold": "2205.5",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
{
    "orderId": "2465c3ab-5ae2-4d4d-bec7-345f51b3494d",
    "market": "BTC-EUR",
    "created": 1548686566366,
    "updated": 1548686789695,
    "status": "new",
    "side": "buy",
    "orderType": "limit",
    "amount": "1.0",
    "amountRemaining": "1.0",
    "price": "2200",
    "onHold": "2205",
    "onHoldCurrency": "EUR",
    "filledAmount": "0",
    "filledAmountQuote": "0",
    "feePaid": "0",
    "feeCurrency": "EUR",
    "fills": [],
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
 ...
```
</details>

#### Get trades
Returns all trades within a market for this account.
```PHP
// options: limit, start, end, tradeIdFrom, tradeIdTo
$websock->trades("BTC-EUR", [], function($response) {
  foreach ($response as $trade) {
    echo json_encode($trade) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "id": "616bfa4e-b3ff-4b3f-a394-1538a49eb9bc",
    "timestamp": 1548685870299,
    "market": "BTC-EUR",
    "side": "buy",
    "amount": "1",
    "price": "2996",
    "taker": true,
    "fee": "7.49",
    "feeCurrency": "EUR",
    "settled": true
}
{
    "id": "64cc0e3d-6e7b-451c-9034-9a6dc6c4665a",
    "timestamp": 1548684420790,
    "market": "BTC-EUR",
    "side": "buy",
    "amount": "0.17228569",
    "price": "2995.3",
    "taker": true,
    "fee": "1.282672743",
    "feeCurrency": "EUR",
    "settled": true
}
{
    "id": "ae9b627c-3e64-4c71-b80a-9f674498b478",
    "timestamp": 1548684420781,
    "market": "BTC-EUR",
    "side": "buy",
    "amount": "0.82771431",
    "price": "2994.3",
    "taker": true,
    "fee": "6.205041567",
    "feeCurrency": "EUR",
    "settled": true
}
{
    "id": "f78cc2d2-6044-4a6d-a86f-ff7d307142fb",
    "timestamp": 1548683023452,
    "market": "BTC-EUR",
    "side": "sell",
    "amount": "0.74190125",
    "price": "2992.5",
    "taker": true,
    "fee": "5.549490625",
    "feeCurrency": "EUR",
    "settled": true
}
 ...
```
</details>

#### Get balance
Returns the balance for this account.
```PHP
// options: symbol
$websock->balance([], function($response) {
  foreach ($response as $balance) {
    echo json_encode($balance) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
  "symbol": "EUR",
  "available": "2599.95",
  "inOrder": "2022.65"
}
{
  "symbol": "BTC",
  "available": "1.65437",
  "inOrder": "0.079398"
}
{
  "symbol": "ADA",
  "available": "4.8",
  "inOrder": "0"
}
{
  "symbol": "BCH",
  "available": "0.00952811",
  "inOrder": "0"
}
{
  "symbol": "BSV",
  "available": "0.00952811",
  "inOrder": "0"
}
...
```
</details>

#### Deposit assets
Returns the address which can be used to deposit funds.
```PHP
$websock->depositAssets("BTC", function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "address": "BitcoinAddress"
}
```
</details>

#### Withdraw assets
Can be used to withdraw funds from Bitvavo.
```PHP
// optional parameters: paymentId, internal, addWithdrawalFee
$websock->withdrawAssets("BTC", "1", "BitcoinAddress", [], function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "success": true,
    "symbol": "BTC",
    "amount": "1"
}
```
</details>

#### Get deposit history
Returns the deposit history of your account.
```PHP
// options: symbol, limit, start, end
$websock->depositHistory([], function($response) {
  foreach ($response as $deposit) {
    echo json_encode($deposit) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "timestamp": 1521550025000,
    "symbol": "EUR",
    "amount": "1",
    "fee": "0",
    "status": "completed",
    "address": "NL12RABO324234234"
}
{
    "timestamp": 1511873910000,
    "symbol": "BTC",
    "amount": "0.099",
    "fee": "0",
    "status": "completed",
    "txId": "0c6497e608212a516b8218674cb0ca04f65b67a00fe8bddaa1ecb03e9b029255"
}
...
```
</details>

#### Get withdrawal history
Returns the withdrawal history of an account.
```PHP
// options: symbol, limit, start, end
$websock->withdrawalHistory([], function($response) {
  foreach ($response as $withdrawal) {
    echo json_encode($withdrawal) . "\n";
  }
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "timestamp": 1548687467000,
    "symbol": "BTC",
    "amount": "0.99994",
    "fee": "0.00006",
    "status": "awaiting_processing",
    "address": "1CqtG5z55x7bYD5GxsAXPx59DEyujs4bjm"
}
{
    "timestamp": 1548682993000,
    "symbol": "BTC",
    "amount": "0.99994",
    "fee": "0.00006",
    "status": "awaiting_processing",
    "address": "1CqtG5z55x7bYD5GxsAXPx59DEyujs4bjm"
}
{
    "timestamp": 1548425559000,
    "symbol": "BTC",
    "amount": "0.09994",
    "fee": "0.00006",
    "status": "awaiting_processing",
    "address": "1CqtG5z55x7bYD5GxsAXPx59DEyujs4bjm"
}
{
    "timestamp": 1548409721000,
    "symbol": "EUR",
    "amount": "50",
    "fee": "0",
    "status": "completed",
    "address": "NL123BIM"
}
{
    "timestamp": 1537803091000,
    "symbol": "BTC",
    "amount": "0.01939",
    "fee": "0.00002",
    "status": "completed",
    "txId": "da2299c86fce67eb899aeaafbe1f81cf663a3850cf9f3337c92b2d87945532db",
    "address": "3QpyxeA7yWWsSURXEmuBBzHpxjqn7Rbyme"
}
...
```
</details>

### Subscriptions

#### Ticker subscription
Sends an update every time the best bid, best ask or last price changed.
```PHP
$websock->subscriptionTicker("BTC-EUR", function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "event": "ticker",
    "market": "BTC-EUR",
    "bestAsk": "9410.1",
    "bestAskSize": "0.10847628",
    "lastPrice": "9335"
}
```
</details>

#### Ticker 24 hour subscription
Updated ticker24h objects are sent on this channel once per second. A ticker24h object is considered updated if one of the values besides timestamp has changed.
```PHP
$websock->subscriptionTicker24h("BTC-EUR", function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "market": "BTC-EUR",
    "open": "10061",
    "high": "10061",
    "low": "9265.4",
    "last": "9400.3",
    "volume": "309.30172822",
    "volumeQuote": "2993760.89",
    "bid": "9400.1",
    "bidSize": "0.10576468",
    "ask": "9400.4",
    "askSize": "0.10858821",
    "timestamp": 1565777506453
}
```
</details>

#### Account subscription
Sends an update whenever an event happens which is related to the account. These are ‘order’ events (create, update, cancel) or ‘fill’ events (a trade occurred).
```PHP
$websock->subscriptionAccount("BTC-EUR", function($function){
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
Fill:
{
    "event": "fill",
    "timestamp": 1548688159231,
    "market": "BTC-EUR",
    "orderId": "a7844f9d-2f63-46ae-b96f-0df1a63dc6ae",
    "fillId": "0b921924-9ee7-4276-b63c-1681f49d016c",
    "side": "buy",
    "amount": "0.36346668",
    "price": "2993.9",
    "taker": true,
    "fee": "2.717106748",
    "feeCurrency": "EUR"
}

Order:
{
    "event": "order",
    "orderId": "a7844f9d-2f63-46ae-b96f-0df1a63dc6ae",
    "market": "BTC-EUR",
    "created": 1548688159220,
    "updated": 1548688159220,
    "status": "filled",
    "side": "buy",
    "orderType": "limit",
    "amount": "1",
    "amountRemaining": "0",
    "price": "3000",
    "onHold": "2.24",
    "onHoldCurrency": "EUR",
    "selfTradePrevention": "decrementAndCancel",
    "visible": true,
    "timeInForce": "GTC",
    "postOnly": false
}
```
</details>

#### Candles subscription
Sends an updated candle after each trade for the specified interval and market.
```PHP
$websock->subscriptionCandles("BTC-EUR", "1h", function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "event": "candle",
    "market": "BTC-EUR",
    "interval": "1h",
    "candle": [
        [
            1548687600000,
            "2998.2",
            "3000.3",
            "2990.8",
            "2998.2",
            "3.05"
        ]
    ]
}
```
</details>

#### Trades subscription
Sends an update whenever a trade has happened on this market. For your own trades, please subscribe to account.
```PHP
$websock->subscriptionTrades("BTC-EUR", function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "event": "trade",
    "timestamp": 1548688231625,
    "market": "BTC-EUR",
    "id": "9956f4c9-b9e3-4ec9-9793-1070ef56c016",
    "amount": "0.05",
    "price": "2992.9",
    "side": "sell"
}
```
</details>

#### Book subscription
Sends an update whenever the order book for this specific market has changed. A list of tuples ([price, amount]) are returned, where amount ‘0’ means that there are no more orders at this price. If you wish to maintain your own copy of the order book, consider using the next function. Although all updates will be received, there might be a slight delay compared to other languages. When using this function for automated trading please consider coding in an alternative language.
```PHP
$webSock->subscriptionBookUpdate("BTC-EUR", function($response){
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "event": "book",
    "market": "BTC-EUR",
    "nonce": 18592,
    "bids": [
        [
            "2986",
            "0"
        ]
    ],
    "asks": [
        [
            "2986.6",
            "0"
        ],
        [
            "2986.5",
            "0.00335008"
        ]
    ]
}
```
</details>

#### Book subscription with local copy
This is a combination of get book per market and the book subscription which maintains a local copy. On every update to the order book, the entire order book is returned to the callback, while the book subscription will only return updates to the book. Although all updates will be received, there might be a slight delay compared to other languages. When using this function for automated trading please consider coding in an alternative language.
```PHP
$websock->subscriptionBook("BTC-EUR", function($response) {
  echo json_encode($response) . "\n";
});
```
<details>
 <summary>View Response</summary>

```PHP
{
    "bids": [
        [
            "2986.3",
            "0.0033503"
        ],
        [
            "2985.8",
            "0.00335087"
        ],
        [
            "2985",
            "0.00335176"
        ],
        [
            "2984.4",
            "0.00335244"
        ],
        [
            "2984.1",
            "2.06836375"
        ],
        ...
    ],
    "asks": [
        [
            "2986.4",
            "0.00335019"
        ],
        [
            "2987.1",
            "0.00334996"
        ],
        [
            "2987.5",
            "0.00335008"
        ],
        [
            "2988.2",
            "0.00334996"
        ],
        [
            "2989",
            "5.19132723"
        ],
        ...
    ],
    "nonce": 18632
}
```
</details>