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
namespace GI\ClientContents\BreadCrumbs\Track;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\ClientContents\BreadCrumbs\Node\NodeInterface;

class Track implements TrackInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var NodeInterface[]
     */
    private $nodes = [];


    /**
     * @return NodeInterface[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->nodes);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->nodes);
    }

    /**
     * @param NodeInterface $node
     * @return static
     * @throws \Exception
     */
    public function add(NodeInterface $node)
    {
        if (in_array($node, $this->nodes)) {
            $this->giThrowCommonException('Recursive reference by node id \'%s\'', [$node->getId()]);
        }

        array_unshift($this->nodes, $node);

        return $this;
    }
}