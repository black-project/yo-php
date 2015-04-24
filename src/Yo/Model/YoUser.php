<?php
/*
 * This file is part of the Yo package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yo\Model;

use Geo\Coordinates;

/**
 * Class YoUser
 */
class YoUser
{
    /**
     * @var
     */
    protected $username;

    /**
     * @var
     */
    protected $location;

    /**
     * @param $username
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return Coordinates
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param $coordinates
     */
    public function addLocation(Coordinates $coordinates)
    {
        $this->location = $coordinates;
    }
}
