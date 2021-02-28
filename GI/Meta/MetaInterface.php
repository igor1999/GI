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
namespace GI\Meta;

use GI\Meta\ClassMeta\ClassMetaInterface;
use GI\Meta\ClassMeta\Collection\AlterableInterface as ClassMetaCollectionInterface;
use GI\Meta\Method\Collection\AlterableInterface as MethodCollectionInterface;
use GI\Meta\Method\MethodInterface;
use GI\Meta\Property\Collection\AlterableInterface as PropertyCollectionInterface;
use GI\Meta\Property\PropertyInterface;
use GI\Meta\CopyMaker\CopyMakerInterface;

interface MetaInterface
{
    /**
     * @param mixed $source
     * @return bool
     */
    public function hasClassMeta($source);

    /**
     * @param mixed $source
     * @return ClassMetaInterface
     */
    public function getClassMeta($source);

    /**
     * @param ClassMetaInterface[] $items
     * @return ClassMetaCollectionInterface
     */
    public function createClassMetaCollection(array $items = []);

    /**
     * @param MethodInterface[] $items
     * @return MethodCollectionInterface
     */
    public function createMethodCollection(array $items = []);

    /**
     * @param PropertyInterface[] $items
     * @return PropertyCollectionInterface
     */
    public function createPropertyCollection(array $items = []);

    /**
     * @param string|null $caller
     * @return CopyMakerInterface
     */
    public function getCopyMaker(string $caller = null);
}