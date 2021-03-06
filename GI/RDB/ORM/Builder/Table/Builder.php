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
namespace GI\GI\RDB\ORM\Builder\Table;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Meta\Table\TableInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;

class Builder implements BuilderInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @var FSODirInterface
     */
    private $ormDir;

    /**
     * @var string
     */
    private $ormNamespace;

    /**
     * @var string
     */
    private $baseNamespace;


    /**
     * Builder constructor.
     * @param TableInterface $table
     * @param FSODirInterface $ormDir
     * @param string $ormNamespace
     * @param string $baseNamespace
     */
    public function __construct(
        TableInterface $table, FSODirInterface $ormDir, string $ormNamespace, string $baseNamespace)
    {
        $this->table         = $table;
        $this->ormDir        = $ormDir;
        $this->ormNamespace  = $ormNamespace;
        $this->baseNamespace = $baseNamespace;
    }

    /**
     * @return TableInterface
     */
    protected function getTable()
    {
        return $this->table;
    }

    /**
     * @return FSODirInterface
     */
    protected function getOrmDir()
    {
        return $this->ormDir;
    }

    /**
     * @return string
     */
    protected function getOrmNamespace()
    {
        return $this->ormNamespace;
    }

    /**
     * @param string $ormNamespace
     * @return static
     */
    protected function setOrmNamespace(string $ormNamespace)
    {
        $this->ormNamespace = $ormNamespace;

        return $this;
    }

    /**
     * @return string
     */
    protected function getBaseNamespace()
    {
        return $this->baseNamespace;
    }

    /**
     * @param string $baseNamespace
     * @return static
     */
    protected function setBaseNamespace(string $baseNamespace)
    {
        $this->baseNamespace = $baseNamespace;

        return $this;
    }


}