<?php
require_once 'vendor/autoload.php';

$client = new GuzzleHttp\Client();
$res = $client->request('GET', 'http://ifconfig.co/ip');

echo $res->getStatusCode() . PHP_EOL;
echo $res->getBody() . PHP_EOL;
