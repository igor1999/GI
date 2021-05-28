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
namespace GI\Component\Authentication\Login;

use GI\Component\Base\AbstractComponent;
use GI\Component\Authentication\Login\View\View;

use GI\Component\Authentication\Login\Context\ContextInterface;
use GI\Component\Authentication\Login\Dialog\DialogInterface;
use GI\Component\Authentication\Login\View\ViewInterface;

class Login extends AbstractComponent implements LoginInterface
{
    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var ContextInterface|null
     */
    private $context;

    /**
     * @var DialogInterface
     */
    private $dialog;


    /**
     * Login constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->view = $this->getGiServiceLocator()->getDependency(ViewInterface::class, View::class);

        $this->createContext();

        $this->dialog = $this->getGiServiceLocator()->getComponentFactory()->createLoginDialog();
    }

    /**
     * @return ViewInterface
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return ContextInterface
     * @throws \Exception
     */
    protected function getContext()
    {
        if (!($this->context instanceof ContextInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('Login context');
        }

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
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @return DialogInterface
     */
    public function getDialog()
    {
        return $this->dialog;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        try {
            $this->getView()->getWidget()
                ->setRegisterURI($this->getContext()->getRegisterUri())
                ->setRestorePasswordURI($this->getContext()->getRestorePasswordUri());
        } catch (\Exception $e) {}

        $this->getView()->setDialog($this->getDialog());

        return $this->getView()->toString();
    }
}