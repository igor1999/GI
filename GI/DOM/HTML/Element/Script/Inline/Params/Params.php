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
namespace GI\DOM\HTML\Element\Script\Inline\Params;

use GI\Storage\Collection\ScalarCollection\HashSet\Alterable\Alterable;

use GI\Util\TextProcessing\Escaper\JS\EscaperInterface;

class Params extends Alterable implements ParamsInterface
{
    const PLACEHOLDER_TEMPLATE = '%%%s%%';


    /**
     * @var EscaperInterface
     */
    private $escaper;


    /**
     * Params constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->escaper = $this->giGetUtilites()->getEscaperFactory()->createJS();
    }

    /**
     * @return EscaperInterface
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @param string $param
     * @param mixed $value
     * @return static
     * @throws \Exception
     */
    public function escapeAndSet(string $param, $value)
    {
        $this->set($param, $this->getEscaper()->escape($value));

        return $this;
    }

    /**
     * @param string $code
     * @return string
     */
    public function render(string $code)
    {
        foreach ($this->getItems() as $param => $value) {
            $placeholder = sprintf(static::PLACEHOLDER_TEMPLATE, $param);

            $code = str_replace($placeholder, $value, $code);
        }

        return $code;
    }
}