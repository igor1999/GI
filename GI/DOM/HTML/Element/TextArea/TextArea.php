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
namespace GI\DOM\HTML\Element\TextArea;

use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\TextArea\Nodes\NodesList;

use GI\DOM\HTML\Element\Extras\TextBox\TextBoxTrait;

use GI\DOM\HTML\Element\TextArea\Nodes\NodesListInterface;

class TextArea extends ContainerElement implements TextAreaInterface
{
    use TextBoxTrait;


    const TAG = 'textarea';


    /**
     * @var NodesListInterface
     */
    private $childNodes;


    /**
     * TextArea constructor.
     *
     * @param array $name
     * @param string $text
     * @throws \Exception
     */
    public function __construct(array $name = [], string $text = '')
    {
        parent::__construct(static::TAG);

        $this->getName()->setItems($name);

        $this->getChildNodes()->setText($text);
    }

    /**
     * @return NodesListInterface
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createChildNodes()
    {
        $this->childNodes = $this->giGetDi(NodesListInterface::class, NodesList::class);

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->compileInnerHTML();
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function setValue($value)
    {
        $this->getChildNodes()->setText($value);

        return $this;
    }

    /**
     * @param int $number
     * @return static
     */
    public function setRows(int $number)
    {
        $this->getAttributes()->setRows((int)$number);

        return $this;
    }

    /**
     * @param int $number
     * @return static
     */
    public function setCols(int $number)
    {
        $this->getAttributes()->setCols((int)$number);

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->buildTag() . $this->compileInnerHTML() . $this->buildEndTag() . PHP_EOL;
    }
}