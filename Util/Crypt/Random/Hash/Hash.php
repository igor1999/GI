<?php
/*
 * This file is part of PHP-framework GI.
 *
 * PHP-framework GI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP-framework GI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP-framework GI. If not, see <https://www.gnu.org/licenses/>.
 */
namespace GI\Util\Crypt\Random\Hash;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Hash implements HashInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_LENGTH = 40;


    const RANDOM_MIN = 100000;

    const RANDOM_MAX = 100000000;


    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function create(int $length = 0)
    {
        if ($length <= 0) {
            $length = static::DEFAULT_LENGTH;
        }

        switch (true) {
            case function_exists('random_bytes'):
                $result = bin2hex(random_bytes($length));
                break;
            case function_exists('openssl_random_pseudo_bytes'):
                $strong = true;
                $result = bin2hex(openssl_random_pseudo_bytes($length, $strong));
                break;
            default:
                $result = $this->createDefault($length);
                break;
        }

        return $result;
    }

    /**
     * @param int $length
     * @return string
     */
    protected function createDefault(int $length)
    {
        $result = '';

        while (strlen($result) < $length) {
            $result .= SHA1(rand(static::RANDOM_MIN, static::RANDOM_MAX) . microtime(true));
        }

        if (strlen($result) > $length) {
            $result = substr($result, 0, $length);
        }

        return $result;
    }
}