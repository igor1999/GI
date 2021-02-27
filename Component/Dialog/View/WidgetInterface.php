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
use GI\Component\Base\View\Widget\WidgetInterface as BaseInterface;

interface WidgetInterface extends BaseInterface
{
    /**
     * @return string
     */
    public function getTitleText();

    /**
     * @param string $titleText
     * @return static
     */
    public function setTitleText(string $titleText);

    /**
     * @return bool
     */
    public function isModality();

    /**
     * @param bool $modality
     * @return static
     */
    public function setModality(bool $modality);

    /**
     * @return DivInterface
     */
    public function getContainer();

    /**
     * @return DivInterface
     */
    public function getCover();

    /**
     * @return DivInterface
     */
    public function getFrame();

    /**
     * @return DivInterface
     */
    public function getHeader();

    /**
     * @return DivInterface
     */
    public function getTitle();

    /**
     * @return DivInterface
     */
    public function getCloseButton();

    /**
     * @return DivInterface
     */
    public function getContent();

    /**
     * @return DivInterface
     */
    public function getFooter();

    /**
     * @return DivInterface
     */
    public function getFooterDescription();

    /**
     * @return DivInterface
     */
    public function getResize();

    /**
     * @return HiddenInterface
     */
    public function getModalityHidden();
}