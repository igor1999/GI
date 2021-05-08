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
namespace GI\Util\TextProcessing\TextProcessor;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\TextProcessing\Escaper\HTMLText\EscaperInterface;

class MarkupTextProcessor implements MarkupTextProcessorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $text;

    /**
     * @var EscaperInterface
     */
    private $escaper;


    /**
     * MarkupTextProcessor constructor.
     */
    public function __construct()
    {
        $this->escaper = $this->giGetEscaperFactory()->createHTMLText();
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return static
     */
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return EscaperInterface
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @param int $length
     * @param string|null $charList
     * @return static
     */
    public function cutAsString(int $length, string $charList = null)
    {
        if (empty($this->text)) {
            $text = '';
        } else {
            $words = str_word_count($this->text, 2, $charList);

            $maxPosition = 0;

            foreach ($words as $position => $word) {
                if ($position >= $length) {
                    $maxPosition = $position;
                    break;
                }
            }

            if ($maxPosition == 0) {
                $text = $this->text;
            } else {
                $text = substr($this->text, 0, $maxPosition);
                $text = rtrim(trim($text), ',.:;') . '...';
            }
        }

        $this->setText($text);

        return $this;
    }

    /**
     * @param int $linesNumber
     * @return static
     */
    public function cutAsText(int $linesNumber)
    {
        if (!empty($this->text)) {
            $text = explode(PHP_EOL,  $this->text);

            if (count($text) <= $linesNumber) {
                $text = implode(PHP_EOL, $text);
            } else {
                $text = array_slice($text, 0 , $linesNumber);
                $text = implode(PHP_EOL, $text);
                $text = rtrim(trim($text), '.,:;') . '...';
            }

            $this->setText($text);
        }

        return $this;
    }

    /**
     * @return static
     */
    public function escape()
    {
        $text = $this->getEscaper()->escape($this->text);

        $this->setText($text);

        return $this;
    }

    /**
     * @param string $text
     * @return static
     */
    public function nlToBrText(string $text)
    {
        $text = nl2br($this->text);

        $this->setText($text);

        return $this;
    }
}