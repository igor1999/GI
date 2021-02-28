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
namespace GI\Util\TextProcessing\Escaper\Factory\Base;

use GI\Pattern\Factory\AbstractFactory as Base;

use GI\Util\TextProcessing\Escaper\CSS\Escaper as CSS;
use GI\Util\TextProcessing\Escaper\HTMLAttribute\Escaper as HTMLAttribute;
use GI\Util\TextProcessing\Escaper\HTMLText\Escaper as HTMLText;
use GI\Util\TextProcessing\Escaper\JS\Escaper as JS;
use GI\Util\TextProcessing\Escaper\URL\Escaper as URL;

use GI\Util\TextProcessing\Escaper\EscaperInterface;

abstract class AbstractFactory extends Base implements FactoryInterface
{
    /**
     * AbstractFactory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(EscaperInterface::class);

        $this->setNamed('CSS', CSS::class)
            ->setNamed('HTMLAttribute', HTMLAttribute::class)
            ->setNamed('HTMLText', HTMLText::class)
            ->setNamed('JS', JS::class)
            ->setNamed('URL', URL::class);
    }
}