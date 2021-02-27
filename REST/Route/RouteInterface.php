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

use GI\Pattern\Closing\ClosingInterface;
use GI\REST\Request\Server\ServerInterface;

interface RouteInterface extends ClosingInterface
{
    /**
     * @return string
     */
    public function getSource();

    /**
     * @return bool
     */
    public function isValid();

    /**
     * @param string $param
     * @return bool
     */
    public function hasParam(string $param);

    /**
     * @param string $param
     * @return string
     * @throws \Exception
     */
    public function getParam(string $param);

    /**
     * @param string $param
     * @param mixed $default
     * @return string
     */
    public function getParamOptional(string $param, $default = '');

    /**
     * @param string $source
     * @return bool
     */
    public function validateByString(string $source);

    /**
     * @param ServerInterface $server
     * @return bool
     */
    public function validateByServer(ServerInterface $server);
}