<?php
require __DIR__.'/Libraries/Request.php';

if (count($argv) < 4) {
    echo "Invalid parameters.". PHP_EOL;
    echo "Usages :: php Run.php {auth_key} {http method} {uri} {parameter} {header};". PHP_EOL;
    exit;
}
if (empty($argv[1]) || empty($argv[2]) || empty($argv[3])) {
    echo "Please check parameters.". PHP_EOL;
    exit;
}

$auth_key = $argv[1] ?? "";
$method = $argv[2] ?? "";
$uri = $argv[3] ?? "";
$parameters = $argv[4] ?? "";
$headers =  $argv[5] ?? "";
$curlOptions =  $argv[6] ?? "";

try {
    $request = new \Libraries\RequestAPI($auth_key);
    $request->setMethod($method);
    $request->setRequestUri($uri);
    $request->setRequestParam($parameters);
    $request->setHeaders($headers);
    $request->setOptions($curlOptions);
    
    $request->callApi();
} catch (\Exception $e) {
    echo "[ERROR] code: ".$e->getMessage(). PHP_EOL;
    exit;
}
