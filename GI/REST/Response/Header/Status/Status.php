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
namespace GI\REST\Response\Header\Status;

use GI\REST\Response\Header\AbstractHeader;
use GI\REST\Response\Header\Status\Context\Context;

use GI\REST\Response\Header\Status\Context\ContextInterface;

class Status extends AbstractHeader implements StatusInterface
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $protocol = '';


    /**
     * Status constructor.
     * @param int $code
     * @param string $protocol
     * @throws \Exception
     */
    public function __construct(int $code, string $protocol = '')
    {
        $this->code = $code;

        if (!isset($this->getStatuses()[$this->code])) {
            $this->giThrowNotFoundException('Header status', $this->code);
        }

        if (empty($protocol)) {
            /** @var ContextInterface $context */
            $context  = $this->giGetDi(ContextInterface::class, Context::class);
            $protocol = $context->getServerProtocol();
        }

        $this->protocol = $protocol;

        parent::__construct('', '');
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->protocol . ' ' . $this->code . ' ' .  $this->getStatus();
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->getStatuses()[$this->code];
    }

    /**
     * @return string[]
     */
    protected function getStatuses()
    {
        return [
            200 => "OK",
            201 => "Created",
            202 => "Accepted",
            203 => "Non-Authoritative Information",
            204 => "No Content",
            205 => "Reset Content",
            206 => "Partial Content",

            300 => "Multiple Choices",
            301 => "Moved Permanently",
            302 => "Found",
            303 => "See Other",
            304 => "Not Modified",
            305 => "Use Proxy",
            306 => "(Unused)",
            307 => "Temporary Redirect",

            400 => "Bad Request",
            401 => "Unauthorized",
            402 => "Payment Required",
            403 => "Forbidden",
            404 => "Not Found",
            405 => "Method Not Allowed",
            406 => "Not Acceptable",
            407 => "Proxy Authentication Required",
            408 => "Request Timeout",
            409 => "Conflict",
            410 => "Gone",
            411 => "Length Required",
            412 => "Precondition Failed",
            413 => "Request Entity Too Large",
            414 => "Request-URI Too Long",
            415 => "Unsupported Media Type",
            416 => "Requested Range Not Satisfiable",
            417 => "Expectation Failed",

            500 => "Internal Server Error",
            501 => "Not Implemented",
            502 => "Bad Gateway",
            503 => "Service Unavailable",
            504 => "Gateway Timeout",
            505 => "HTTP Version Not Supported",
        ];
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     * @return static
     */
    protected function setProtocol(string $protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return static
     */
    protected function setCode(int $code)
    {
        $this->code = $code;

        return $this;
    }
}