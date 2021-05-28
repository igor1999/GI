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
namespace GI\DOM\Base\TextNode;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\TextProcessing\MarkupTextProcessor\MarkupTextProcessorInterface;

class TextNode implements TextNodeInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $text = '';

    /**
     * @var MarkupTextProcessorInterface
     */
    private $textProcessor;


    /**
     * TextNode constructor.
     * @param string|null $text
     */
    public function __construct(string $text = null)
    {
        $this->setText($text);

        $this->textProcessor = $this->getGiServiceLocator()->getUtilites()->createMarkupTextProcessor();
    }

    /**
     * @return MarkupTextProcessorInterface
     */
    public function getTextProcessor()
    {
        return $this->textProcessor;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return static
     */
    public function setText(string $text = null)
    {
        $this->text = (string)$text;

        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->getTextProcessor()->setText($this->text)->escapeAndReplaceEOLWithBr()->getText();
    }
}