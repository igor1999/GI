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
namespace GI\Util\TextProcessing\Escaper\Factory\Container;

use GI\Util\TextProcessing\Escaper\Factory\Base\AbstractFactory;

use GI\Util\TextProcessing\Escaper\CSS\EscaperInterface as CSSInterface;
use GI\Util\TextProcessing\Escaper\HTMLAttribute\EscaperInterface as HTMLAttributeInterface;
use GI\Util\TextProcessing\Escaper\HTMLText\EscaperInterface as HTMLTextInterface;
use GI\Util\TextProcessing\Escaper\JS\EscaperInterface as JSInterface;
use GI\Util\TextProcessing\Escaper\URL\EscaperInterface as URLInterface;

/**
 * Class Container
 * @package GI\Util\TextProcessing\Escaper\Factory\Container
 *
 * @method CSSInterface getCSS()
 * @method HTMLAttributeInterface getHTMLAttribute()
 * @method HTMLTextInterface getHTMLText()
 * @method JSInterface getJS()
 * @method URLInterface getURL()
 */
class Container extends AbstractFactory implements ContainerInterface
{
    /**
     * Container constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->setPrefixToGet()->setCached(true);
    }

    /**
     * @param string $encoding
     * @return static
     * @throws \Exception
     */
    public function setEncoding(string $encoding)
    {
        $this->getHTMLText()->setEncoding($encoding);
        $this->getHTMLAttribute()->setEncoding($encoding);
        $this->getCSS()->setEncoding($encoding);
        $this->getJS()->setEncoding($encoding);

        return $this;
    }
}