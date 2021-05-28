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
namespace GI\Component\Authentication\Login\Dialog\Gate;

use GI\Component\Base\Gate\AbstractGate;

class Gate extends AbstractGate implements GateInterface
{
    /**
     * Try to login and get redirect url or error message
     */
    public function login()
    {
        try {
            $data = $this->getCall()->getRequest()->getPost()->extract();

            $response = $this->getGiServiceLocator()->getComponentFactory()->createLoginDialog()->login($data);

            $this->getCall()->setResponseToJSON($response);
        } catch (\Exception $e) {
            $this->getCall()->setResponseToStatus500($e->getMessage());
        }
    }
}