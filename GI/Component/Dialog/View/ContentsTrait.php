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
namespace GI\Component\Dialog\View;

use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;

trait ContentsTrait
{
    /**
     * @var string
     */
    private $titleText = '';

    /**
     * @var bool
     */
    private $modality = false;

    /**
     * @var DivInterface
     */
    private $container;

    /**
     * @var DivInterface
     */
    private $cover;

    /**
     * @var DivInterface
     */
    private $frame;

    /**
     * @var DivInterface
     */
    private $header;

    /**
     * @var DivInterface
     */
    private $title;

    /**
     * @var DivInterface
     */
    private $closeButton;

    /**
     * @var DivInterface
     */
    private $content;

    /**
     * @var DivInterface
     */
    private $footer;

    /**
     * @var DivInterface
     */
    private $footerDescription;

    /**
     * @var DivInterface
     */
    private $resize;

    /**
     * @var HiddenInterface
     */
    private $modalityHidden;


    /**
     * @return DivInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return DivInterface
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @return DivInterface
     */
    public function getFrame()
    {
        return $this->frame;
    }

    /**
     * @return DivInterface
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return DivInterface
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return DivInterface
     */
    public function getCloseButton()
    {
        return $this->closeButton;
    }

    /**
     * @return DivInterface
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return DivInterface
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @return DivInterface
     */
    public function getFooterDescription()
    {
        return $this->footerDescription;
    }

    /**
     * @return DivInterface
     */
    public function getResize()
    {
        return $this->resize;
    }

    /**
     * @return HiddenInterface
     */
    public function getModalityHidden()
    {
        return $this->modalityHidden;
    }
}