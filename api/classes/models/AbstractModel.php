<?php

namespace Api\Classes\Models;

use Api\Classes\Models\Connect;

class AbstractModel
{
    protected Connect $connect;

    public function __construct() {
        $this->connect = new Connect;
    }
}