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
namespace GI\Email\Controller;

use GI\Email\Email;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Email\EmailInterface;

class AbstractController implements ControllerInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var EmailInterface
     */
    private $email;


    /**
     * AbstractController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->email = $this->getGiServiceLocator()->getDependency(EmailInterface::class, Email::class);
    }

    /**
     * @return EmailInterface
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return static
     */
    protected function reset()
    {
        $this->getEmail()->reset();

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function send()
    {
        return $this->getEmail()->send();
    }
}