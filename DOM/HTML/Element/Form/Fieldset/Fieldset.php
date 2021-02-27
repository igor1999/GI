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
namespace GI\DOM\HTML\Element\Form\Fieldset;

use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\Form\Fieldset\Legend\LegendInterface;

class Fieldset extends ContainerElement implements FieldsetInterface
{
    const TAG = 'fieldset';


    /**
     * @var LegendInterface
     */
    private $legend;


    /**
     * Fieldset constructor.
     * @param string $title
     * @throws \Exception
     */
    public function __construct(string $title = '')
    {
        parent::__construct(static::TAG);

        $this->legend = $this->giGetDOMFactory()->createLegend($title);
    }

    /**
     * @return LegendInterface
     */
    public function getLegend()
    {
         return $this->legend;
    }

    /**
     * @param LegendInterface $legend
     * @return static
     */
    public function setLegend(LegendInterface $legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * @return string
     */
    protected function compileInnerHTML()
    {
        return $this->getLegend()->toString() . PHP_EOL . parent::compileInnerHTML();
    }
}