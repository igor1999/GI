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

use GI\Util\TextProcessing\Escaper\Factory\Base\FactoryInterface;

use GI\Util\TextProcessing\Escaper\CSS\EscaperInterface as CSSInterface;
use GI\Util\TextProcessing\Escaper\HTMLAttribute\EscaperInterface as HTMLAttributeInterface;
use GI\Util\TextProcessing\Escaper\HTMLText\EscaperInterface as HTMLTextInterface;
use GI\Util\TextProcessing\Escaper\JS\EscaperInterface as JSInterface;
use GI\Util\TextProcessing\Escaper\URL\EscaperInterface as URLInterface;

/**
 * Interface ContainerInterface
 * @package GI\Util\TextProcessing\Escaper\Factory\Container
 *
 * @method CSSInterface getCSS()
 * @method HTMLAttributeInterface getHTMLAttribute()
 * @method HTMLTextInterface getHTMLText()
 * @method JSInterface getJS()
 * @method URLInterface getURL()
 */
interface ContainerInterface extends FactoryInterface
{
    /**
     * @param string $encoding
     * @return static
     * @throws \Exception
     */
    public function setEncoding($encoding);
}