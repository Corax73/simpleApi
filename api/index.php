<?php
require_once '../vendor/autoload.php';
include 'config/const.php';

use Api\Classes\Controllers\ReportsApi;

$api = new ReportsApi();
print $api->run();
