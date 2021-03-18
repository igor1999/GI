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
namespace GI\Application\Call\CLI;

use GI\Application\Call\AbstractCall;

use GI\REST\Request\Server\ServerInterface;
use GI\CLI\CommandLine\CommandLineInterface;
use GI\REST\Route\CLIInterface;
use GI\I18n\Locales\UserLocaleContextInterface;

class Call extends AbstractCall implements CallInterface
{
    /**
     * Call constructor.
     * @param CLIInterface $route
     * @param \Closure $handler
     * @throws \Exception
     */
    public function __construct(CLIInterface $route, \Closure $handler)
    {
        parent::__construct($route, $handler);
    }

    /**
     * @return ServerInterface
     */
    public function getServer()
    {
        return $this->getRequest()->getServer();
    }

    /**
     * @return CommandLineInterface
     */
    public function getCommandLine()
    {
        return $this->getServer()->getCommandLine();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function handle()
    {
        $this->validateClosing();

        $result = $this->getRoute()->validateByServer($this->getServer());

        if ($result) {
            $this->close();
            $this->saveCallAndModuleContents();
            $this->giGetServiceLocator()->loadSession();
            $this->saveUserLocale();
            $this->giGetServiceLocator()->close();

            $this->getHandlers()->executeSequentially([$this]);

            $this->giGetServiceLocator()->saveSession();
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function saveUserLocale()
    {
        try {
            /** @var UserLocaleContextInterface $context */
            $context = $this->giGetDi(UserLocaleContextInterface::class);

            $locale = $this->findLocale($context);

            setlocale(LC_ALL, $locale);

            $this->giGetServiceLocator()->setUserLocale($locale);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param UserLocaleContextInterface $context
     * @return string
     * @throws \Exception
     */
    protected function findLocale(UserLocaleContextInterface $context)
    {
        try {
            $locale = $this->getCommandLine()->getLocale();
        } catch (\Exception $e) {
            $locale = $context->getDefaultLocale();
        }

        if (!in_array($locale, $context->getUsedLocales())) {
            $locale = '';
        }

        return $locale;
    }

    /**
     * @return static
     */
    protected function saveSessionExchangeClasses()
    {
        try {
            session_id($this->getCommandLine()->getSession());
            session_start();
        } catch (\Exception $e) {}

        parent::saveSessionExchangeClasses();

        return $this;
    }
}