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
namespace GI\Component\Authentication\Login\View\Widget;

use GI\Component\Authentication\Login\Dialog\DialogInterface;
use GI\Component\Base\View\Widget\AbstractWidget;
use GI\Component\Authentication\Login\I18n\Glossary;

use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;
use GI\Component\Authentication\Login\I18n\GlossaryInterface;

/**
 * Class Widget
 * @package GI\Component\Authentication\Login\View\Widget
 *
 * @method string getRegisterURI()
 * @method WidgetInterface setRegisterURI(string $registerURI)
 * @method string getRestorePasswordURI()
 * @method WidgetInterface setRestorePasswordURI(string $restorePasswordURI)
 */
class Widget extends AbstractWidget implements WidgetInterface
{
    use ContentsTrait;


    const CLIENT_JS  = 'gi-authentication-login';

    const CLIENT_CSS = self::CLIENT_JS;


    const RELATION_NAME_TO_DIALOG = 'dialog';


    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;


    /**
     * Widget constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->resourceRenderer = $this->giGetDi(
            ResourceRendererInterface::class, ResourceRenderer::class
        );

        $this->setRegisterURI('')->setRestorePasswordURI('');
    }

    /**
     * @return ResourceRendererInterface
     */
    protected function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @param DialogInterface $dialog
     * @return static
     * @throws \Exception
     */
    public function addDialogRelation(DialogInterface $dialog)
    {
        $this->getRelationList()->set(static::RELATION_NAME_TO_DIALOG, $dialog);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $links = [$this->loginLink];

        if (!empty($this->restorePasswordLink->getAttributes()->getHref())) {
            $links[] = $this->restorePasswordLink;
        }

        if (!empty($this->registerLink->getAttributes()->getHref())) {
            $links[] = $this->registerLink;
        }

        $this->container->build(1, count($links));

        foreach ($links as $index => $link) {
            $this->container->set(0, $index, $link);
        }

        return $this;
    }

    /**
     * @render
     * @gi-id container
     * @return LayoutInterface
     */
    protected function createLinkContainer()
    {
        $this->container = $this->giGetDOMFactory()->createLayout();

        return $this->container;
    }

    /**
     * @gi-id login-link
     * @return HyperlinkInterface
     */
    protected function createLoginLink()
    {
        $this->loginLink = $this->giGetDOMFactory()->createHyperlink(
            '', $this->giTranslate(GlossaryInterface::class, Glossary::class, 'sign in')
        )->setHrefToMock();

        return $this->loginLink;
    }

    /**
     * @gi-id register-link
     * @return HyperlinkInterface
     */
    protected function createRegisterLink()
    {
        $this->registerLink = $this->giGetDOMFactory()->createHyperlink(
            $this->getRegisterURI(),
            $this->giTranslate(GlossaryInterface::class, Glossary::class, 'sign up')
        );

        return $this->registerLink;
    }

    /**
     * @gi-id restore-password-link
     * @return HyperlinkInterface
     */
    protected function createRestorePasswordLink()
    {
        $this->restorePasswordLink = $this->giGetDOMFactory()->createHyperlink(
            $this->getRestorePasswordURI(),
            $this->giTranslate(GlossaryInterface::class, Glossary::class, 'forget password?')
        );

        return $this->restorePasswordLink;
    }
}