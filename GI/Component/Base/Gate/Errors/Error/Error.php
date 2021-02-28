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
namespace GI\Component\Base\Gate\Errors\Error;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\REST\Response\ResponseInterface;

class Error implements ErrorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var bool
     */
    private $forCallerInherits = false;


    /**
     * Item constructor.
     * @param ResponseInterface $response
     * @param bool $forCallerInherits
     */
    public function __construct(ResponseInterface $response, bool $forCallerInherits = false)
    {
        $this->response          = $response;
        $this->forCallerInherits = $forCallerInherits;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isForCallerInherits()
    {
        return $this->forCallerInherits;
    }
}