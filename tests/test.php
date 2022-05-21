<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ismystore\checkip\CheckIP;

$check = new CheckIP("173.252.110.27");
var_dump($check->getCountry()); # United States
var_dump($check->getEuropean()); # false
# Read the README for more functions