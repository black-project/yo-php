<?php

/*
 * This file is part of the Yo package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yo\Exception;

/**
 * Class BadResponseException
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class BadResponseException extends \Exception
{
    /**
     * @param string $statusCode
     * @param null   $message
     */
    public function __construct($statusCode, $message = null)
    {
        $message = $message ?: 'Status code:' . $statusCode;

        parent::__construct($message, (integer) $statusCode);
    }
}
