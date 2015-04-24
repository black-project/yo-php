Yo PHP
======

__Yo PHP__ is a [Yo][1] client written in PHP. This library is still a work in progress.

[![Build Status](https://travis-ci.org/black-project/yo-php.svg?branch=master)](https://travis-ci.org/black-project/yo-php)
[![HHVM Status](http://hhvm.h4cc.de/badge/black/yo-php.png)](http://hhvm.h4cc.de/package/black/yo-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/black-project/yo-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/black-project/yo-php/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/fa5c643c-812d-49ef-ac95-fb80a27a3d87/big.png)](https://insight.sensiolabs.com/projects/fa5c643c-812d-49ef-ac95-fb80a27a3d87)

Installation
------------

The recomanded way to install Yo PHP is through [Composer][2]:

```json
{
    "require": {
        "black/yo-php": "@stable"
    }
}
```

__Protip:__ You should browse the [`black/yo-php`][7] page to choose a stable version to use, avoid the `@stable` meta
constraint.

__Yotip:__ You want to know when yo-php is updated? Add YOPHPCLIENT \o/!

Usage
-----

#### `yoAll` nutshell:

The `yoAll` method will send a yo to all your friends.

```php

<?php

$yo   = new \Yo\Yo(['token' => 'yourtoken']);
$send = new \Yo\Service\SendYoService($yo->getHttpClient(), $yo->getOptions());
$send->yoAll();
```

#### `yo` nutshell:

The `yo` method will send a yo to a dedicated username. This username __MUST__ be in uppercase and this is your
responsibility.

```php

<?php

$yo   = new \Yo\Yo(['token' => 'yourtoken']);
$send = new \Yo\Service\SendYoService($yo->getHttpClient(), $yo->getOptions());
$send->yo('USERNAME');
```

#### `subscribers_count` nutshell:

The `subscribersCount` method will retrieve the number of your subscribers. This is just a GET request with a json
response.

```php

<?php

$yo     = new \Yo\Yo(['token' => 'yourtoken']);
$status = new \Yo\Service\StatusService($yo->getHttpClient(), $yo->getOptions());

$subscribers = $status->subscribersCount();

```


#### Send a link:

It is possible to send a link through Yo since 08/15/2014. Just add a `link` key to the constructor of `new Yo()` or
use `$yo->addLink('url://myurl.com');`.

```php
<?php

$yo   = new \Yo\Yo(['token' => 'yourtoken', 'link' => 'http://www.desicomments.com/dc/21/50927/50927.gif']);
$send = new \Yo\Service\SendYoService($yo->getHttpClient(), $yo->getOptions());
$send->yoAll();
```

```php
<?php

$yo   = new \Yo\Yo(['token' => 'yourtoken');
$yo->addLink('http://www.desicomments.com/dc/21/50927/50927.gif');

$send = new \Yo\Service\SendYoService($yo->getHttpClient(), $yo->getOptions());
$send->yoAll();
```

#### Send a location:

It is possible to send your location since 10/07/2014. Just add a `location` key to the constructor of `new Yo()` or
use this code.

```php

$coordinates = new Geo\Coordinates(latitude, longitude);
$yo->addLocation($coordinates);
```

__Warning 1__
It is not possible to receive or send link and location at the same time. When you construct a Yo with link and location,
link is always overrided to null.

If you use `->add(Location|Link)` function, the class will set the other parameter to null. The code is very simple so take
your time and look at the `src/spec/Yo/YoSpec.php`.

__Warning 2__
Yo api not using a valid format for coordinates. They use ";" instead of "," 
so be aware of this and don't forget to explode/convert your values (see example below).

#### Receive a yo:

During the registration process, Yo will ask to if you want to know when an Yo user Yo you. This pingback send you a
 GET request with the Yo `username` and `location` query parameters.

So... You need to create a dedicated controller. For example:

```php

<?php

namespace Yo\Controller;

class YoController
{
    public function yoAction($username, $location = null)
    {
        $yoUser   = new \Yo\Model\YoUser($username);
        
        if (null !== $location) {
            $location    = explode(";", $location);
            $coordinates = new Geo\Coordinates($location[0], $location[1]);
            $yoUser->addLocation($location);
        }

        $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
        $dispatcher->addSubscriber(new YourSubscriber());

        $yo = new \Yo\Service\ReceiveYoService($dispatcher);
        $yo->receive($yoUser);
    }
}
```

As you can see, the `ReceiveYoService` will dispatch an event named `yo.receive` and getting his information from a
`YoUser`.

I made the choice of create a true model because you maybe want to persist all your Yo friends in a database or
anything you want.

A "default" subscriber is located in `Yo/Event` directory. This `YoSubscriber` will add a new line in your Monolog logs.
If you want to use it, use this sample code (or see the `./tests/Yo/ReceiveYoServiceTest`:

```php

<?php

namespace Yo\Controller;

class YoController
{
    public function yoAction($username)
    {
        $yoUser     = new \Yo\Model\YoUser($username);
        $logger     = new \Monolog\Logger();
        $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $dispatcher->addSubscriber(new \Yo\Event\YoSubscriber($logger));

        $yo = new \Yo\Service\ReceiveYoService($dispatcher);
        $yo->receive($yoUser);
    }
}
```

Running the tests
-----------------

Rename (or copy) the `config.php.dist` to `config.php` and add your token. Then run the suite tests.

Contributing
------------

See CONTRIBUTING file.

Credits
-------

This README is heavily inspired by [Hateoas][4] library by the great [@willdurand][8]. This guy needs your [PR][5] for the
sake of the REST in PHP.

Alexandre "pocky" Balmes [alexandre@lablackroom.com][3]. Send me [Flattrs][6] if you love my work, [buy me gift][9] or hire me!


License
-------
Yo PHP is released under the MIT License. See the bundled LICENSE file for details.

[1]: http://www.justyo.co/
[2]: http://getcomposer.org/
[3]: mailto:alexandre@lablackroom.com
[4]: https://github.com/willdurand/Hateoas
[5]: http://williamdurand.fr/2014/07/02/resting-with-symfony-sos/
[6]: https://flattr.com/profile/alexandre.balmes
[7]: https://packagist.org/packages/black/yo-php
[8]: https://github.com/willdurand
[9]: http://www.amazon.fr/registry/wishlist/3OR3EENRA5TSK
