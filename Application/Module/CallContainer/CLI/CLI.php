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
namespace GI\Application\Module\CallContainer\CLI;

use GI\Application\Module\CallContainer\AbstractContainer;

use GI\Application\Call\CLI\CallInterface;

class CLI extends AbstractContainer implements CLIInterface
{
    /**
     * @var CLIInterface[]
     */
    private $items = [];


    /**
     * @return CLIInterface[]
     */
    protected function getItems()
    {
        return $this->items;
    }

    /**
     * @param CLIInterface $container
     * @return static
     */
    protected function add(CLIInterface $container)
    {
        $this->items[] = $container;

        return $this;
    }

    /**
     * @return CLIInterface[]
     * @throws \Exception
     */
    public function create()
    {
        /** @var CLIInterface[] $result */
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