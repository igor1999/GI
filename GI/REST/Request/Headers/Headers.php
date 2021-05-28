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
namespace GI\REST\Request\Headers;

use GI\Storage\Collection\StringCollection\HashSet\Closable\Closable;

/**
 * Class Headers
 * @package GI\REST\Request\Headers
 *
 * @method string getContentType()
 * @method HeadersInterface setContentType(string $contentType)
 *
 * @method string getAcceptLanguage()
 * @method HeadersInterface setAcceptLanguage(string $acceptLanguage)
 */
class Headers extends Closable implements HeadersInterface
{
    const AJAX_REQUEST_HEADER = 'X-Requested-With-Xhr';

    const CSRF_TOKEN_HEADER   = 'X-Csrf-Token';


    const CONTENT_TYPE_URL_ENCODED  = 'x-www-form-urlencoded';

    const CONTENT_TYPE_XML_REG_EXP  = '/\bxml\b/';

    const CONTENT_TYPE_JSON_REG_EXP = '/\bjson\b/';


    /**
     * Headers constructor.
     * @param array|null $items
     * @throws \Exception
     */
    public function __construct(array $items = null)
    {
        if (!is_array($items)) {
            $items = $this->getGiServiceLocator()->isCLI() ? [] : getallheaders();
        }

        $option = $this->getGiServiceLocator()->getStorageFactory()
            ->getOptionFactory()
            ->createStringHashSet()
            ->setKeyFormatToHyphenUcFirst();

        parent::__construct($items, $option);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isURLEncoded()
    {
        return strpos($this->getContentType(), static::CONTENT_TYPE_URL_ENCODED) !== false;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isXMLEncoded()
    {
        return (bool)preg_match(static::CONTENT_TYPE_XML_REG_EXP, $this->getContentType());
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isJSONEncoded()
    {
        return (bool)preg_match(static::CONTENT_TYPE_JSON_REG_EXP, $this->getContentType());
    }

    /**
     * @return bool
     */
    public function isAjaxRequest()
    {
        return $this->has(static::AJAX_REQUEST_HEADER);
    }

    /**
     * @param bool $ajax
     * @return static
     * @throws \Exception
     */
    public function setAjaxRequest(bool $ajax)
    {
        if ($ajax) {
            $this->set(static::CSRF_TOKEN_HEADER, '1');
        } else {
            $this->remove(static::CSRF_TOKEN_HEADER);
        }

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getCSRFToken()
    {
        return $this->get(static::CSRF_TOKEN_HEADER);
    }

    /**
     * @param string $token
     * @return static
     * @throws \Exception
     */
    public function setCSRFToken(string $token)
    {
        $this->set(static::CSRF_TOKEN_HEADER, $token);

        return $this;
    }

    /**
     * @param array $usedLocales
     * @return string
     * @throws \Exception
     */
    public function getLocale(array $usedLocales)
    {
        $acceptedLocale = $this->getAcceptedLocale();

        return in_array($acceptedLocale, $usedLocales) ? $acceptedLocale : '';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getAcceptedLocale()
    {
        return locale_accept_from_http($this->getAcceptLanguage());
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public function remove(string $key)
    {
        return parent::remove($key);
    }
}