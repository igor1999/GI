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
namespace GI\Util\TextProcessing\Escaper\Factory\Factory;

use GI\Util\TextProcessing\Escaper\Factory\Base\FactoryInterface as BaseInterface;

use GI\Util\TextProcessing\Escaper\CSS\EscaperInterface as CSSInterface;
use GI\Util\TextProcessing\Escaper\HTMLAttribute\EscaperInterface as HTMLAttributeInterface;
use GI\Util\TextProcessing\Escaper\HTMLText\EscaperInterface as HTMLTextInterface;
use GI\Util\TextProcessing\Escaper\JS\EscaperInterface as JSInterface;
use GI\Util\TextProcessing\Escaper\URL\EscaperInterface as URLInterface;

/**
 * Interface FactoryInterface
 * @package GI\Util\TextProcessing\Escaper\Factory\Factory
 *
 * @method CSSInterface createCSS()
 * @method HTMLAttributeInterface createHTMLAttribute()
 * @method HTMLTextInterface createHTMLText()
 * @method JSInterface createJS()
 * @method URLInterface createURL()
 */
interface FactoryInterface extends BaseInterface
{

}