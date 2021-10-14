<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

function copyCallbacks($newSock, $oldSock)
{
    if (isset($oldSock->errorCallback)) {
        $newSock->errorCallback = $oldSock->errorCallback;
    }
    if (isset($oldSock->subscriptionTradesCallback)) {
        $newSock->subscriptionTradesCallback = $oldSock->subscriptionTradesCallback;
    }
    if (isset($oldSock->subscriptionTickerCallback)) {
        $newSock->subscriptionTickerCallback = $oldSock->subscriptionTickerCallback;
    }
    if (isset($oldSock->subscriptionTicker24hCallback)) {
        $newSock->subscriptionTicker24hCallback = $oldSock->subscriptionTicker24hCallback;
    }
    if (isset($oldSock->subscriptionAccountCallback)) {
        $newSock->subscriptionAccountCallback = $oldSock->subscriptionAccountCallback;
    }
    if (isset($oldSock->subscriptionCandlesCallback)) {
        $newSock->subscriptionCandlesCallback = $oldSock->subscriptionCandlesCallback;
    }
    if (isset($oldSock->subscriptionBookUpdateCallback)) {
        $newSock->subscriptionBookUpdateCallback = $oldSock->subscriptionBookUpdateCallback;
    }
    if (isset($oldSock->subscriptionBookCallback)) {
        $newSock->subscriptionBookCallback = $oldSock->subscriptionBookCallback;
    }
}

function createSignature($timestamp, $method, $url, $body, $apiSecret)
{
    $hashString = (string) $timestamp . $method . "/v2" . $url;
    if (count($body) > 0) {
        $hashString = $hashString . json_encode($body);
    }
    $signature = hash_hmac("SHA256", $hashString, $apiSecret);

    return $signature;
}

function errorToConsole($message)
{
    if (is_array($message)) {
        $message = implode(',', $message);
    }
    echo date("H:i:s") . " ERROR: " . $message;
}

class Bitvavo
{

    public function __construct($options)
    {
        $apiKeySet = false;
        $apiSecretSet = false;
        $accessWindowSet = false;
        $debuggingSet = false;
        $restUrlSet = false;
        $wsUrlSet = false;
        foreach ($options as $key => $value) {
            if (strtolower($key) == "apikey") {
                $this->apiKey = $value;
                $apiKeySet = true;
            } else if (strtolower($key) == "apisecret") {
                $this->apiSecret = $value;
                $apiSecretSet = true;
            } else if (strtolower($key) == "accesswindow") {
                $this->accessWindow = $value;
                $accessWindowSet = true;
            } else if (strtolower($key) == "debugging") {
                $this->debugging = (bool) $value;
                $debuggingSet = true;
            } else if (strtolower($key) === 'resturl') {
                $this->base = $value;
                $restUrlSet = true;
            } else if (strtolower($key) === 'wsurl') {
                $this->wsurl = $value;
                $wsUrlSet = true;
            }
        }
        if (!$apiKeySet) {
            $this->apiKey = "";
        }
        if (!$apiSecretSet) {
            $this->apiSecret = "";
        }
        if (!$accessWindowSet) {
            $this->accessWindow = 10000;
        }
        if (!$debuggingSet) {
            $this->debugging = false;
        }
        if (!$restUrlSet) {
            $this->base = "https://api.bitvavo.com/v2";
        }
        if (!$wsUrlSet) {
            $this->wsurl = "wss://ws.bitvavo.com/v2/";
        }
    }

    public function newWebSocket($reconnect = false, $publicCommandArray = null, $privateCommandArray = null, $oldSocket = null)
    {
        $this->webSocket = new Websocket($this, $reconnect, $publicCommandArray, $privateCommandArray, $oldSocket);
        return $this->webSocket;
    }

    public function debugToConsole($message)
    {
        if ($this->debugging) {
            if (is_array($message)) {
                $message = implode(',', $message);
            }
            echo date("H:i:s") . " DEBUG: " . $message;
        }
    }

    function createCurl($url, $method, $params)
    {
        $curl = curl_init();
        if ($method == "GET") {
            curl_setopt($curl, CURLOPT_HTTPGET, true);
        } else if ($method == "POST") {
            curl_setopt($curl, CURLOPT_POST, true);
        } else if ($method == "DELETE") {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        $query = http_build_query($params, '', '&');
        if (count($params) > 0) {
            curl_setopt($curl, CURLOPT_URL, $url . '?' . $query);
        } else {
            curl_setopt($curl, CURLOPT_URL, $url);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return $curl;
    }

    function sendPublic($url, $params, $method, $data)
    {
        $curl = $this->createCurl($url, $method, $params);
        $endpoint = str_replace(array($this->base), array(''), $url);
        if ($this->apiKey != "") {
            $now = (time() * 1000);
            $query = http_build_query($params, '', '&');
            if (count($params) > 0) {
                $endpointParams = $endpoint . '?' . $query;
            } else {
                $endpointParams = $endpoint;
            }
            $sig = createSignature($now, $method, $endpointParams, [], $this->apiSecret);
            $headers = array(
                'Bitvavo-Access-Key: ' . $this->apiKey,
                'Bitvavo-Access-Signature: ' . $sig,
                'Bitvavo-Access-Timestamp: ' . (string) $now,
                'Bitvavo-Access-Window: ' . (string) $this->accessWindow,
                'Content-Type: application/json'
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        $output = curl_exec($curl);
        $json = json_decode($output, true);
        return $json;
    }

    function sendPrivate($endpoint, $params, $body, $method, $apiSecret, $base, $apiKey)
    {
        $now = (time() * 1000);
        $query = http_build_query($params, '', '&');
        if (count($params) > 0) {
            $endpointParams = $endpoint . '?' . $query;
        } else {
            $endpointParams = $endpoint;
        }
        $sig = createSignature($now, $method, $endpointParams, $body, $apiSecret);
        $curl = $this->createCurl($base . $endpoint, $method, $params);
        $headers = array(
            'Bitvavo-Access-Key: ' . $apiKey,
            'Bitvavo-Access-Signature: ' . $sig,
            'Bitvavo-Access-Timestamp: ' . (string) $now,
            'Bitvavo-Access-Window: ' . (string) $this->accessWindow,
            'Content-Type: application/json'
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if ($method == "POST") {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($curl, CURLOPT_POST, true);
        } else if ($method == 'PUT') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        }
        $output = curl_exec($curl);
        $json = json_decode($output, true);
        return $json;
    }

    public function time()
    {
        return $this->sendPublic($this->base . "/time", [], "GET", "");
    }

    // options: market
    public function markets($options)
    {
        return $this->sendPublic($this->base . "/markets", $options, "GET", "");
    }

    // options: symbol
    public function assets($options)
    {
        return $this->sendPublic($this->base . "/assets", $options, "GET", "");
    }

    // options: depth
    public function book($symbol, $options)
    {
        return $this->sendPublic($this->base . "/" . $symbol . "/book", $options, "GET", "");
    }

    // options: limit, start, end, tradeIdFrom, tradeIdTo
    public function publicTrades($symbol, $options)
    {
        return $this->sendPublic($this->base . "/" . $symbol . "/trades", $options, "GET", "");
    }

    // options: limit, start, end
    public function candles($symbol, $interval, $options)
    {
        $options["interval"] = $interval;
        return $this->sendPublic($this->base . "/" . $symbol . "/candles", $options, "GET", "");
    }

    // options: market
    public function tickerPrice($options)
    {
        return $this->sendPublic($this->base . "/ticker/price", $options, "GET", "");
    }

    // options: market
    public function tickerBook($options)
    {
        return $this->sendPublic($this->base . "/ticker/book", $options, "GET", "");
    }

    // options: market
    public function ticker24h($options)
    {
        return $this->sendPublic($this->base . "/ticker/24h", $options, "GET", "");
    }

    // optional body parameters: limit:(amount, price, postOnly), market:(amount, amountQuote, disableMarketProtection)
    //                           stopLoss/takeProfit:(amount, amountQuote, disableMarketProtection, triggerType, triggerReference, triggerAmount)
    //                           stopLossLimit/takeProfitLimit:(amount, price, postOnly, triggerType, triggerReference, triggerAmount)
    //                           all orderTypes: timeInForce, selfTradePrevention, responseRequired
    public function placeOrder($market, $side, $orderType, $body)
    {
        $body["market"] = $market;
        $body["side"] = $side;
        $body["orderType"] = $orderType;
        return $this->sendPrivate("/order", [], $body, "POST", $this->apiSecret, $this->base, $this->apiKey);
    }

    public function getOrder($market, $orderId)
    {
        $options = array("market" => $market, "orderId" => $orderId);
        return $this->sendPrivate("/order", $options, [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }

    // Optional body parameters: limit:(amount, amountRemaining, price, timeInForce, selfTradePrevention, postOnly)
    //               untriggered stopLoss/takeProfit:(amount, amountQuote, disableMarketProtection, triggerType, triggerReference, triggerAmount)
    //                           stopLossLimit/takeProfitLimit: (amount, price, postOnly, triggerType, triggerReference, triggerAmount)
    public function updateOrder($market, $orderId, $body)
    {
        $body["market"] = $market;
        $body["orderId"] = $orderId;
        return $this->sendPrivate("/order", [], $body, "PUT", $this->apiSecret, $this->base, $this->apiKey);
    }

    public function cancelOrder($market, $orderId)
    {
        $options = array("market" => $market, "orderId" => $orderId);
        return $this->sendPrivate("/order", $options, [], "DELETE", $this->apiSecret, $this->base, $this->apiKey);
    }

    // options: limit, start, end, orderIdFrom, orderIdTo
    public function getOrders($market, $options)
    {
        $options["market"] = $market;
        return $this->sendPrivate("/orders", $options, [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }

    // options: market
    public function cancelOrders($options)
    {
        return $this->sendPrivate("/orders", $options, [], "DELETE", $this->apiSecret, $this->base, $this->apiKey);
    }

    // options: market
    public function ordersOpen($options)
    {
        return $this->sendPrivate("/ordersOpen", $options, [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }

    // options: limit, start, end, tradeIdFrom, tradeIdTo
    public function trades($market, $options)
    {
        $options["market"] = $market;
        return $this->sendPrivate("/trades", $options, [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }

    public function account()
    {
        return $this->sendPrivate("/account", [], [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }

    // options: symbol
    public function balance($options)
    {
        return $this->sendPrivate("/balance", $options, [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }

    public function depositAssets($symbol)
    {
        $options = array("symbol" => $symbol);
        return $this->sendPrivate("/deposit", $options, [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }

    // optional body parameters: paymentId, internal, addWithdrawalFee
    public function withdrawAssets($symbol, $amount, $address, $body)
    {
        $body["symbol"] = $symbol;
        $body["amount"] = $amount;
        $body["address"] = $address;
        return $this->sendPrivate("/withdrawal", [], $body, "POST", $this->apiSecret, $this->base, $this->apiKey);
    }

    // options: symbol, limit, start, end
    public function depositHistory($options)
    {
        return $this->sendPrivate("/depositHistory", $options, [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }

    // options: symbol, limit, start, end
    public function withdrawalHistory($options)
    {
        return $this->sendPrivate("/withdrawalHistory", $options, [], "GET", $this->apiSecret, $this->base, $this->apiKey);
    }
}

function sortAsks($a, $b)
{
    if ($a < $b) {
        return true;
    }
    return false;
}

function sortBids($a, $b)
{
    if ($a > $b) {
        return true;
    }
    return false;
}

function sortAndInsert($update, $book, $sortFunc)
{
    for ($i = 0; $i < count($update); $i++) {
        $updateSet = false;
        $updateEntry = $update[$i];
        for ($j = 0; $j < count($book); $j++) {
            $bookItem = $book[$j];
            if ($sortFunc($updateEntry[0], $bookItem[0])) {
                array_splice($book, $j, 0, [$updateEntry]);
                $updateSet = true;
                break;
            }
            if ($updateEntry[0] == $bookItem[0]) {
                if ($updateEntry[1] > 0) {
                    $book[$j] = $updateEntry;
                    $updateSet = true;
                    break;
                } else {
                    array_splice($book, $j, 1);
                    $updateSet = true;
                    break;
                }
            }
        }
        if ($updateSet == false) {
            $book[] = $updateEntry;
        }
    }
    return $book;
}

class Websocket
{

    public function __construct($bitvavo = null, $reconnect = false, $publicCommandArray = null, $privateCommandArray = null, $oldSocket = null)
    {
        $this->parent = $bitvavo;
        $this->wsurl = $bitvavo->wsurl;
        $this->apiKey = $bitvavo->apiKey;
        $this->apiSecret = $bitvavo->apiSecret;
        $this->accessWindow = $bitvavo->accessWindow;
        $this->debugging = $bitvavo->debugging;
        $this->started = false;
        $this->authenticated = false;
        $timestamp = (time() * 1000);
        if (!$reconnect) {
            $this->reconnectTimer = 1;
            if ($this->apiKey !== "") {
                $this->publicCommandArray = [["window" => $this->accessWindow, "action" => "authenticate", "key" => $this->apiKey, "signature" => createSignature($timestamp, "GET", "/websocket", [], $this->apiSecret), "timestamp" => $timestamp]];
            } else {
                $this->publicCommandArray = [];
            }
            $this->privateCommandArray = [];
        } else {
            sleep($oldSocket->reconnectTimer);
            $this->parent->debugToConsole("Restarting socket, waited for " . $oldSocket->reconnectTimer . " seconds\n");
            $this->reconnectTimer = $oldSocket->reconnectTimer * 2;
            $this->publicCommandArray = [];
            $this->privateCommandArray = [];
            foreach ($publicCommandArray as $value) {
                if ($value["action"] == "authenticate") {
                    $this->publicCommandArray[] = $value;
                } else if ($value["action"] == "subscribe") {
                    $this->publicCommandArray[] = $value;
                } else if ($value["action"] == "getBook") {
                    if (isset($oldSocket->subscriptionBookCallback)) {
                        $this->publicCommandArray[] = $value;
                    }
                }
            }
            foreach ($privateCommandArray as $value) {
                if ($value["action"] == "subscribe") {
                    $this->privateCommandArray[] = $value;
                }
            }
            copyCallbacks($this, $oldSocket);
        }

        $loop = React\EventLoop\Factory::create();
        $reactConnector = new React\Socket\Connector($loop, []);
        $connector = new Ratchet\Client\Connector($loop, $reactConnector);

        $connector($this->wsurl)->then(function (Ratchet\Client\WebSocket $conn) {

            $this->reconnectTimer = 1;
            $this->conn = $conn;
            $conn->on('message', function (\Ratchet\RFC6455\Messaging\MessageInterface $msg) use ($conn) {
                $this->handleMessage($msg);
            });

            // On close try to create a new websocket, such that execution continues.
            $conn->on('close', function ($code = null, $reason = null) {
                $this->parent->debugToConsole("Connection closed ({$code} - {$reason})\n");
                $this->parent->newWebSocket(true, $this->publicCommandArray, $this->privateCommandArray, $this);
            });

            // Send all public commands, private will be sent after authenticate has been received.
            foreach ($this->publicCommandArray as $value) {
                $this->parent->debugToConsole("SENDING:" . json_encode($value) . "\n");
                $conn->send(json_encode($value));
            }
        }, function (\Exception $e) use ($loop) {
                $this->parent->newWebSocket(true, $this->publicCommandArray, $this->privateCommandArray, $this);
            });

        $this->loop = $loop;
        if ($reconnect) {
            $this->started = true;
            $this->loop->run();
        }
        return $this;
    }

    public function addToBook($msg, $isNewBook)
    {
        if ($isNewBook) {
            $this->localBook[$msg["market"]]["bids"] = $msg["bids"];
            $this->localBook[$msg["market"]]["asks"] = $msg["asks"];
            $this->localBook[$msg["market"]]["nonce"] = $msg["nonce"];
            call_user_func($this->subscriptionBookCallback[$msg["market"]], $this->localBook[$msg["market"]]);
        } else {
            if (isset($this->localBook[$msg["market"]]["nonce"])) {
                if ($msg["nonce"] != $this->localBook[$msg["market"]]["nonce"] + 1) {
                    $this->subscriptionBook($msg["market"], $this->subscriptionBookCallback[$msg["market"]]);
                    return;
                }
                $this->localBook[$msg["market"]]["bids"] = sortAndInsert($msg["bids"], $this->localBook[$msg["market"]]["bids"], "sortBids");
                $this->localBook[$msg["market"]]["asks"] = sortAndInsert($msg["asks"], $this->localBook[$msg["market"]]["asks"], "sortAsks");
                $this->localBook[$msg["market"]]["nonce"] = $msg["nonce"];
                call_user_func($this->subscriptionBookCallback[$msg["market"]], $this->localBook[$msg["market"]]);
            }
        }
        return;
    }

    public function handleMessage($msg)
    {
        $response = $msg->__toString();
        $jsonResponse = json_decode($response, true);
        $this->parent->debugToConsole("FULL RESPONSE:" . $response . "\n");
        if (array_key_exists("error", $jsonResponse)) {
            call_user_func($this->errorCallback, $jsonResponse);
        } else if (array_key_exists("action", $jsonResponse)) {
            switch ($jsonResponse["action"]) {
                case "getTime":
                    call_user_func($this->timeCallback, $jsonResponse["response"]);
                    break;
                case "getMarkets":
                    call_user_func($this->marketsCallback, $jsonResponse["response"]);
                    break;
                case "getAssets":
                    call_user_func($this->assetsCallback, $jsonResponse["response"]);
                    break;
                case "getBook":
                    if (isset($this->subscriptionBookCallback[$jsonResponse["response"]["market"]])) {
                        $this->addToBook($jsonResponse["response"], true);
                    }
                    if (isset($this->bookCallback)) {
                        call_user_func($this->bookCallback, $jsonResponse["response"]);
                    }
                    break;
                case "getTrades":
                    call_user_func($this->publicTradesCallback, $jsonResponse["response"]);
                    break;
                case "getCandles":
                    call_user_func($this->candlesCallback, $jsonResponse["response"]);
                    break;
                case "getTicker24h":
                    call_user_func($this->ticker24hCallback, $jsonResponse["response"]);
                    break;
                case "getTickerPrice":
                    call_user_func($this->tickerPriceCallback, $jsonResponse["response"]);
                    break;
                case "getTickerBook":
                    call_user_func($this->tickerBookCallback, $jsonResponse["response"]);
                    break;
                case "privateCreateOrder":
                    call_user_func($this->placeOrderCallback, $jsonResponse["response"]);
                    break;
                case "privateGetOrder":
                    call_user_func($this->getOrderCallback, $jsonResponse["response"]);
                    break;
                case "privateUpdateOrder":
                    call_user_func($this->updateOrderCallback, $jsonResponse["response"]);
                    break;
                case "privateCancelOrder":
                    call_user_func($this->cancelOrderCallback, $jsonResponse["response"]);
                    break;
                case "privateGetOrders":
                    call_user_func($this->getOrdersCallback, $jsonResponse["response"]);
                    break;
                case "privateCancelOrders":
                    call_user_func($this->cancelOrdersCallback, $jsonResponse["response"]);
                    break;
                case "privateGetOrdersOpen":
                    call_user_func($this->ordersOpenCallback, $jsonResponse["response"]);
                    break;
                case "privateGetTrades":
                    call_user_func($this->tradesCallback, $jsonResponse["response"]);
                    break;
                case "privateGetAccount":
                    call_user_func($this->accountCallback, $jsonResponse["response"]);
                    break;
                case "privateGetBalance":
                    call_user_func($this->balanceCallback, $jsonResponse["response"]);
                    break;
                case "privateDepositAssets":
                    call_user_func($this->depositAssetsCallback, $jsonResponse["response"]);
                    break;
                case "privateWithdrawAssets":
                    call_user_func($this->withdrawAssetsCallback, $jsonResponse["response"]);
                    break;
                case "privateGetDepositHistory":
                    call_user_func($this->depositHistoryCallback, $jsonResponse["response"]);
                    break;
                case "privateGetWithdrawalHistory":
                    call_user_func($this->withdrawalHistoryCallback, $jsonResponse["response"]);
                    break;
            }
        } else if (array_key_exists("event", $jsonResponse)) {
            switch ($jsonResponse["event"]) {
                case "authenticate":
                    $this->authenticated = true;
                    $this->sendPrivateCommands();
                    break;
                case "trade":
                    call_user_func($this->subscriptionTradesCallback[$jsonResponse["market"]], $jsonResponse);
                    break;
                case "fill":
                    call_user_func($this->subscriptionAccountCallback[$jsonResponse["market"]], $jsonResponse);
                    break;
                case "order":
                    call_user_func($this->subscriptionAccountCallback[$jsonResponse["market"]], $jsonResponse);
                    break;
                case "ticker":
                    call_user_func($this->subscriptionTickerCallback[$jsonResponse["market"]], $jsonResponse);
                    break;
                case "ticker24h":
                    foreach ($jsonResponse["data"] as $entry) {
                        call_user_func($this->subscriptionTicker24hCallback[$entry["market"]], $entry);
                    }
                    break;
                case "book":
                    if (isset($this->subscriptionBookCallback[$jsonResponse["market"]])) {
                        $this->addToBook($jsonResponse, false);
                    }
                    if (isset($this->subscriptionBookUpdateCallback[$jsonResponse["market"]])) {
                        call_user_func($this->subscriptionBookUpdateCallback[$jsonResponse["market"]], $jsonResponse);
                    }
                    break;
                case "candle":
                    call_user_func($this->subscriptionCandlesCallback[$jsonResponse["market"]][$jsonResponse["interval"]], $jsonResponse);
                    break;
            }
        }
    }

    public function closeSocket()
    {
        $this->loop->stop();
    }

    public function startSocket()
    {
        $this->parent->debugToConsole("Starting websocket.\n");
        $this->started = true;
        $this->loop->run();
    }

    public function sendPublic($msg)
    {
        if ($this->started) {
            $this->parent->debugToConsole("SENDING:" . var_dump($msg));
            $this->conn->send(json_encode($msg));
        } else {
            $this->publicCommandArray[] = $msg;
        }
    }

    public function sendPrivate($msg)
    {
        if ($this->apiKey === "") {
            errorToConsole("You did not set the api key, but requested a private function.\n");
        }
        if ($this->started) {
            if ($this->authenticated) {
                $this->parent->debugToConsole("SENDING:" . $msg);
                $this->conn->send(json_encode($msg));
            } else {
                sleep(0.1);
                $this->sendPrivate($msg);
            }
        } else {
            $this->privateCommandArray[] = $msg;
        }
    }

    public function sendPrivateCommands()
    {
        foreach ($this->privateCommandArray as $value) {
            $this->parent->debugToConsole("SENDING:" . json_encode($value) . "\n");
            $this->conn->send(json_encode($value));
        }
    }

    public function setErrorCallback(callable $callback)
    {
        $this->errorCallback = $callback;
    }

    public function time(callable $callback)
    {
        $this->timeCallback = $callback;
        $this->sendPublic(["action" => "getTime"]);
    }

    // options: market
    public function markets($options, callable $callback)
    {
        $this->marketsCallback = $callback;
        $options["action"] = "getMarkets";
        $this->sendPublic($options);
    }

    // options: symbol
    public function assets($options, callable $callback)
    {
        $this->assetsCallback = $callback;
        $options["action"] = "getAssets";
        $this->sendPublic($options);
    }

    // options: depth
    public function book($market, $options, callable $callback)
    {
        $this->bookCallback = $callback;
        $options["market"] = $market;
        $options["action"] = "getBook";
        $this->sendPublic($options);
    }

    // options: limit, start, end, tradeIdFrom, tradeIdTo
    public function publicTrades($market, $options, callable $callback)
    {
        $this->publicTradesCallback = $callback;
        $options["market"] = $market;
        $options["action"] = "getTrades";
        $this->sendPublic($options);
    }

    // options: limit
    public function candles($market, $interval, $options, callable $callback)
    {
        $this->candlesCallback = $callback;
        $options["market"] = $market;
        $options["interval"] = $interval;
        $options["action"] = "getCandles";
        $this->sendPublic($options);
    }

    // options: market
    public function ticker24h($options, callable $callback)
    {
        $this->ticker24hCallback = $callback;
        $options["action"] = "getTicker24h";
        $this->sendPublic($options);
    }

    // options: market
    public function tickerPrice($options, callable $callback)
    {
        $this->tickerPriceCallback = $callback;
        $options["action"] = "getTickerPrice";
        $this->sendPublic($options);
    }

    // options: market
    public function tickerBook($options, callable $callback)
    {
        $this->tickerBookCallback = $callback;
        $options["action"] = "getTickerBook";
        $this->sendPublic($options);
    }

    // optional body parameters: limit:(amount, price, postOnly), market:(amount, amountQuote, disableMarketProtection)
    //                           stopLoss/takeProfit:(amount, amountQuote, disableMarketProtection, triggerType, triggerReference, triggerAmount)
    //                           stopLossLimit/takeProfitLimit:(amount, price, postOnly, triggerType, triggerReference, triggerAmount)
    //                           all orderTypes: timeInForce, selfTradePrevention, responseRequired
    public function placeOrder($market, $side, $orderType, $body, callable $callback)
    {
        $this->placeOrderCallback = $callback;
        $body["action"] = "privateCreateOrder";
        $body["market"] = $market;
        $body["side"] = $side;
        $body["orderType"] = $orderType;
        $this->sendPrivate($body);
    }

    public function getOrder($market, $orderId, callable $callback)
    {
        $this->getOrderCallback = $callback;
        $this->sendPrivate(["market" => $market, "orderId" => $orderId, "action" => "privateGetOrder"]);
    }

    // Optional body parameters: limit:(amount, amountRemaining, price, timeInForce, selfTradePrevention, postOnly)
    //               untriggered stopLoss/takeProfit:(amount, amountQuote, disableMarketProtection, triggerType, triggerReference, triggerAmount)
    //                           stopLossLimit/takeProfitLimit: (amount, price, postOnly, triggerType, triggerReference, triggerAmount)
    public function updateOrder($market, $orderId, $body, callable $callback)
    {
        $body["market"] = $market;
        $body["orderId"] = $orderId;
        $body["action"] = "privateUpdateOrder";
        $this->updateOrderCallback = $callback;
        $this->sendPrivate($body);
    }

    public function cancelOrder($market, $orderId, callable $callback)
    {
        $this->cancelOrderCallback = $callback;
        $this->sendPrivate(["market" => $market, "orderId" => $orderId, "action" => "privateCancelOrder"]);
    }

    // options: limit, start, end, orderIdFrom, orderIdTo
    public function getOrders($market, $options, callable $callback)
    {
        $this->getOrdersCallback = $callback;
        $options["market"] = $market;
        $options["action"] = "privateGetOrders";
        $this->sendPrivate($options);
    }

    // options: market
    public function cancelOrders($options, callable $callback)
    {
        $this->cancelOrdersCallback = $callback;
        $options["action"] = "privateCancelOrders";
        $this->sendPrivate($options);
    }

    // options: market
    public function ordersOpen($options, callable $callback)
    {
        $this->ordersOpenCallback = $callback;
        $options["action"] = "privateGetOrdersOpen";
        $this->sendPrivate($options);
    }

    // options: limit, start, end, tradeIdFrom, tradeIdTo
    public function trades($market, $options, callable $callback)
    {
        $this->tradesCallback = $callback;
        $options["market"] = $market;
        $options["action"] = "privateGetTrades";
        $this->sendPrivate($options);
    }

    public function account(callable $callback)
    {
        $this->accountCallback = $callback;
        $this->sendPrivate(["action" => "privateGetAccount"]);
    }

    // options: symbol
    public function balance($options, callable $callback)
    {
        $options["action"] = "privateGetBalance";
        $this->balanceCallback = $callback;
        $this->sendPrivate($options);
    }

    public function depositAssets($symbol, callable $callback)
    {
        $options = array("action" => "privateDepositAssets", "symbol" => $symbol);
        $this->depositAssetsCallback = $callback;
        $this->sendPrivate($options);
    }

    // optional body parameters: paymentId, internal, addWithdrawalFee
    public function withdrawAssets($symbol, $amount, $address, $body, callable $callback)
    {
        $body["symbol"] = $symbol;
        $body["amount"] = $amount;
        $body["address"] = $address;
        $body["action"] = "privateWithdrawAssets";
        $this->withdrawAssetsCallback = $callback;
        $this->sendPrivate($body);
    }

    // options: symbol, limit, start, end
    public function depositHistory($options, callable $callback)
    {
        $options["action"] = "privateGetDepositHistory";
        $this->depositHistoryCallback = $callback;
        $this->sendPrivate($options);
    }

    // options: symbol, limit, start, end
    public function withdrawalHistory($options, callable $callback)
    {
        $options["action"] = "privateGetWithdrawalHistory";
        $this->withdrawalHistoryCallback = $callback;
        $this->sendPrivate($options);
    }

    public function subscriptionTicker($market, callable $callback)
    {
        $this->subscriptionTickerCallback[$market] = $callback;
        $this->sendPublic(["action" => "subscribe", "channels" => [["name" => "ticker", "markets" => [$market]]]]);
    }

    public function subscriptionTicker24h($market, callable $callback)
    {
        $this->subscriptionTicker24hCallback[$market] = $callback;
        $this->sendPublic(["action" => "subscribe", "channels" => [["name" => "ticker24h", "markets" => [$market]]]]);
    }

    public function subscriptionAccount($market, callable $callback)
    {
        $this->subscriptionAccountCallback[$market] = $callback;
        $this->sendPrivate(["action" => "subscribe", "channels" => [["name" => "account", "markets" => [$market]]]]);
    }

    public function subscriptionCandles($market, $interval, callable $callback)
    {
        $this->subscriptionCandlesCallback[$market][$interval] = $callback;
        $this->sendPublic(["action" => "subscribe", "channels" => [["name" => "candles", "interval" => [$interval], "markets" => [$market]]]]);
    }

    public function subscriptionTrades($market, callable $callback)
    {
        $this->subscriptionTradesCallback[$market] = $callback;
        $this->sendPublic(["action" => "subscribe", "channels" => [["name" => "trades", "markets" => [$market]]]]);
    }

    public function subscriptionBookUpdate($market, callable $callback)
    {
        $this->subscriptionBookUpdateCallback[$market] = $callback;
        $this->sendPublic(["action" => "subscribe", "channels" => [["name" => "book", "markets" => [$market]]]]);
    }

    public function subscriptionBook($market, callable $callback)
    {
        $this->subscriptionBookCallback[$market] = $callback;
        $this->sendPublic(["action" => "subscribe", "channels" => [["name" => "book", "markets" => [$market]]]]);
        $this->sendPublic(["action" => "getBook", "market" => $market]);
    }
}

?>
