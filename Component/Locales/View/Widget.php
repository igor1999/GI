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

class Widget extends Base implements WidgetInterface
{
    const CLIENT_JS                = 'gi-locales';

    const CLIENT_CSS               = self::CLIENT_JS;

    const ATTRIBUTE_COOKIE_NAME    = 'cookie-name';

    const ATTRIBUTE_COOKIE_EXPIRES = 'cookie-expires';


    /**
     * @var string
     */
    private $cookie = '';

    /**
     * @var int
     */
    private $expires = 0;

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
     * @return string
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * @param string $cookie
     * @return static
     */
    public function setCookie(string $cookie)
    {
        $this->cookie = $cookie;

        return $this;
    }

    /**
     * @return int
     */
    protected function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param int $expires
     * @return static
     */
    public function setExpires(int $expires)
    {
        $this->expires = $expires;

        return $this;
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
            ->set(static::ATTRIBUTE_COOKIE_NAME, $this->cookie)
            ->set(static::ATTRIBUTE_COOKIE_EXPIRES, $this->expires);

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