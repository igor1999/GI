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

use GI\Storage\Collection\StringCollection\HashSet\Closable\ClosableInterface;

/**
 * Interface HeadersInterface
 * @package GI\REST\Request\Headers
 *
 * @method string getContentType()
 * @method HeadersInterface setContentType(string $contentType)
 *
 * @method string getAcceptLanguage()
 * @method HeadersInterface setAcceptLanguage(string $acceptLanguage)
 */
interface HeadersInterface extends ClosableInterface
{
    /**
     * @return bool
     * @throws \Exception
     */
    public function isURLEncoded();

    /**
     * @return bool
     * @throws \Exception
     */
    public function isXMLEncoded();

    /**
     * @return bool
     * @throws \Exception
     */
    public function isJSONEncoded();

    /**
     * @return bool
     */
    public function isAjaxRequest();

    /**
     * @param bool $ajax
     * @return static
     * @throws \Exception
     */
    public function setAjaxRequest(bool $ajax);

    /**
     * @return string
     * @throws \Exception
     */
    public function getCSRFToken();

    /**
     * @param string $token
     * @return static
     * @throws \Exception
     */
    public function setCSRFToken(string $token);

    /**
     * @param array $usedLocales
     * @return string
     * @throws \Exception
     */
    public function getLocale(array $usedLocales);

    /**
     * @return string
     * @throws \Exception
     */
    public function getAcceptedLocale();
}