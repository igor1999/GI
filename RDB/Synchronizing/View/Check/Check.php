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
namespace GI\RDB\Synchronizing\View\Check;

use GI\Markup\Renderer\AbstractRenderer;
use GI\RDB\Synchronizing\View\Tables\Tables;

use GI\RDB\Synchronizing\View\Tables\TablesInterface;

/**
 * Class Check
 * @package GI\RDB\Synchronizing\View
 *
 * @method array getDumpOnly()
 * @method CheckInterface setDumpOnly(array $contents)
 * @method array getDatabaseOnly()
 * @method CheckInterface setDatabaseOnly(array $contents)
 * @method array getUnequals()
 * @method CheckInterface setUnequals(array $contents)
 */
class Check extends AbstractRenderer implements CheckInterface
{
    /**
     * @var TablesInterface
     */
    private $tablesRenderer;


    /**
     * Check constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->tablesRenderer = $this->giGetDi(TablesInterface::class, Tables::class);
    }

    /**
     * @return TablesInterface
     */
    public function getTablesRenderer()
    {
        return $this->tablesRenderer;
    }
}