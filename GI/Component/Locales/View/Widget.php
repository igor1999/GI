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
namespace GI\Component\Locales\View;

use GI\Component\Menu\View\Widget as Base;

/**
 * Class Widget
 * @package GI\Component\Locales\View
 *
 * @method string getCookie()
 * @method WidgetInterface setCookie(string $cookie)
 * @method int getExpires()
 * @method WidgetInterface setExpires(int $expires)
 */
class Widget extends Base implements WidgetInterface
{
    const CLIENT_JS                = 'gi-locales';

    const CLIENT_CSS               = self::CLIENT_JS;

    const ATTRIBUTE_COOKIE_NAME    = 'cookie-name';

    const ATTRIBUTE_COOKIE_EXPIRES = 'cookie-expires';


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
        parent::__construct();

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
        parent::build();

        $this->getServerDataList()
            ->set(static::ATTRIBUTE_COOKIE_NAME, $this->getCookie())
            ->set(static::ATTRIBUTE_COOKIE_EXPIRES, $this->getExpires());

        $this->addLocaleImages();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function addLocaleImages()
    {
        foreach ($this->getOptions() as $containerID => $menuOptions) {
            foreach ($menuOptions as $locale => $option) {
                $backgroundLocale = $this->getResourceRenderer()->getLocaleImages()->has($locale)
                    ? $locale
                    : $this->giGetServiceLocator()->getUserLocale();

                $url = $this->getResourceRenderer()->getLocaleImages()->get($backgroundLocale);

                $option->getStyle()->setBackgroundImageToUrl($url);
            }
        }

        return $this;
    }
}