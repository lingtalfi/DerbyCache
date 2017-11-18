DerbyCache
===========
2017-11-17



A persistent cache system. Daily rebuild using cron.


This is part of the [universe framework](https://github.com/karayabin/universe-snapshot).


Install
==========
Using the [uni](https://github.com/lingtalfi/universe-naive-importer) command.
```bash
uni import DerbyCache
```

Or just download it and place it where you want otherwise.


Playground
-------------
```php
<?php


use Core\Services\A;
use DerbyCache\FileSystemDerbyCache;

// using kamille framework here (https://github.com/lingtalfi/kamille)
require_once __DIR__ . "/../boot.php";
require_once __DIR__ . "/../init.php";


A::testInit();


//--------------------------------------------
// DERBY CACHE PLAYGROUND
//--------------------------------------------
/**
 * Creating two cars, just like that!
 * Note: I'm using a file system based derbyCache.
 */
$cache = FileSystemDerbyCache::create()->setRootDir("/tmp");

$car1 = $cache->get("Ekom/car--1", function () {
    return "I swear I'm a car, I swear";
});

$car2 = $cache->get("Ekom/car--2", function () {
    return "Vroom vroom (I'm the real cheat)";
});


a($car1); // "I swear I'm a car, I swear"
a($car2); // "Vroom vroom (I'm the real cheat)"


/**
 * Now deleting those cars, that was fun but every good thing has an end
 */
$cache->deleteByPrefix("Ekom/car--"); // will remove the files from our filesystem
```


History Log
------------------
    
- 1.1.0 -- 2017-11-18

    - add FileSystemDerbyCache hook system
    
- 1.0.0 -- 2017-11-17

    - initial commit