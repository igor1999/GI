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
namespace GI\SocketDemon\Demon;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\SocketDemon\Socket\Client\Collection\CollectionInterface as ClientSocketCollectionInterface;
use GI\SocketDemon\Demon\Context\ContextInterface;

class Demon implements DemonInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var ClientSocketCollectionInterface
     */
    private $clientList;

    /**
     * @var ContextInterface
     */
    private $context;


    /**
     * Demon constructor.
     */
    public function __construct()
    {
        $this->clientList = $this->getGiServiceLocator()->getSocketDemonFactory()->createClientSocketCollection();

        try {
            $this->context = $this->getGiServiceLocator()->getDependency(ContextInterface::class);
        } catch (\Exception $exception) {}
    }

    /**
     * @return ClientSocketCollectionInterface
     */
    protected function getClientList()
    {
        return $this->clientList;
    }

    /**
     * @return ContextInterface
     * @throws \Exception
     */
    protected function getContext()
    {
        if (!($this->context instanceof ContextInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('Context');
        }

        return $this->context;
    }

    /**
     * persistent sockets-scripts data exchange
     * @throws \Exception
     */
    public function run()
    {
        set_time_limit(0);

        while (true) {
            try {
                $activityChecker = $this->getContext()->getActivityChecker();
            } catch (\Exception $e) {}

            if (!empty($activityChecker) && call_user_func($activityChecker)) {
                break;
            }

            $this->getClientList()->send();
        }
    }
}