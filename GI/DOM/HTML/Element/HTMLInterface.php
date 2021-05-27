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
namespace GI\DOM\HTML\Element;

use GI\DOM\Base\Element\ElementInterface;
use GI\DOM\HTML\Attributes\AttributesInterface;
use GI\DOM\HTML\Attributes\Classes\ClassesInterface;
use GI\DOM\HTML\Attributes\Name\NameInterface;
use GI\DOM\HTML\Attributes\Style\StyleInterface;

interface HTMLInterface extends ElementInterface
{
    const ATTRIBUTE_GI_ID = 'gi-id';


    /**
     * @return AttributesInterface
     */
    public function getAttributes();

    /**
     * @return NameInterface
     */
    public function getName();

    /**
     * @return ClassesInterface
     */
    public function getClasses();

    /**
     * @return StyleInterface
     */
    public function getStyle();

    /**
     * @return static
     */
    public function show();

    /**
     * @return static
     */
    public function hide();

    /**
     * @param bool $visible
     * @return static
     */
    public function setVisibility(bool $visible);

    /**
     * @return bool
     * @throws \Exception
     */
    public function hasGIId();

    /**
     * @return string
     * @throws \Exception
     */
    public function getGIId();

    /**
     * @param string $giId
     * @return static
     * @throws \Exception
     */
    public function setGIId(string $giId);
}