Yo PHP
======

__Yo PHP__ is a [Yo][1] client written in PHP. This library is still a work in progress. The yoall method is supported and it's
actually the only endpoint of the API but a receive service will be available for trigger a Yo sent to your API key.

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

__Protip:__ you should browse the [`black/yo-php`][7] page to choose a stable version to use, avoid the `@stable` meta
constraint.

Usage
-----

__`yoAll` nutshell:__

_The `yoAll` method will send a yo to all your friends._

```php

<?php

$yo   = new \Yo\Yo(['token' => 'yourtoken']);
$send = new \Yo\Service\SendYoService($yo->getHttpClient(), $yo->getOptions());
$send->yoAll();
```

__Receive a yo:__

During the registration process, Yo will ask to if you want to know when an Yo user Yo you. This pingback send you a
 GET request with the Yo `username` query parameter.

So... You need to create a dedicated controller. For example:

```php

<?php

namespace Yo\Controller;

class YoController
{
    public function yoAction($username)
    {
        $yoUser     = new \Yo\Model\YoUser($username);
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
        $logger     = new Monolog\Logger();
        $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $dispatcher->addSubscriber(new \Yo\Event\YoSubscriber($logger));

        $yo = new \Yo\Service\ReceiveYoService($dispatcher);
        $yo->receive($yoUser);
    }
}
```


Running the tests
-----------------

There is no development key for Yo so the only way to pass the tests suite is to replace the fake token and run the
test suite.

Contributing
------------

See CONTRIBUTING file.

Credits
-------

This README is heavily inspired by [Hateoas][4] library by the great [@willdurand][8]. This guy needs your [PR][5] for the
sake of the REST in PHP.

Alexandre "pocky" Balmes [alexandre@lablackroom.com][3]. Send me [Flattrs][6] if you love my work or hire me!


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