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
namespace GI\Component\Authentication\Login\Dialog;

use GI\Component\Base\AbstractComponent;
use GI\Component\Authentication\Login\Dialog\View\Widget;
use GI\Component\Authentication\Login\Dialog\ViewModel\ViewModel;
use GI\Component\Authentication\Login\Dialog\I18n\Glossary;

use GI\Component\Authentication\Exception\ExceptionAwareTrait;

use GI\Component\Authentication\Login\Dialog\Context\ContextInterface;
use GI\Component\Authentication\Login\Dialog\View\WidgetInterface;
use GI\Identity\IdentityInterface;
use GI\Component\Authentication\Login\Dialog\ViewModel\ViewModelInterface;
use GI\Component\Authentication\Login\Dialog\I18n\GlossaryInterface;

class Dialog extends AbstractComponent implements DialogInterface
{
    use ExceptionAwareTrait;


    /**
     * @var WidgetInterface
     */
    private $view;

    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var IdentityInterface
     */
    private $identity;


    /**
     * Dialog constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->view = $this->giGetDi(WidgetInterface::class, Widget::class);

        $this->viewModel = $this->giGetDi(ViewModelInterface::class, ViewModel::class);

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
     * @return ViewModelInterface
     */
    protected function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @return ContextInterface
     */
    protected function getContext()
    {
        return $this->context;
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
    protected function createContext()
    {
        try {
            $this->context = $this->giGetDi(ContextInterface::class);
        } catch (\Exception $e) {
            $this->giThrowDependencyException('Login dialog contents');
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createIdentity()
    {
        try {
            /** @var IdentityInterface $identity */
            $this->identity = $this->giGetDi(IdentityInterface::class);
        } catch (\Exception $e) {
            $this->giThrowDependencyException('Identity');
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
            ->setLoginCheckAction($this->getContext()->getCheckAction())
            ->setViewModel($this->getViewModel())
            ->setHasCookie($this->getIdentity()->hasCookie())
            ->toString();
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function login(array $data)
    {
        if ($this->getIdentity()->isAuthenticated()) {
            $this->throwLoginException();
        }

        $this->getViewModel()->hydrate($data);

        if (!$this->getViewModel()->validate()) {
            $response = ['success' => 0, 'message' => $this->getViewModel()->getValidator()->getFirstMessage()];
        } else {
            $auth = $this->getIdentity()->authenticate(
                $this->getViewModel()->getLogin(),
                $this->getViewModel()->getPassword(),
                $this->getIdentity()->hasCookie() && $this->getViewModel()->isSave()
            );

            if ($auth) {
                $this->getContext()->validateProperties();

                $response = ['success' => 1, 'redirectUri' => $this->getContext()->getRedirectUri()];
            } else {
                $response = [
                    'success' => 0,
                    'message' => $this->giTranslate(
                        GlossaryInterface::class, Glossary::class, 'Either login or password failed'
                    )
                ];
            }
        }

        return $response;
    }
}