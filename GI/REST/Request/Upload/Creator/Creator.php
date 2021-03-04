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
namespace GI\REST\Request\Upload\Creator;

use GI\REST\Request\Upload\Collection\Collection;
use GI\REST\Request\Upload\Item\Item;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\REST\Request\Upload\Collection\CollectionInterface;
use GI\REST\Request\Upload\Item\ItemInterface;
use GI\REST\Request\Upload\UploadInterface;

class Creator implements CreatorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @param array $contents
     * @return ItemInterface|CollectionInterface
     * @throws \Exception
     */
    public function create(array $contents)
    {
        if ($this->isItem($contents)) {
            $result = $this->createItem(
                $contents['name'], $contents['type'], $contents['tmp_name'],
                $contents['size'], $contents['error']
            );
        } elseif ($this->isCollection($contents)) {
            $result = $this->create($this->convertArray($contents));
        } else {
            $items = [];
            foreach ($contents as $key => $itemContent) {
                $items[$key] = $this->create($itemContent);
            }
            $result = $this->createCollection($items);
        }

        return $result;
    }

    /**
     * @param array $itemContent
     * @return bool
     */
    protected function isItem(array $itemContent)
    {
        return !empty($itemContent['name']) && is_string($itemContent['name'])
            && !empty($itemContent['type']) && is_string($itemContent['type'])
            && !empty($itemContent['tmp_name']) && is_string($itemContent['tmp_name'])
            && !empty($itemContent['size']) && is_scalar($itemContent['size'])
            && !empty($itemContent['error']) && is_scalar($itemContent['error']);
    }

    /**
     * @param string $name
     * @param string $mimeType
     * @param string $tmpName
     * @param int $size
     * @param int $error
     * @return Item
     */
    protected function createItem(string $name, string $mimeType, string $tmpName, int $size, int $error)
    {
        try {
            $result = $this->giGetDi(
            ItemInterface::class,null, [$name, $mimeType, $tmpName, $size, $error]
            );
        } catch (\Exception $e) {
            $result = new Item($name, $mimeType, $tmpName, $size, $error);
        }

        return $result;
    }

    /**
     * @param array $itemContent
     * @return bool
     */
    protected function isCollection(array $itemContent)
    {
        return !empty($itemContent['name']) && is_array($itemContent['name'])
            && !empty($itemContent['type']) && is_array($itemContent['type'])
            && !empty($itemContent['tmp_name']) && is_array($itemContent['tmp_name'])
            && !empty($itemContent['size']) && is_array($itemContent['size'])
            && !empty($itemContent['error']) && is_array($itemContent['error']);
    }

    /**
     * @param UploadInterface[] $items
     * @return Collection
     * @throws \Exception
     */
    protected function createCollection(array $items)
    {
        try {
            $result = $this->giGetDi(CollectionInterface::class,null, [$items]);
        } catch (\Exception $e) {
            $result = new Collection($items);
        }

        return $result;
    }

    /**
     * @param array $itemContent
     * @return array
     */
    protected function convertArray(array $itemContent)
    {
        $newContent = [];

        foreach ($itemContent as $attribute => $attributeContent) {
            foreach ($attributeContent as $key => $value) {
                $newContent[$key][$attribute] = $value;
            }
        }

        return $newContent;
    }
}