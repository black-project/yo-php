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

use GuzzleHttp\Client;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yo\Service\SendYoService;

/**
 * Class Yo
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class Yo
{
    protected $httpClient;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Service\SendYoService
     */
    protected $sendService;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);
        $this->configureOptions($resolver);

        $this->options     = $resolver->resolve($options);
        $this->httpClient  = new Client();
        $this->sendService = new SendYoService($this->httpClient, $this->options);
    }

    /**
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function yoAll()
    {
        return $this->sendService->yoAll();
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
     * @param OptionsResolverInterface $resolver
     */
    protected function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['token']);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                'base_url' => 'http://api.justyo.co/'
            ]);
    }
} 