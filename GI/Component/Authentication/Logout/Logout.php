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
namespace GI\Component\Authentication\Logout;

use GI\Component\Base\AbstractComponent;
use GI\Component\Authentication\Logout\View\Widget;

use GI\Component\Authentication\Exception\ExceptionAwareTrait;

use GI\Component\Authentication\Logout\Context\ContextInterface;
use GI\Component\Authentication\Logout\View\WidgetInterface;
use GI\Identity\IdentityInterface;

class Logout extends AbstractComponent implements LogoutInterface
{
    use ExceptionAwareTrait;


    /**
     * @var WidgetInterface
     */
    private $view;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var IdentityInterface
     */
    private $identity;


    /**
     * Logout constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->view = $this->getGiServiceLocator()->getDependency(WidgetInterface::class, Widget::class);

        $this->createContext()->createIdentity();
    }

    /**
     * @return WidgetInterface
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return ContextInterface
     */
    protected function getContext()
    {
        return $this->context;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createContext()
    {
        try {
            $this->context = $this->getGiServiceLocator()->getDependency(ContextInterface::class);
        } catch (\Exception $e) {
            $this->getGiServiceLocator()->throwDependencyException('Logout contents');
        }

        return $this;
    }

    /**
     * @return IdentityInterface
     */
    protected function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createIdentity()
    {
        try {
            $this->identity = $this->getGiServiceLocator()->getDependency(IdentityInterface::class);
        } catch (\Exception $e) {
            $this->getGiServiceLocator()->throwDependencyException('Identity');
        }

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $this->getContext()->validateProperties();

        return $this->getView()
            ->setSalutation($this->getIdentity()->getSignature())
            ->setLogoutAction($this->getContext()->getAction())
            ->toString();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function logout()
    {
        if (!$this->getIdentity()->isAuthenticated()) {
            $this->throwLogoutException();
        }

        $this->getIdentity()->clean();

        $this->getContext()->validateProperties();

        return $this->getContext()->getRedirectUri();
    }
}