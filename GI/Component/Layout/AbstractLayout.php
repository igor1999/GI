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
namespace GI\Component\Layout;

use GI\Component\Base\AbstractComponent;
use GI\Component\Authentication\Authentication;
use GI\Component\Layout\I18n\Glossary;

use GI\Component\Layout\View\ViewInterface;
use GI\Component\Authentication\AuthenticationInterface;
use GI\Component\Base\ComponentInterface;
use GI\Component\Layout\I18n\GlossaryInterface;

abstract class AbstractLayout extends AbstractComponent implements LayoutInterface
{
    const DEFAULT_ERROR_TITLE = 'Error';


    /**
     * @var string
     */
    private $title = '';

    /**
     * @var AuthenticationInterface|null
     */
    private $authentication;

    /**
     * @var ComponentInterface
     */
    private $content;


    /**
     * AbstractLayout constructor.
     */
    public function __construct()
    {
        try {
            $this->authentication = $this->getGiServiceLocator()->getDependency(AuthenticationInterface::class, Authentication::class);
        } catch (\Exception $e) {}
    }

    /**
     * @return ViewInterface
     */
    abstract protected function getView();

    /**
     * @return string
     */
    protected function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return static
     */
    protected function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return AuthenticationInterface
     * @throws \Exception
     */
    public function getAuthentication()
    {
        if (!($this->authentication instanceof AuthenticationInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('Authentication');
        }

        return $this->authentication;
    }

    /**
     * @throws \Exception
     */
    public function getNaviBreadCrumbs()
    {
        $this->getGiServiceLocator()->throwNotSetException('Bread crumbs');
    }

    /**
     * @throws \Exception
     */
    public function getNaviMenu()
    {
        $this->getGiServiceLocator()->throwNotSetException('Navi menu');
    }

    /**
     * @return ComponentInterface
     * @throws \Exception
     */
    public function getContent()
    {
        if (!($this->content instanceof ComponentInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('Content');
        }

        return $this->content;
    }

    /**
     * @param ComponentInterface $content
     * @return static
     */
    protected function setContent(ComponentInterface $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    protected function createAccessDeniedTitle()
    {
        return $this->getGiServiceLocator()->translate(GlossaryInterface::class, Glossary::class, 'Access denied');
    }

    /**
     * @param string $message
     * @return static
     */
    public function createAccessDenied(string $message)
    {
        $content = $this->getGiServiceLocator()->getComponentFactory()->getErrorFactory()->createAccessDenied($message);

        $this->setTitle($this->createAccessDeniedTitle())->setContent($content);

        return $this;
    }

    /**
     * @return string
     */
    protected function createNotFoundTitle()
    {
        return $this->getGiServiceLocator()->translate(GlossaryInterface::class, Glossary::class, 'Page not found');
    }

    /**
     * @param string $message
     * @return static
     */
    public function createNotFound(string $message)
    {
        $content = $this->getGiServiceLocator()->getComponentFactory()->getErrorFactory()->createNotFound($message);

        $this->setTitle($this->createNotFoundTitle())->setContent($content);

        return $this;
    }

    /**
     * @return string
     */
    protected function createServerErrorTitle()
    {
        return $this->getGiServiceLocator()->translate(
            GlossaryInterface::class, Glossary::class, 'Internal server error'
        );
    }

    /**
     * @param string $message
     * @return static
     */
    public function createServerError(string $message)
    {
        $content = $this->getGiServiceLocator()->getComponentFactory()->getErrorFactory()->createServerError($message);

        $this->setTitle($this->createServerErrorTitle())->setContent($content);

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        try {
            $this->getView()->setAuthentication($this->getAuthentication());
        } catch (\Exception $e) {}

        try {
            $this->getView()->setNaviBreadCrumbs($this->getNaviBreadCrumbs());
        } catch (\Exception $e) {}

        try {
            $this->getView()->setNaviMenu($this->getNaviMenu());
        } catch (\Exception $e) {}

        try {
            $this->getView()->setContent($this->getContent());
        } catch (\Exception $e) {}

        return $this->getView()->setTitle($this->title)->toString();
    }
}