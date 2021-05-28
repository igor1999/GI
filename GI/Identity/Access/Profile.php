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
namespace GI\Identity\Access;

use GI\Storage\Collection\StringCollection\ArrayList\Immutable\Immutable as ArrayList;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Identity\IdentityInterface;

class Profile extends ArrayList implements ProfileInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var IdentityInterface
     */
    private $identity;


    /**
     * @return IdentityInterface
     * @throws \Exception
     */
    protected function getIdentity()
    {
        if (!($this->identity instanceof IdentityInterface)) {
            $this->createIdentity();
        }

        return $this->identity;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createIdentity()
    {
        try {
            $this->identity = $this->getGiServiceLocator()->getDependency(IdentityInterface::class);
        } catch (\Exception $e) {
            $this->getGiServiceLocator()->throwDependencyException(IdentityInterface::class);
        }

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function validate()
    {
        return $this->getIdentity()->isAuthenticated()
            && ($this->isEmpty() || $this->contains($this->getIdentity()->getRole()));
    }
}