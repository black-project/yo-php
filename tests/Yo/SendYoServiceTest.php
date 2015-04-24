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

use DI\ContainerBuilder;
use Geo\Coordinates;
use Yo\Service\SendYoService;

/**
 * Class SendYoServiceTest
 */
class SendYoServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    protected $yo;

    /**
     * Replace this fake token with a real one
     */
    public function setUp()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/../config.php');

        $container = $builder->build();
        $this->yo  = new Yo(['token' => $container->get('api.token')]);
    }

    /**
     * @expectedException \GuzzleHttp\Exception\ClientException
     */
    public function it_should_not_send_a_yo_to_all()
    {
        $yo   = new Yo(['token' => 'errorToken']);
        $send = new SendYoService($yo->getHttpClient(), $yo->getOptions());

        $send->yoAll();
    }

    /**
     * @test
     */
    public function it_should_send_a_yo_to_all()
    {
        $send = new SendYoService($this->yo->getHttpClient(), $this->yo->getOptions());
        $this->assertEquals('200', $send->yoAll()->getStatusCode());
    }

    /**
     * @test
     * @expectedException \GuzzleHttp\Exception\ClientException
     */
    public function it_should_not_send_a_yo_because_we_are_not_friend()
    {
        $send = new SendYoService($this->yo->getHttpClient(), $this->yo->getOptions());
        $send->yo('FAKEUSERNAMEWAIWAI');
    }

    /**
     * @test
     */
    public function it_should_send_a_yo_to_a_friend()
    {
        $send = new SendYoService($this->yo->getHttpClient(), $this->yo->getOptions());
        $this->assertEquals('200', $send->yo('POCKYSTAR')->getStatusCode());
    }

    /**
     * @test
     */
    public function it_should_send_a_yo_with_link()
    {
        $this->yo->addLink('http://www.desicomments.com/dc/21/50927/50927.gif');

        $send = new SendYoService($this->yo->getHttpClient(), $this->yo->getOptions());
        $this->assertEquals('200', $send->yoAll()->getStatusCode());
    }

    /**
     * @test
     */
    public function it_should_send_a_yo_with_location()
    {
        $coordinates = new Coordinates(37.42242, -122.08585);
        $this->yo->addLocation($coordinates);

        $send = new SendYoService($this->yo->getHttpClient(), $this->yo->getOptions());
        $this->assertEquals('200', $send->yoAll()->getStatusCode());
    }
}
