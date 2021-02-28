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
namespace GI\DOM\HTML\Element\Table\Items;

use GI\DOM\Base\ChildNodesCollection\ImmutableInterface;
use GI\DOM\HTML\Element\Table\Part\TBody\TBodyInterface;
use GI\DOM\HTML\Element\Table\Part\TFooter\TFooterInterface;
use GI\DOM\HTML\Element\Table\Part\THead\THeadInterface;
use GI\DOM\HTML\Element\Table\Row\TRInterface;
use GI\DOM\Base\NodeInterface;

interface ItemListInterface extends ImmutableInterface
{
    /**
     * @param int $index
     * @return ItemInterface
     * @throws \Exception
     */
    public function get(int $index);

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getFirst();

    /**
     * @return ItemInterface
     * @throws \Exception
     */
    public function getLast();

    /**
     * @param NodeInterface $item
     * @return TRInterface
     * @throws \Exception
     */
    public function getPrevious(NodeInterface $item);

    /**
     * @param NodeInterface $item
     * @return ItemInterface
     * @throws \Exception
     */
    public function getNext(NodeInterface $item);

    /**
     * @return TRInterface[]
     */
    public function getRows();

    /**
     * @return ItemInterface[]
     */
    public function getItems();

    /**
     * @param TRInterface|null $row
     * @return static
     */
    public function addRow(TRInterface $row = null);

    /**
     * @param int $index
     * @param TRInterface|null $row
     * @return static
     */
    public function insertRow(int $index, TRInterface $row = null);

    /**
     * @param TBodyInterface|null $tbody
     * @return static
     */
    public function addTBody(TBodyInterface $tbody = null);

    /**
     * @param int $index
     * @param TBodyInterface|null $tbody
     * @return static
     */
    public function insertTBody(int $index, TBodyInterface $tbody = null);

    /**
     * @param THeadInterface|null $thead
     * @return static
     */
    public function addTHead(THeadInterface $thead = null);

    /**
     * @param int $index
     * @param THeadInterface|null $thead
     * @return static
     */
    public function insertTHead(int $index, THeadInterface $thead = null);

    /**
     * @param TFooterInterface|null $tfooter
     * @return static
     */
    public function addTFooter(TFooterInterface $tfooter = null);

    /**
     * @param int $index
     * @param TFooterInterface|null $tfooter
     * @return static
     */
    public function insertTFooter(int $index, TFooterInterface $tfooter = null);

    /**
     * @return static
     */
    public function clean();
}