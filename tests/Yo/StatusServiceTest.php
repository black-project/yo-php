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

use Yo\Service\StatusService;

/**
 * Class StatusServiceTest
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class StatusServiceTest extends \PHPUnit_Framework_TestCase
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
     * @test
     */
    public function it_should_return_subscribers()
    {
        $status = new StatusService($this->yo->getHttpClient(), $this->yo->getOptions());

        $subscribers = $status->subscribersCount()->json();

        $this->assertEquals('1', $subscribers['result']);

    }
}
