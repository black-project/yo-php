<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yo\Event;


use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class YoSubscriber implements EventSubscriberInterface
{
    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return [
            'yo.receive' => ['onReceiveYo', 0]
        ];
    }

    /**
     * @param YoEvent $yo
     */
    public function onReceiveYo(YoEvent $event)
    {
        $this->logger->log('info', sprintf('Just received a new Yo from %s', $event->getYoUser()->getUsername()));
    }
} 