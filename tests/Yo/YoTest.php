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

/**
 * Class YoTest
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class YoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_create_a_yo()
    {
        $yo = new Yo(['token' => 1234]);

        $this->assertNotEmpty($yo->getOptions());
        $this->assertArrayHasKey('base_url', $yo->getOptions());
        $this->assertArrayHasKey('token', $yo->getOptions());
        $this->assertInstanceOf('GuzzleHttp\Client', $yo->getHttpClient());
    }

    /**
     * @test
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function it_should_not_create_a_yo()
    {
        return new Yo();
    }
}
 