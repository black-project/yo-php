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

/**
 * Class SendYoServiceTest
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
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
        $this->yo = new Yo(['token' => 'myToken']);
    }

    /**
     * This test is invalid because endpoint return 201 with a wrong token
     *
     * @expectedException Yo\Exception\BadResponseException
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
        $this->assertEquals('201', $send->yoAll()->getStatusCode());
    }
}