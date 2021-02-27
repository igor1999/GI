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
namespace GI\SocketDemon\Exchange\Response\Result\Base;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ExtractionTrait;

abstract class AbstractResult implements ResultInterface
{
    use ServiceLocatorAwareTrait, ExtractionTrait;


    const TITLE = '';


    /**
     * @var bool
     */
    private $confirmed = false;

    /**
     * @var bool
     */
    private $kill = false;


    /**
     * @extract
     * @return string
     */
    public function getTitle()
    {
        return static::TITLE;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param bool $confirmed
     * @return static
     */
    protected function setConfirmed(bool $confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * @return bool
     */
    public function isKill()
    {
        return $this->kill;
    }

    /**
     * @param bool $kill
     * @return static
     */
    protected function setKill(bool $kill)
    {
        $this->kill = $kill;

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getJSON()
    {
        return $this->giCreateJsonEncoder()->extractAndEncode($this);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getJSON();
    }
}