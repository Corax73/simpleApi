<?php
require_once '../vendor/autoload.php';
include 'config/const.php';

use Api\Classes\Controllers\ReportsController;

$api = new ReportsController();
print $api->run();
