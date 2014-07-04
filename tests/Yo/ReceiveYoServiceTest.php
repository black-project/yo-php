<?php
/*
 * This file is part of the Yo package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yo;

use Monolog\Handler\TestHandler;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Yo\Event\Yo2Subscriber;
use Yo\Event\YoSubscriber;
use Yo\Model\YoUser;
use Yo\Service\ReceiveYoService;
use Yo\Service\SendYoService;

class ReceiveYoServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    protected $user;

    /**
     * @var
     */
    protected $logger;

    /**
     * @var
     */
    protected $handler;

    public function setUp()
    {
        $this->user    = new YoUser('fakeuser');
        $this->logger  = new Logger('test');
        $this->handler = new TestHandler();

        $this->logger->pushHandler($this->handler);
    }

    /**
     * @test
     */
    public function it_should_dispatch_a_yo()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new YoSubscriber($this->logger));

        $receive = new ReceiveYoService($dispatcher);
        $receive->receive($this->user);

        $this->assertTrue(true, $this->handler->hasInfo('Just received a new Yo from fakeuser'));
    }
}