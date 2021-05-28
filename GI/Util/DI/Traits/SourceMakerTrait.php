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
namespace GI\Util\DI\Traits;

use GI\Util\SourceMaker\FromFile\FromFile;
use GI\Util\SourceMaker\FromResource\FromResource;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\SourceMaker\FromFile\FromFileInterface;
use GI\Util\SourceMaker\FromResource\FromResourceInterface;

trait SourceMakerTrait
{
    /**
     * @var FromFileInterface
     */
    private $fromFile;

    /**
     * @var FromResourceInterface
     */
    private $fromResource;


    /**
     * @param string|null $caller
     * @return FromFileInterface
     */
    public function getFromFile(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(FromFileInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->fromFile instanceof FromFileInterface)) {
                $this->fromFile = new FromFile();
            }

            $result = $this->fromFile;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return FromResourceInterface
     */
    public function getFromResource(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(FromResourceInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->fromResource instanceof FromResourceInterface)) {
                $this->fromResource = new FromResource();
            }

            $result = $this->fromResource;
        }

        return $result;
    }
}