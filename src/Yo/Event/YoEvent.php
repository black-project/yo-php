<?php
/*
 * This file is part of the Yo package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yo\Event;

use Symfony\Component\EventDispatcher\Event;
use Yo\Model\YoUser;

/**
 * Class YoEvent
 */
final class YoEvent extends Event
{
    /**
     * @var \Yo\Model\YoUser
     */
    private $yoUser;

    /**
     * @param YoUser $yoUser
     */
    public function __construct(YoUser $yoUser)
    {
        $this->yoUser = $yoUser;
    }

    /**
     * @return YoUser
     */
    public function getYoUser()
    {
        return $this->yoUser;
    }
}
