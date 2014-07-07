<?php
/*
 * This file is part of the Yo package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yo\Service;

use Yo\Exception\BadResponseException;
use GuzzleHttp\Client as HttpClient;

/**
 * Class SendYoService
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class SendYoService
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
     * @param HttpClient $httpClient
     * @param array $options
     */
    public function __construct(HttpClient $httpClient, array $options = [])
    {
        $this->options = $options;
        $this->httpClient = $httpClient;
    }

    /**
     * @return \GuzzleHttp\Message\ResponseInterface
     * @throws \Yo\Exception\BadResponseException
     */
    public function yoAll()
    {
        $response = $this->httpClient->post(
            $this->options['base_url'] . '/yoall/',
            ['body' => ['api_token' => $this->options['token']]]
        );

        if ("201" !== $response->getStatusCode()) {
            throw new BadResponseException($response->getStatusCode(), (string) $response->getBody());
        }

        return $response;
    }

    /**
     * @param $username
     *
     * @return \GuzzleHttp\Message\ResponseInterface
     * @throws \Yo\Exception\BadResponseException
     */
    public function yo($username)
    {
        $response = $this->httpClient->post(
            $this->options['base_url'] . '/yo/',
            ['body' => [
                'api_token' => $this->options['token'],
                'username' => $username
            ]]
        );

        if ("201" !== $response->getStatusCode()) {
            throw new BadResponseException($response->getStatusCode(), (string) $response->getBody());
        }

        return $response;
    }
} 