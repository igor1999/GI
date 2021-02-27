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
namespace GI\SocketDemon\Exchange\Response\Collection;

use GI\SocketDemon\Exchange\Response\Item\Item;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\SocketDemon\Exchange\Response\Item\ItemInterface;
use GI\SocketDemon\Exchange\Response\Result\Base\ResultInterface;
use GI\SocketDemon\Exchange\Request\SingleInterface as SingleRequestInterface;
use GI\SocketDemon\Exchange\Response\ORM\SocketRecordInterface;
use GI\SocketDemon\Exchange\Response\ORM\SocketSetInterface;
use GI\SocketDemon\Exchange\Response\ORM\DemonRecordInterface;

class Collection implements CollectionInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ItemInterface[]
     */
    private $items = [];


    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id)
    {
        return isset($this->items[$id]);
    }

    /**
     * @param string $id
     * @return ItemInterface
     * @throws \Exception
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            $this->giThrowNotInScopeException($id);
        }

        return $this->items[$id];
    }

    /**
     * @return ItemInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param ItemInterface $item
     * @return static
     */
    public function add(ItemInterface $item)
    {
        $this->items[$item->getId()] = $item;

        return $this;
    }

    /**
     * @param string $id
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addByIdAndResult(string $id, ResultInterface $result)
    {
        $item = $this->createItem();
        $item->setId($id)
            ->setConfirmed($result->isConfirmed())
            ->setKill($result->isKill())
            ->setData($result->toString());

        $this->add($item);

        return $this;
    }

    /**
     * @param SingleRequestInterface $request
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addByRequestAndResult(SingleRequestInterface $request, ResultInterface $result)
    {
        $this->addByIdAndResult($request->getId(), $result);

        return $this;
    }

    /**
     * @param SocketRecordInterface $socketRecord
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addBySocketRecord(SocketRecordInterface $socketRecord, ResultInterface $result)
    {
        $this->addByIdAndResult($socketRecord->getSocketId(), $result);

        return $this;
    }

    /**
     * @param SocketSetInterface $set
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    protected function addBySocketSet(SocketSetInterface $set, ResultInterface $result)
    {
        foreach ($set->getItems() as $record) {
            $this->addBySocketRecord($record, $result);
        }

        return $this;
    }

    /**
     * @param SocketRecordInterface $record
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addBySiblings(SocketRecordInterface $record, ResultInterface $result)
    {
        $this->addBySocketSet($record->getSiblings(), $result);

        return $this;
    }

    /**
     * @param SocketRecordInterface $record
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addByOtherSiblings(SocketRecordInterface $record, ResultInterface $result)
    {
        $this->addBySocketSet($record->getOtherSiblings(), $result);

        return $this;
    }

    /**
     * @param DemonRecordInterface $record
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addByDemon(DemonRecordInterface $record, ResultInterface $result)
    {
        $this->addBySocketSet($record->getSockets(), $result);

        return $this;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function remove(string $id)
    {
        if ($result = $this->has($id)) {
            unset($this->items[$id]);
        }

        return $result;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @param mixed $contents
     * @return static
     * @throws \Exception
     */
    public function fill(array $contents)
    {
        $this->clean();

        foreach ($contents as $id => $itemContents) {
            $item = $this->createItem();
            $item->hydrate($itemContents);
            $item->validateProperties();
            $this->add($item);
        }

        return $this;
    }

    /**
     * @return ItemInterface
     */
    protected function createItem()
    {
        try {
            $item = $this->giGetDi(ItemInterface::class);
        } catch (\Exception $e) {
            $item = new Item();
        }

        return $item;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function extract()
    {
        $result = [];

        foreach ($this->getItems() as $id => $item) {
            $result[$id] = $item->extract();
        }

        return $result;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getJSON()
    {
        return $this->giCreateJsonEncoder()->extractAndEncode($this);
    }
}