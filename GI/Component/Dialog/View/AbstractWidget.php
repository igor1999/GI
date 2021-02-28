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

use GI\Component\Base\View\Widget\AbstractWidget as Base;
use GI\DOM\HTML\Element\Div\Float\Clear\Clear;

use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;

abstract class AbstractWidget extends Base implements WidgetInterface
{
    use ContentsTrait;


    const CLIENT_CSS        = 'gi-dialog';

    const CLASS_COVER_MODAL = 'gi-cover-modal';


    /**
     * @return ResourceRendererInterface
     */
    abstract protected function getResourceRenderer();

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $this->container->getChildNodes()->set([$this->modalityHidden, $this->cover]);
        $this->cover->getChildNodes()->set($this->frame);
        $this->frame->getChildNodes()->set([$this->header, $this->content, $this->footer]);
        $this->header->getChildNodes()->set([$this->title, $this->closeButton, new Clear()]);
        $this->footer->getChildNodes()->set([$this->footerDescription, $this->resize, new Clear()]);

        return $this;
    }

    /**
     * @render
     * @gi-id container
     * @return DivInterface
     */
    protected function createContainer()
    {
        $this->container = $this->giGetDOMFactory()->createDiv();

        return $this->container;
    }

    /**
     * @gi-id cover
     * @return DivInterface
     * @throws \Exception
     */
    protected function createCover()
    {
        $this->cover = $this->giGetDOMFactory()->createDiv();

        if ($this->modality) {
            $this->content->getClasses()->add(static::CLASS_COVER_MODAL);
        }

        return $this->cover;
    }

    /**
     * @gi-id frame
     * @return DivInterface
     */
    protected function createFrame()
    {
        $this->frame = $this->giGetDOMFactory()->createDiv();

        return $this->frame;
    }

    /**
     * @gi-id header
     * @return DivInterface
     */
    protected function createHeader()
    {
        $this->header = $this->giGetDOMFactory()->createDiv();

        return $this->header;
    }

    /**
     * @gi-id title
     * @return DivInterface
     * @throws \Exception
     */
    protected function createTitle()
    {
        $this->title = $this->giGetDOMFactory()->createDiv();

        $this->title->getAttributes()->setUnselectableToOn();
        $this->title->getChildNodes()->set($this->titleText);

        return $this->title;
    }

    /**
     * @gi-id close-button
     * @return DivInterface
     */
    protected function createCloseButton()
    {
        $this->closeButton = $this->giGetDOMFactory()->createDiv();

        return $this->closeButton;
    }

    /**
     * @gi-id content
     * @return DivInterface
     */
    protected function createContent()
    {
        $this->content = $this->giGetDOMFactory()->createDiv();

        return $this->content;
    }

    /**
     * @gi-id footer
     * @return DivInterface
     */
    protected function createFooter()
    {
        $this->footer = $this->giGetDOMFactory()->createDiv();

        return $this->footer;
    }

    /**
     * @gi-id footer-description
     * @return DivInterface
     */
    protected function createFooterDescription()
    {
        $this->footerDescription = $this->giGetDOMFactory()->createDiv();

        return $this->footerDescription;
    }

    /**
     * @gi-id resize
     * @return DivInterface
     */
    protected function createResize()
    {
        $this->resize = $this->giGetDOMFactory()->createDiv();

        return $this->resize;
    }

    /**
     * @gi-id modality
     * @return HiddenInterface
     */
    protected function createModalityHidden()
    {
        $this->modalityHidden = $this->giGetDOMFactory()->getInputFactory()->createHidden(
            [], $this->modality ? 1 : 0
        );

        return $this->modalityHidden;
    }
}