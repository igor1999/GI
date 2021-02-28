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
namespace GI\Markup\Reader\Branch;

use GI\Markup\Reader\Base\AbstractCollection;

use GI\Markup\Reader\Base\Node\NodeTrait;

class Branch extends AbstractCollection implements BranchInterface
{
    use NodeTrait;


    /**
     * @return array
     */
    protected function getContents()
    {
        return [];
    }

    /**
     * @param \DOMElement $domElement
     * @return array
     * @throws \Exception
     */
    public function read(\DOMElement $domElement)
    {
        $result = [];

        $nodes = $this->getXPath()->create($domElement);

        /** @var \DOMElement $node */
        foreach ($nodes as $index => $node) {
            $key = $this->getKeyParser()->parse($index, $node);

            $value = [];
            foreach ($this->getItems() as $item) {
                $value = array_merge($value, $item->read($node));
            }

            if (!array_key_exists($key, $result)) {
                $result[$key] = $value;
            } else {
                $result[$key] = $this->mergeReadResults($result[$key], $value);
            }
        }

        return $result;
    }
}