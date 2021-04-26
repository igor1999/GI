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
namespace GI\Component\Authentication\Logout\View;

use GI\Component\Base\View\Widget\AbstractWidget;
use GI\Component\Authentication\Logout\I18n\Glossary;

use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;
use GI\DOM\HTML\Element\TextContainer\Span\SpanInterface;
use GI\Component\Authentication\Logout\I18n\GlossaryInterface;

/**
 * Class Widget
 * @package GI\Component\Authentication\Logout\View
 *
 * @method getSalutation()
 * @method WidgetInterface setSalutation($salutation)
 * @method string getLogoutAction()
 * @method WidgetInterface setLogoutAction(string $logoutAction)
 */
class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_CSS             = 'gi-authentication-logout';

    const CLIENT_JS              = self::CLIENT_CSS;

    const ATTRIBUTE_CHECK_ACTION = 'check-action';


    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var LayoutInterface
     */
    private $container;

    /**
     * @var SpanInterface
     */
    private $salutationSpan;

    /**
     * @var HyperlinkInterface
     */
    private $logoutLink;


    /**
     * Widget constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->resourceRenderer = $this->giGetDi(
            ResourceRendererInterface::class, ResourceRenderer::class
        );
    }

    /**
     * @return ResourceRendererInterface
     */
    protected function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $this->createCsrf();

        $this->container
            ->build(1, 3)
            ->set(0, 0, $this->salutationSpan)
            ->set(0, 1, $this->logoutLink)
            ->set(0, 2, $this->createLoadingImage());

        return $this;
    }

    /**
     * @render
     * @gi-id container
     * @return LayoutInterface
     */
    protected function getContainer()
    {
        if (!($this->container instanceof LayoutInterface)) {
            $this->container = $this->giGetDOMFactory()->createLayout();
        }

        return $this->container;
    }

    /**
     * @gi-id salutation
     * @return SpanInterface
     */
    protected function getSalutationSpan()
    {
        if (!($this->salutationSpan instanceof SpanInterface)) {
            $this->salutationSpan = $this->giGetDOMFactory()->createSpan();

            $this->salutationSpan->getChildNodes()->set($this->getSalutation());
        }

        return $this->salutationSpan;
    }

    /**
     * @gi-id link
     * @return HyperlinkInterface
     * @throws \Exception
     */
    protected function getLogoutLink()
    {
        if (!($this->logoutLink instanceof HyperlinkInterface)) {
            $title = $this->giTranslate(GlossaryInterface::class, Glossary::class, 'sign out');

            $this->logoutLink = $this->giGetDOMFactory()->createHyperlink('', $title)->setHrefToMock();

            $action = $this->getLogoutAction();

            $this->logoutLink->getAttributes()->setDataAttribute(static::ATTRIBUTE_CHECK_ACTION, $action);
        }

        return $this->logoutLink;
    }
}