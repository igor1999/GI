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

use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\Script\Inline\Params\Params;
use GI\DOM\HTML\Element\Script\Inline\Nodes\ScriptNode;

use GI\DOM\HTML\Element\Script\Inline\Params\ParamsInterface;
use GI\DOM\HTML\Element\Script\Inline\Nodes\NodeListInterface;

class Inline extends ContainerElement implements InlineInterface
{
    const TAG = 'script';


    /**
     * @var ParamsInterface
     */
    private $params;

    /**
     * @var NodeListInterface
     */
    private $childNodes;


    /**
     * Inline constructor.
     *
     * @param string $text
     * @throws \Exception
     */
    public function __construct(string $text = '')
    {
        parent::__construct(static::TAG);

        $this->getChildNodes()->setScript($text);

        $this->params = $this->giGetDi(ParamsInterface::class, Params::class);
    }

    /**
     * @return ParamsInterface
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return NodeListInterface
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
        $this->childNodes = $this->giGetDi(NodeListInterface::class, ScriptNode::class);

        return $this;
    }

    /**
     * @param string $id
     * @return static
     */
    public function setFor(string $id)
    {
        $this->getAttributes()->setFor($id);

        return $this;
    }

    /**
     * @param string $event
     * @return static
     * @throws \Exception
     */
    public function setEvent(string $event)
    {
        $this->getAttributes()->set('event', $event);

        return $this;
    }

    /**
     * @return string
     */
    protected function compileInnerHTML()
    {
        $html = parent::compileInnerHTML();

        return $this->params->render($html);
    }
}