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
namespace GI\SocketDemon\Exchange\Response\Item;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ArrayExchangeTrait;
use GI\Pattern\Validation\ValidationTrait;

class Item implements ItemInterface
{
    use ServiceLocatorAwareTrait, ArrayExchangeTrait, ValidationTrait;


    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $data = '';

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @hydrate
     * @param string $id
     * @return static
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function hasData()
    {
        return !empty($this->data);
    }

    /**
     * @extract
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @hydrate
     * @param string $data
     * @return static
     */
    public function setData(string $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @extract
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @hydrate
     * @param bool $confirmed
     * @return static
     */
    public function setConfirmed(bool $confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * @extract
     * @return bool
     */
    public function isKill()
    {
        return $this->kill;
    }

    /**
     * @hydrate
     * @param bool $kill
     * @return static
     */
    public function setKill(bool $kill)
    {
        $this->kill = $kill;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateID()
    {
        if (empty($this->id)) {
            $this->getGiServiceLocator()->throwNotSetException('Response item ID');
        }
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateData()
    {
        if (empty($this->data)) {
            $this->getGiServiceLocator()->throwNotSetException('Response item data');
        }
    }
}