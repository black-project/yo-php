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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Yo\Event\YoEvent;
use Yo\Model\YoUser;

/**
 * Class ReceiveYoService
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ReceiveYoService
{
    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param YoUser $user
     */
    public function receive(YoUser $user)
    {
        $event = new YoEvent($user);
        $this->dispatcher->dispatch('yo.receive', $event);
    }
} 