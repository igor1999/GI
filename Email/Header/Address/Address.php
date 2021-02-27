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
namespace GI\Email\Header\Address;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Address implements AddressInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $name = '';


    /**
     * Address constructor.
     *
     * @param string $email
     * @param string $name
     * @throws \Exception
     */
    public function __construct(string $email, string $name = '')
    {
        $this->setEmail($email)->setName($name);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return static
     * @throws \Exception
     */
    public function setEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->giThrowInvalidFormatException('Email', $email, 'email format');
        }

        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return empty($name) ? $this->email : $this->name . '<' . $this->email . '>';
    }
}