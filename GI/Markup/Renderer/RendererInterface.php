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
namespace GI\Markup\Renderer;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\Pattern\StringConvertable\StringConvertableInterface;
use GI\Util\TextProcessing\Escaper\Factory\Container\ContainerInterface as EscaperContainerInterface;
use GI\Util\TextProcessing\MarkupTextProcessor\MarkupTextProcessorInterface;
use GI\DOM\Factory\FactoryInterface as DOMFactoryInterface;
use GI\Pattern\Validation\ValidationInterface;
use GI\DOM\HTML\Element\Input\Hidden\CSRFInterface;

interface RendererInterface extends  StringConvertableInterface, ValidationInterface
{
    /**
     * @return EscaperContainerInterface
     */
    public function getEscaperContainer();

    /**
     * @return MarkupTextProcessorInterface
     */
    public function getMarkupTextProcessor();

    /**
     * @return DOMFactoryInterface
     */
    public function getDOMFactory();

    /**
     * @return CSRFInterface
     */
    public function createCSRF();

    /**
     * @return string
     * @throws \Exception
     */
    public function toString();

    /**
     * @param FSOFileInterface $target
     * @return static
     * @throws \Exception
     */
    public function save(FSOFileInterface $target);
}