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
namespace GI\DOM\HTML\Element\Script\Inline;

use GI\DOM\HTML\Element\ContainerElementInterface;
use GI\DOM\HTML\Element\Script\Inline\Nodes\NodeListInterface;
use GI\DOM\HTML\Element\Script\Inline\Params\ParamsInterface;

interface InlineInterface extends ContainerElementInterface
{
    /**
     * @return ParamsInterface
     */
    public function getParams();

    /**
     * @return NodeListInterface
     */
    public function getChildNodes();

    /**
     * @param string $id
     * @return static
     */
    public function setFor(string $id);

    /**
     * @param string $event
     * @return static
     * @throws \Exception
     */
    public function setEvent(string $event);
}