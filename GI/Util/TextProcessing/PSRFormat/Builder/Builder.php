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
namespace GI\Util\TextProcessing\PSRFormat\Builder;

use GI\Util\TextProcessing\PSRFormat\AbstractPrefix;

/**
 * Class Builder
 * @package GI\Util\TextProcessing\PSRFormat\Builder
 *
 * @method buildHas(string $source)
 * @method buildGet(string $source)
 * @method buildIs(string $source)
 * @method buildSet(string $source)
 * @method buildAdd(string $source)
 * @method buildInsert(string $source)
 * @method buildCreate(string $source)
 * @method buildCreateAndAdd(string $source)
 * @method buildCreateAndInsert(string $source)
 * @method buildRender(string $source)
 * @method buildParse(string $source)
 * @method buildBuild(string $source)
 * @method buildRemove(string $source)
 * @method buildDelete(string $source)
 * @method buildExecute(string $source)
 */
class Builder extends AbstractPrefix implements BuilderInterface
{
    /**
     * @param string $source
     * @param string $prefix
     * @return string
     */
    public function build(string $source, string $prefix)
    {
        return $prefix . ucfirst($source);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return string
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        try {
            $prefix = $this->getGiServiceLocator()->getUtilites()->getPSRFormatParser()->parseWithPrefixBuild($method);
        } catch (\Exception $exception) {
            $prefix = null;
            $this->getGiServiceLocator()->throwMagicMethodException($method);
        }

        $this->validatePrefix($prefix, $method);

        if (empty($arguments)) {
            $this->getGiServiceLocator()->throwNotGivenException('Source for building');
        }
        
        return $this->build(array_shift($arguments), lcfirst($prefix));
    }
}