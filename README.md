# CheckIP

A composer module to retrieve information from an IP address, using [geoplugin.net](www.geoplugin.net)

## Installation

Use composer to install CheckIP

```bash
composer require ismystore/checkip
```

## Usage

```php
<?php

use ismystore\checkip\CheckIP;

class MyAwesomeClass{
    public function getMyPlayer(Person $person){
        $ip = $person->getAddress();
        $check = new CheckIP($ip);
        
        $msg = "";
        $msg .= "Your country is: ".$check->getCountry()."\n";
        $msg .= "Your country code is: ".$check->getCountryCode()."\n";
        $msg .= "Your region code is: ".$check->getRegionCode()."\n";
        $msg .= "Your state/region name is: ".$check->getState()."\n";
        $msg .= "Your city is: ".$check->getCity()."\n";
        $msg .= "Your address is: ".$check->getAddress()."\n";
        $msg .= "Is a european country ? ".($check->getEuropean() ? "Yes" : "No")."\n";
        $msg .= "Your timezone is: ".$check->getTimezone()."\n";
        $msg .= "Your currency code is: ".$check->getCurrencyCode()." (".$check->getCurrencySymbol().")\n";
        $person->send($msg);
   }
}
```

## Test

Make sure you are at the root of the module

```bash
php tests/test.php 
```