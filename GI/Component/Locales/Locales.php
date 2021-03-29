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
namespace GI\Component\Locales;

use GI\Component\Menu\AbstractMenu;
use GI\Component\Locales\View\Widget;
use GI\Component\Locales\Model\Locales as LocalesModel;

use GI\Component\Locales\View\WidgetInterface;
use GI\Component\Locales\Model\LocalesInterface as LocalesModelInterface;
use GI\I18n\Locales\UserLocaleContextInterface;

class Locales extends AbstractMenu implements LocalesInterface
{
    /**
     * @var LocalesModelInterface
     */
    private $menuModel;

    /**
     * @var WidgetInterface
     */
    private $view;


    /**
     * Locales constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->view = $this->giGetDi(WidgetInterface::class, Widget::class);

        $this->menuModel = $this->giGetDi(LocalesModelInterface::class, LocalesModel::class);
    }

    /**
     * @return WidgetInterface
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return LocalesModelInterface
     */
    protected function getMenuModel()
    {
        return $this->menuModel;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        try {
            /** @var UserLocaleContextInterface $translatorContext */
            $translatorContext = $this->giGetDi(UserLocaleContextInterface::class);
        } catch (\Exception  $e) {
            $this->giThrowDependencyException(UserLocaleContextInterface::class);
        }

        $this->getView()
            ->setCookie($translatorContext->getCookieName())
            ->setExpires($translatorContext->getCookieExpires());

        return parent::toString();
    }
}