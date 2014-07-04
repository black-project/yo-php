Yo PHP
======

__Yo PHP__ is a [Yo][1] client written in PHP. This library is still a work in progress. The yoall method is supported and it's
actually the only endpoint of the API but a receive service will be available for trigger a Yo sent to your API key.

Warning
-------

I don't have receive my API key so I am not sure if the `yoAll` method works well because I don't know the status code
for the response so... be patient or create a PR ;)

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

__Protip:__ you should browse the `black/yo-php`page to choose a stable version to use, avoid the `@stable` meta
constraint.

Usage
-----

In a nutshell:

```php

<?php

$yo = new \Yo(['token' => 'yourtoken']);
$yo->yoAll();
```

The `yoAll` method will send a yo to all your friends.

Running the tests
-----------------

There is no developement key for Yo so the only way to pass the tests suite is to replace the fake token and run the
suites.

Contributing
------------

See CONTRIBUTING file.

Credits
-------

This README heavily inspired by [Hateoas][4] by @willdurand and he needs your [PR][5].

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