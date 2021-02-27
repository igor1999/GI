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
namespace GI\REST\Response\Header\Refresh;

use GI\REST\Response\Header\AbstractHeader;

class Refresh extends AbstractHeader implements RefreshInterface
{
    const KEY = 'Refresh';


    /**
     * @var int
     */
    private $time = 0;

    /**
     * @var string
     */
    private $url = '';


    /**
     * Refresh constructor.
     * @param int $time
     * @param string $url
     */
    public function __construct(int $time, string $url)
    {
        $this->time = $time;
        $this->url  = $url;

        parent::__construct(static::KEY,'');
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->time . ';url=' . $this->url;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}