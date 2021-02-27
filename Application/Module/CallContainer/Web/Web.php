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
namespace GI\Application\Module\CallContainer\Web;

use GI\Application\Module\CallContainer\AbstractContainer;

use GI\Application\Call\Web\CallInterface;

class Web extends AbstractContainer implements WebInterface
{
    /**
     * @var WebInterface[]
     */
    private $items = [];


    /**
     * @return WebInterface[]
     */
    protected function getItems()
    {
        return $this->items;
    }

    /**
     * @param WebInterface $container
     * @return static
     */
    protected function add(WebInterface $container)
    {
        $this->items[] = $container;

        return $this;
    }

    /**
     * @return WebInterface[]
     * @throws \Exception
     */
    public function create()
    {
        /** @var WebInterface[] $result */
        $result = parent::create();

        return $result;
    }

    /**
     * @param mixed $item
     * @return bool
     */
    protected function validate($item)
    {
        return $item instanceof CallInterface;
    }
}