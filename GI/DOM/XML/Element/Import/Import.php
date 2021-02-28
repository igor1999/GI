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
namespace GI\DOM\XML\Element\Import;

use GI\DOM\XML\Element\SimpleElement;

class Import extends SimpleElement implements ImportInterface
{
    const TAG = 'import';


    /**
     * Import constructor.
     * @param string $namespace
     * @param string $schemaNamespace
     * @param string $schemaLocation
     * @throws \Exception
     */
    public function __construct(string $namespace = '', string $schemaNamespace = '', string $schemaLocation = '')
    {
        parent::__construct(static::TAG, $namespace);

        $this->setSchemaNamespace($schemaNamespace)->setSchemaLocation($schemaLocation);
    }

    /**
     * @param string $uri
     * @return static
     * @throws \Exception
     */
    public function setSchemaNamespace(string $uri)
    {
        $this->getAttributes()->set('namespace', $uri);

        return $this;
    }

    /**
     * @param string $uri
     * @return static
     * @throws \Exception
     */
    public function setSchemaLocation(string $uri)
    {
        $this->getAttributes()->set('schemaLocation', $uri);

        return $this;
    }
}