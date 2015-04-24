<?php
/*
 * This file is part of the Yo package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Yo;

use Geo\Coordinates;
use PhpSpec\ObjectBehavior;

/**
 * Class YoSpec
 */
class YoSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Yo\Yo');
    }

    public function let()
    {
        $options = [
            'token' => 1234
        ];

        $this->beConstructedWith($options);
    }

    public function it_should_have_an_http_client()
    {
        $this->getHttpClient()->shouldImplement('GuzzleHttp\Client');
    }

    public function it_should_have_options()
    {
        $this->getOptions()->shouldBeArray();
        $this->getOptions()->shouldHaveCount(4);

        $this->getOptions()['token']->shouldReturn(1234);
        $this->getOptions()['link']->shouldReturn('');
        $this->getOptions()['location']->shouldReturn('');
    }

    public function it_should_add_a_link()
    {
        $coordinates = new Coordinates(37.42242, -122.08585);
        $this->addLocation($coordinates);
        $this->addLink('http://www.google.com');

        $this->getOptions()['link']->shouldReturn('http://www.google.com');
        $this->getOptions()['location']->shouldBeNull();
    }

    public function it_should_add_a_location()
    {
        $coordinates = new Coordinates(37.42242, -122.08585);
        $this->addLink('http://www.google.com');
        $this->addLocation($coordinates);

        $this->getOptions()['location']->shouldReturn('37.42242;-122.08585');
        $this->getOptions()['link']->shouldBeNull();

    }

    public function it_should_ensure_valid_options()
    {
        $options = [
            'token' => 1234,
            'link' => 'http://www.google.com',
            'location' => '37.42242;-122.08585',
        ];

        $this->beConstructedWith($options);

        $this->getOptions()['link']->shouldBeNull();
    }

    public function it_should_not_create_a_yo()
    {
        $this
            ->shouldThrow('\Symfony\Component\OptionsResolver\Exception\MissingOptionsException')
            ->during('__construct');
    }
}
