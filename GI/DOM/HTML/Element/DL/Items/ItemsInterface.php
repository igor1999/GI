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
namespace GI\DOM\HTML\Element\DL\Items;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\Base\NodeInterface;
use GI\DOM\HTML\Element\DL\Items\DD\DDInterface;
use GI\DOM\HTML\Element\DL\Items\DT\DTInterface;

interface ItemsInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return DTInterface|DDInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return DTInterface|DDInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return DTInterface|DDInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return DTInterface|DDInterface|null
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return DTInterface|DDInterface|null
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return DTInterface[]|DDInterface[]
     */
    public function getItems();

    /**
     * @param DTInterface $dt
     * @return static
     */
    public function addDT(DTInterface $dt);

    /**
     * @param DDInterface $dd
     * @return static
     */
    public function addDD(DDInterface $dd);

    /**
     * @param string $text
     * @return static
     */
    public function addDTText(string $text = '');

    /**
     * @param string $text
     * @return static
     */
    public function addDDText(string $text = '');

    /**
     * @param int $index
     * @param DTInterface $dt
     * @return static
     */
    public function insertDT(int $index, DTInterface $dt);

    /**
     * @param int $index
     * @param DDInterface $dd
     * @return static
     */
    public function insertDD(int $index, DDInterface $dd);

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertDTText(int $index, string $text = '');

    /**
     * @param int $index
     * @param string $text
     * @return static
     */
    public function insertDDText(int $index, string $text = '');

    /**
     * @return static
     */
    public function clean();
}