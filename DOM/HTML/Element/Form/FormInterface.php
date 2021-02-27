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
namespace GI\DOM\HTML\Element\Form;

use GI\DOM\HTML\Element\ContainerElementInterface;

interface FormInterface extends ContainerElementInterface
{
    /**
     * @param string $method
     * @return static
     * @throws \Exception
     */
    public function setMethod(string $method);

    /**
     * @return static
     */
    public function setMethodToGet();

    /**
     * @return static
     */
    public function setMethodToPost();

    /**
     * @param string $action
     * @return static
     */
    public function setAction(string $action);

    /**
     * @param string $target
     * @return static
     */
    public function setTarget(string $target);

    /**
     * @param string $encType
     * @return static
     * @throws \Exception
     */
    public function setEncType(string $encType);

    /**
     * @return static
     * @throws \Exception
     */
    public function setEncTypeToUrlEncoded();

    /**
     * @return static
     * @throws \Exception
     */
    public function setEncTypeToFormData();

    /**
     * @return static
     * @throws \Exception
     */
    public function setEncTypeToTextPlain();
}