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

use Yo\Service\SendYoService;
use Yo\Yo;
use GuzzleHttp\Client;

class SendYoServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    protected $service;

    /**
     * Replace this fake token with a real one
     */
    public function setUp()
    {
        $yo            = new Yo(['token' => 1234]);
        $httpClient    = new Client();
        $this->service = new SendYoService($httpClient, $yo->getOptions());
    }

    /**
     * @test
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 403
     */
    public function it_should_not_send_a_yo_to_all()
    {
        $yo         = new Yo(['token' => 1234]);
        $httpClient = new Client();
        $service    = new SendYoService($httpClient, $yo->getOptions());

        $service->yoAll();
    }

    /**
     * @test
     */
    public function it_should_send_a_yo_to_all()
    {
        $this->service->yoAll();
    }
} 