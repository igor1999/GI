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

use GI\Pattern\ArrayExchange\ExtractionInterface;
use GI\SocketDemon\Exchange\Response\Item\ItemInterface;
use GI\SocketDemon\Exchange\Response\Result\Base\ResultInterface;
use GI\SocketDemon\Exchange\Request\SingleInterface as SingleRequestInterface;
use GI\SocketDemon\Exchange\Response\ORM\SocketRecordInterface;
use GI\SocketDemon\Exchange\Response\ORM\DemonRecordInterface;

interface CollectionInterface extends ExtractionInterface
{
    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id);

    /**
     * @param string $id
     * @return ItemInterface
     * @throws \Exception
     */
    public function get(string $id);

    /**
     * @return ItemInterface[]
     */
    public function getItems();

    /**
     * @param ItemInterface $item
     * @return static
     */
    public function add(ItemInterface $item);

    /**
     * @param string $id
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addByIdAndResult(string $id, ResultInterface $result);

    /**
     * @param SingleRequestInterface $request
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addByRequestAndResult(SingleRequestInterface $request, ResultInterface $result);

    /**
     * @param SocketRecordInterface $socketRecord
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addBySocketRecord(SocketRecordInterface $socketRecord, ResultInterface $result);

    /**
     * @param SocketRecordInterface $record
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addBySiblings(SocketRecordInterface $record, ResultInterface $result);

    /**
     * @param SocketRecordInterface $record
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addByOtherSiblings(SocketRecordInterface $record, ResultInterface $result);

    /**
     * @param DemonRecordInterface $record
     * @param ResultInterface $result
     * @return static
     * @throws \Exception
     */
    public function addByDemon(DemonRecordInterface $record, ResultInterface $result);

    /**
     * @param string $id
     * @return bool
     */
    public function remove(string $id);

    /**
     * @return static
     */
    public function clean();

    /**
     * @param mixed $contents
     * @return static
     * @throws \Exception
     */
    public function fill(array $contents);

    /**
     * @return string
     * @throws \Exception
     */
    public function getJSON();
}