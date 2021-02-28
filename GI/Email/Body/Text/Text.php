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
namespace GI\Email\Body\Text;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Text implements TextInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $text = '';

    /**
     * @var string
     */
    private $charset = self::DEFAULT_CHARSET;

    /**
     * @var string
     */
    private $mode = self::MODE_TEXT;


    /**
     * Text constructor.
     *
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
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
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param string $charset
     * @return static
     */
    public function setCharset(string $charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return static
     */
    protected function setMode(string $mode)
    {
        $this->mode = $mode == self::MODE_TEXT ? $mode : self::MODE_HTML;

        return $this;
    }

    /**
     * @return static
     */
    public function setModeToText()
    {
        $this->setMode(self::MODE_TEXT);

        return $this;
    }

    /**
     * @return static
     */
    public function setModeToHTML()
    {
        $this->setMode(self::MODE_HTML);

        return $this;
    }

    /**
     * @return bool
     */
    public function isText()
    {
        return $this->mode == self::MODE_TEXT;
    }

    /**
     * @return bool
     */
    public function isHTML()
    {
        return $this->mode == self::MODE_HTML;
    }

    /**
     * @return array
     */
    public function extract()
    {
        return [
            'type'          => TYPETEXT,
            'subtype'       => $this->mode,
            'charset'       => $this->getCharset(),
            'description'   => 'message mode text',
            'contents.data' => $this->getText(),
        ];
    }
}