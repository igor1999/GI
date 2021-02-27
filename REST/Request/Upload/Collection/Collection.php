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
namespace GI\REST\Request\Upload\Collection;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Closing\ClosingTrait;
use GI\REST\Request\Upload\UploadTrait;

use GI\REST\Request\Upload\Item\ItemInterface;
use GI\REST\Request\Upload\UploadInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;

class Collection implements CollectionInterface
{
    use ClosingTrait, ServiceLocatorAwareTrait, UploadTrait;


    /**
     * @var UploadInterface[]
     */
    private $items = [];


    /**
     * Collection constructor.
     * @param UploadInterface[] $items
     * @throws \Exception
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->set($key, $item);
        }
    }

    /**
     * @param string|int $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param string|int $key
     * @return UploadInterface
     * @throws \Exception
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            $this->giThrowNotInScopeException($key);
        }

        return $this->items[$key];
    }

    /**
     * @return UploadInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return UploadInterface[]
     */
    public function getItemsRecursive()
    {
        $f = function(UploadInterface $item)
        {
            return ($item instanceof CollectionInterface) ? $item->getItemsRecursive() : $item;
        };

        return array_map($f, $this->items);
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param string|int $key
     * @param UploadInterface $item
     * @return static
     * @throws \Exception
     */
    public function set($key, UploadInterface $item)
    {
        $this->validateClosing();

        $this->items[$key] = $item;

        return $this;
    }

    /**
     * @param string|int $key
     * @return static
     * @throws \Exception
     */
    public function removeItem($key)
    {
        $this->validateClosing();

        unset($this->items[$key]);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function clean()
    {
        $this->validateClosing();

        $this->items = [];

        return $this;
    }

    /**
     * @param array $types
     * @return boolean
     */
    public function validateMimeType(array $types)
    {
        $result = true;

        foreach ($this->items as $item) {
            $result = $result && $item->validateMimeType($types);
        }

        return $result;
    }

    /**
     * @param int|null $min
     * @param int|null $max
     * @return boolean
     */
    public function validateSize(int $min = null, int $max = null)
    {
        $result = true;

        foreach ($this->items as $item) {
            $result = $result && $item->validateSize($min, $max);
        }

        return $result;
    }

    /**
     * @return boolean
     */
    public function validateError()
    {
        $result = true;

        foreach ($this->items as $item) {
            $result = $result && $item->validateError();
        }

        return $result;
    }

    /**
     * @return static
     */
    public function remove()
    {
        foreach ($this->items as $item) {
            $item->remove();
        }

        return $this;
    }

    /**
     * @param FSODirInterface $targetDir
     * @return static
     * @throws \Exception
     */
    public function upload(FSODirInterface $targetDir)
    {
        foreach ($this->items as $key => $item) {
            /** @var ItemInterface|CollectionInterface $item */
            $item->upload($targetDir);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function extract()
    {
        $result = [];

        foreach ($this->items as $key => $item) {
            $result[$key] = $item->extract();
        }

        return $result;
    }

    /**
     * @param array $contents
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $contents)
    {
        $creating = $this->createCreator()->create($contents);

        if ($creating instanceof CollectionInterface) {
            $this->items = $creating->getItems();
        } else {
            $this->items = [$creating];
        }

        if ($this->isClosed()) {
            $this->close();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->setClosed(true);

        foreach ($this->items as $item) {
            if ($item instanceof CollectionInterface) {
                $item->close();
            }
        }

        return $this;
    }
}