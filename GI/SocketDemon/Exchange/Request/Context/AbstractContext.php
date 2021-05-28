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
namespace GI\SocketDemon\Exchange\Request\Context;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\SocketDemon\Exchange\Request\RequestInterface;
use GI\SocketDemon\Exchange\Request\Common\CommonInterface as CommonRequestInterface;
use GI\SocketDemon\Exchange\Request\Expiration\ExpirationInterface as ExpirationRequestInterface;
use GI\SocketDemon\Exchange\Request\Waiting\WaitingInterface as WaitingRequestInterface;
use GI\SocketDemon\Exchange\Request\PushCall\PushCallInterface as PushCallRequestInterface;

abstract class AbstractContext implements ContextInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @param RequestInterface $request
     * @return string
     * @throws \Exception
     */
    public function getRoute(RequestInterface $request)
    {
        switch (true) {
            case ($request instanceof CommonRequestInterface):
                $route = $this->getRouteForCommonRequest();
                break;
            case ($request instanceof ExpirationRequestInterface):
                $route = $this->getRouteForExpirationRequest();
                break;
            case ($request instanceof WaitingRequestInterface):
                $route = $this->getRouteForWaitingRequest();
                break;
            case ($request instanceof PushCallRequestInterface):
                $route = $this->getRouteForPushCallRequest();
                break;
            default:
                $route = null;
                $this->getGiServiceLocator()->throwNotFoundException('Request class', get_class($request));
        }

        return $route;
    }

    /**
     * @return string
     */
    abstract protected function getRouteForCommonRequest();

    /**
     * @return string
     */
    abstract protected function getRouteForExpirationRequest();

    /**
     * @return string
     */
    abstract protected function getRouteForWaitingRequest();

    /**
     * @throws \Exception
     */
    protected function getRouteForPushCallRequest()
    {
        $this->getGiServiceLocator()->throwNotSetException('PushCall Request class');
    }
}