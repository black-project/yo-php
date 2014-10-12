<?php

namespace spec\Yo;

use Geo\Coordinates;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YoSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Yo\Yo');
    }

    function let()
    {
        $options = [
            'token' => 1234
        ];

        $this->beConstructedWith($options);
    }

    function it_should_have_an_http_client()
    {
        $this->getHttpClient()->shouldImplement('GuzzleHttp\Client');
    }

    function it_should_have_options()
    {
        $this->getOptions()->shouldBeArray();
        $this->getOptions()->shouldHaveCount(4);

        $this->getOptions()['token']->shouldReturn(1234);
        $this->getOptions()['link']->shouldReturn('');
        $this->getOptions()['location']->shouldReturn('');
    }

    function it_should_add_a_link()
    {
        $coordinates = new Coordinates(37.42242, -122.08585);
        $this->addLocation($coordinates);
        $this->addLink('http://www.google.com');

        $this->getOptions()['link']->shouldReturn('http://www.google.com');
        $this->getOptions()['location']->shouldBeNull();
    }

    function it_should_add_a_location()
    {
        $coordinates = new Coordinates(37.42242, -122.08585);
        $this->addLink('http://www.google.com');
        $this->addLocation($coordinates);

        $this->getOptions()['location']->shouldReturn('37.42242;-122.08585');
        $this->getOptions()['link']->shouldBeNull();

    }

    function it_should_ensure_valid_options()
    {
        $options = [
            'token' => 1234,
            'link' => 'http://www.google.com',
            'location' => '37.42242;-122.08585',
        ];

        $this->beConstructedWith($options);

        $this->getOptions()['link']->shouldBeNull();
    }

    function it_should_not_create_a_yo()
    {
        $this
            ->shouldThrow('\Symfony\Component\OptionsResolver\Exception\MissingOptionsException')
            ->during('__construct');
    }
}
