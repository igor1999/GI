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

/**
 * Class AbstractWidget
 * @package GI\Component\Dialog\View
 *
 * @method string getTitleText()
 * @method WidgetInterface setTitleText(string $titleText)
 * @method bool isModality()
 * @method WidgetInterface setModality(bool $modality)
 */
abstract class AbstractWidget extends Base implements WidgetInterface
{
    use ContentsTrait;


    const CLIENT_CSS        = 'gi-dialog';

    const CLASS_COVER_MODAL = 'gi-cover-modal';

    const MODALITY_KEY      = 'modality';


    /**
     * AbstractWidget constructor.
     */
    public function __construct()
    {
        $this->setTitleText('')->setModality(false);
    }

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
        $this->getServerDataList()->set(static::MODALITY_KEY, $this->isModality() ? 1 : 0);

        $this->container->getChildNodes()->set($this->cover);
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
    protected function getContainer()
    {
        if (!($this->container instanceof DivInterface)) {
            $this->container = $this->giGetDOMFactory()->createDiv();
        }

        return $this->container;
    }

    /**
     * @gi-id cover
     * @return DivInterface
     * @throws \Exception
     */
    protected function getCover()
    {
        if (!($this->cover instanceof DivInterface)) {
            $this->cover = $this->giGetDOMFactory()->createDiv();

            if ($this->isModality()) {
                $this->cover->getClasses()->add(static::CLASS_COVER_MODAL);
            }
        }

        return $this->cover;
    }

    /**
     * @gi-id frame
     * @return DivInterface
     */
    protected function getFrame()
    {
        if (!($this->frame instanceof DivInterface)) {
            $this->frame = $this->giGetDOMFactory()->createDiv();
        }

        return $this->frame;
    }

    /**
     * @gi-id header
     * @return DivInterface
     */
    protected function getHeader()
    {
        if (!($this->header instanceof DivInterface)) {
            $this->header = $this->giGetDOMFactory()->createDiv();
        }

        return $this->header;
    }

    /**
     * @gi-id title
     * @return DivInterface
     * @throws \Exception
     */
    protected function getTitle()
    {
        if (!($this->title instanceof DivInterface)) {
            $this->title = $this->giGetDOMFactory()->createDiv();

            $this->title->getAttributes()->setUnselectableToOn();
            $this->title->getChildNodes()->set($this->getTitleText());
        }

        return $this->title;
    }

    /**
     * @gi-id close-button
     * @return DivInterface
     */
    protected function getCloseButton()
    {
        if (!($this->closeButton instanceof DivInterface)) {
            $this->closeButton = $this->giGetDOMFactory()->createDiv();
        }

        return $this->closeButton;
    }

    /**
     * @gi-id content
     * @return DivInterface
     */
    protected function getContent()
    {
        if (!($this->content instanceof DivInterface)) {
            $this->content = $this->giGetDOMFactory()->createDiv();
        }

        return $this->content;
    }

    /**
     * @gi-id footer
     * @return DivInterface
     */
    protected function getFooter()
    {
        if (!($this->footer instanceof DivInterface)) {
            $this->footer = $this->giGetDOMFactory()->createDiv();
        }

        return $this->footer;
    }

    /**
     * @gi-id footer-description
     * @return DivInterface
     */
    protected function getFooterDescription()
    {
        if (!($this->footerDescription instanceof DivInterface)) {
            $this->footerDescription = $this->giGetDOMFactory()->createDiv();
        }

        return $this->footerDescription;
    }

    /**
     * @gi-id resize
     * @return DivInterface
     */
    protected function getResize()
    {
        if (!($this->resize instanceof DivInterface)) {
            $this->resize = $this->giGetDOMFactory()->createDiv();
        }

        return $this->resize;
    }
}