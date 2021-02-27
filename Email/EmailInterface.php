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
namespace GI\Email;

use GI\Email\Body\BodyInterface;
use GI\Email\Header\HeaderInterface;

interface EmailInterface 
{
    /**
     * @return HeaderInterface
     */
    public function getHeader();

    /**
     * @return BodyInterface
     */
    public function getBody();

    /**
     * @return static
     * @throws \Exception
     */
    public function validate();

    /**
     * @return bool
     * @throws \Exception
     */
    public function send();

    /**
     * @return static
     */
    public function reset();
}