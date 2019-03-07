<?php

/* 
 * This is an example utilising all functions of the PHP Bitvavo API wrapper.
 * The APIKEY and APISECRET should be replaced by your own key and secret.
 * For public functions the APIKEY and SECRET can be removed.
 * Documentation: https://docs.bitvavo.com
 * Bitvavo: https://bitvavo.com
 * README: https://github.com/bitvavo/php-bitvavo-api
 */

require_once('../bitvavo.php');

function main() {
  $bitvavo = new Bitvavo([
    "APIKEY" => "<APIKEY>", 
    "APISECRET" => "<APISECRET>",
    "ACCESSWINDOW" => 10000,
    "DEBUGGING" => false
  ]);  
  
  testREST($bitvavo);

  $websock = $bitvavo->newWebSocket();
  testWebsocket($websock);
}

function testREST($bitvavo) {
  $response = $bitvavo->time();
  echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

  // foreach ($bitvavo->markets([]) as $market) {
  //   echo json_encode($market, JSON_PRETTY_PRINT) . "\n";
  // }

  // foreach ($bitvavo->assets([]) as $asset) {
  //   echo json_encode($asset, JSON_PRETTY_PRINT) . "\n";
  // }

  // $response = $bitvavo->book("BTC-EUR", []);
  // echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

  // foreach ($bitvavo->publicTrades("BTC-EUR", []) as $trade) {
  //   echo json_encode($trade, JSON_PRETTY_PRINT) . "\n";
  // }

  // foreach ($bitvavo->candles("BTC-EUR", "1h", []) as $candle) {
  //   echo json_encode($candle, JSON_PRETTY_PRINT) . "\n";
  // }


  // foreach ($bitvavo->tickerPrice([]) as $price) {
  //   echo json_encode($price, JSON_PRETTY_PRINT) . "\n";
  // }

  // foreach ($bitvavo->tickerBook([]) as $book) {
  //   echo json_encode($book, JSON_PRETTY_PRINT) . "\n";
  // }

  // foreach ($bitvavo->ticker24h([]) as $ticker) {
  //   echo json_encode($ticker, JSON_PRETTY_PRINT) . "\n";
  // }


  // $response = $bitvavo->placeOrder("BTC-EUR", "buy", "limit", ["amount" => "1", "price" => "2000"]);
  // echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

  // $response = $bitvavo->getOrder("BTC-EUR", "db985cbc-70dd-4afd-a9ff-9ba363efab70");
  // echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

  // $response = $bitvavo->updateOrder("BTC-EUR", "db985cbc-70dd-4afd-a9ff-9ba363efab70", ["amount" => "1.1"]);
  // echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

  // $response = $bitvavo->cancelOrder("BTC-EUR", "db985cbc-70dd-4afd-a9ff-9ba363efab70");
  // echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

  // foreach ($bitvavo->getOrders("BTC-EUR", []) as $order) {
  //   echo json_encode($order, JSON_PRETTY_PRINT) . "\n";
  // }

  // foreach ($bitvavo->cancelOrders(["market" => "BTC-EUR"]) as $order) {
  //   echo json_encode($order, JSON_PRETTY_PRINT) . "\n";
  // }

  // foreach ($bitvavo->ordersOpen([]) as $order) {
  //   echo json_encode($order, JSON_PRETTY_PRINT) . "\n";
  // }


  // foreach ($bitvavo->trades("BTC-EUR", []) as $trade) {
  //   echo json_encode($trade, JSON_PRETTY_PRINT) . "\n";
  // }


  // foreach ($bitvavo->balance([]) as $balance) {
  //   echo json_encode($balance, JSON_PRETTY_PRINT) . "\n";
  // }

  // $response = $bitvavo->depositAssets("BTC");
  // echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

  // $response = $bitvavo->withdrawAssets("BTC", "1", "BitcoinAddress", []);
  // echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

  // foreach ($bitvavo->depositHistory([]) as $deposit) {
  //   echo json_encode($deposit, JSON_PRETTY_PRINT) . "\n";
  // }

  // foreach ($bitvavo->withdrawalHistory([]) as $withdrawal) {
  //   echo json_encode($withdrawal, JSON_PRETTY_PRINT) . "\n";
  // }
}

function testWebsocket($websock) {
  $websock->setErrorCallback(function($msg) {
    echo "Handle errors here" . json_encode($msg, JSON_PRETTY_PRINT) . "\n";
  });

  $websock->time(function($response) {
    echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  });
  // $websock->markets([], function($response) {
  //   foreach ($response as $market) {
  //     echo json_encode($market, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });
  // $websock->assets([], function($response) {
  //   foreach ($response as $asset) {
  //     echo json_encode($asset, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });

  // $websock->book("BTC-EUR", [], function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->publicTrades("BTC-EUR", [], function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->candles("LTC-EUR", "1h", [], function($response) {
  //   foreach ($response as $candle) {
  //     echo json_encode($candle, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });

  // $websock->ticker24h([], function($response) {
  //   foreach ($response as $ticker) {
  //     echo json_encode($ticker, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });
  // $websock->tickerPrice([], function($response) {
  //   foreach ($response as $price) {
  //     echo json_encode($price, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });
  // $websock->tickerBook([], function($response) {
  //   foreach ($response as $book) {
  //     echo json_encode($book, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });

  // $websock->placeOrder("BTC-EUR", "buy", "limit", ["amount" => "0.1", "price" => "1000"], function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->updateOrder("BTC-EUR", "961942de-9f78-48b5-9a90-3efd6ab66348", ["amount" => "0.2"], function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->getOrder("BTC-EUR", "961942de-9f78-48b5-9a90-3efd6ab66348", function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->cancelOrder("BTC-EUR", "961942de-9f78-48b5-9a90-3efd6ab66348", function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->getOrders("BTC-EUR", [], function($response) {
  //   foreach ($response as $order) {
  //     echo json_encode($order, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });
  // $websock->cancelOrders(["market" => "BTC-EUR"], function($response) {
  //   foreach ($response as $deletion) {
  //     echo json_encode($deletion, JSON_PRETTY_PRINT) . "\n"; 
  //   }
  // });
  // $websock->ordersOpen([], function($response) {
  //   foreach ($response as $order) {
  //     echo json_encode($order, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });

  // $websock->trades("BTC-EUR", [], function($response) {
  //   foreach ($response as $trade) {
  //     echo json_encode($trade, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });

  // $websock->balance([], function($response) {
  //   foreach ($response as $balance) {
  //     echo json_encode($balance, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });
  // $websock->depositAssets("BTC", function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->withdrawAssets("BTC", "1", "BitcoinAddress", [], function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->depositHistory([], function($response) {
  //   foreach ($response as $deposit) {
  //     echo json_encode($deposit, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });
  // $websock->withdrawalHistory([], function($response) {
  //   foreach ($response as $withdrawal) {
  //     echo json_encode($withdrawal, JSON_PRETTY_PRINT) . "\n";
  //   }
  // });

  // $websock->subscriptionTicker("BTC-EUR", function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->subscriptionAccount("BTC-EUR", function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->subscriptionCandles("BTC-EUR", "1h", function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->subscriptionTrades("BTC-EUR", function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->subscriptionBookUpdate("BTC-EUR", function($response){
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });
  // $websock->subscriptionBook("BTC-EUR", function($response) {
  //   echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
  // });

  $websock->startSocket();
}

main()

?>