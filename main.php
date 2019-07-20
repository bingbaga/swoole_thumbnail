<?php
require 'Load.php';
spl_autoload_register('Load::autoload');

use app\Handle;

$http = new Swoole\Http\Server('0.0.0.0', 9501);
echo 'Server started'.PHP_EOL;
$http->on('request', function ($request, $response) {
    $handle = new Handle($request, $response);
    $handle->image();
});
$http->start();
