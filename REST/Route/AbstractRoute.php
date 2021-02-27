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
namespace GI\REST\Route;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Closing\ClosingTrait;

abstract class AbstractRoute implements RouteInterface
{
    use ServiceLocatorAwareTrait, ClosingTrait;


    /**
     * @var string
     */
    private $source = '';

    /**
     * @var bool
     */
    private $valid = false;


    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return static
     * @throws \Exception
     */
    protected function setSource(string $source)
    {
        $this->validateClosing();

        $this->source = $source;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     * @return static
     * @throws \Exception
     */
    protected function setValid(bool $valid)
    {
        $this->validateClosing();

        $this->valid = $valid;

        return $this;
    }

    /**
     * @param string $param
     * @param mixed $default
     * @return string
     */
    public function getParamOptional(string $param, $default = '')
    {
        try {
            $result = $this->getParam($param);
        } catch (\Exception $e) {
            $result = $default;
        }

        return $result;
    }
}