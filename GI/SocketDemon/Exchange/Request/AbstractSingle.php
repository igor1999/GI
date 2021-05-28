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
namespace GI\SocketDemon\Exchange\Request;

use GI\Pattern\Validation\ValidationTrait;

abstract class AbstractSingle extends AbstractRequest implements SingleInterface
{
    use ValidationTrait;


    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $session = '';


    /**
     * @extract
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @hydrate
     * @param string $id
     * @return static
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @extract
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @hydrate
     * @param string $session
     * @return static
     */
    public function setSession(string $session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateID()
    {
        if (empty($this->id)) {
            $this->getGiServiceLocator()->throwNotSetException('Request ID');
        }

        if (empty($this->session)) {
            $this->getGiServiceLocator()->throwNotSetException('Request session hash');
        }
    }
}