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
namespace GI\Logger\View;

use GI\Markup\Renderer\AbstractRenderer;

use GI\Logger\View\Context\ContextInterface;

class View extends AbstractRenderer implements ViewInterface
{
    const DEFAULT_DATE_FORMAT = 'Y-m-d H:i:s';

    const DEFAULT_MAX_LENGTH  = 1024;


    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $text = '';

    /**
     * @var int
     */
    private $maxLength = 0;

    /**
     * @var string
     */
    private $dateFormat = '';


    /**
     * View constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->date = new \DateTime();

        try {
            /** @var ContextInterface $context */
            $context = $this->getGiServiceLocator()->getDependency(ContextInterface::class);
            $this->maxLength  = $context->getMaxLength();
            $this->dateFormat = $context->getDateFormat();
        }catch (\Exception $e) {
            $this->maxLength  = static::DEFAULT_MAX_LENGTH;
            $this->dateFormat = static::DEFAULT_DATE_FORMAT;
        }
    }

    /**
     * @return \DateTime
     */
    protected function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getFormattedDate()
    {
        return $this->date->format($this->dateFormat);
    }

    /**
     * @param \DateTime $date
     * @return static
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return static
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    protected function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getFormattedText()
    {
        $text = $this->text;

        if (is_object($text) || is_array($text)) {
            $text = print_r($text, true);

            if (is_int($this->maxLength) && $this->maxLength > 0) {
                $text = $this->getMarkupTextProcessor()->setText($text)->cutAsString($this->maxLength)->getText();
            }
        }

        return $text;
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
     * @return int
     */
    protected function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param int $maxLength
     * @return static
     */
    protected function setMaxLength(int $maxLength)
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * @return string
     */
    protected function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     * @return static
     */
    protected function setDateFormat(string $dateFormat)
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }
}