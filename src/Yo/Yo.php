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

use Geo\Coordinates;
use GuzzleHttp\Client;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Yo
 */
final class Yo
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
        $this->ensureValidOptions();

        $this->httpClient = new Client();
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $link
     */
    public function addLink($link)
    {
        if ("" !== $this->options['location']) {
            $this->options['location'] = null;
        }

        if ($link && filter_var($link, FILTER_VALIDATE_URL)) {
            $this->options['link'] = $link;
        }
    }

    /**
     * @param Coordinates $coordinates
     */
    public function addLocation(Coordinates $coordinates)
    {
        if ("" !== $this->options['link']) {
            $this->options['link'] = null;
        }

        $this->options['location'] = $coordinates->getLatitude() . ';' . $coordinates->getLongitude();
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['token']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'base_url' => 'http://api.justyo.co',
            'link' => '',
            'location' => '',
        ]);
    }

    /**
     *
     */
    protected function ensureValidOptions()
    {
        $options = $this->getOptions();

        if ("" !== $options['link'] && "" !== $options['location']) {
            $this->options['link'] = null;
        }
    }
}
