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

use GI\Markup\Renderer\RendererInterface;
use GI\RDB\Synchronizing\View\Tables\TablesInterface;

/**
 * Interface CheckInterface
 * @package GI\RDB\Synchronizing\View
 *
 * @method array getDumpOnly()
 * @method CheckInterface setDumpOnly(array $contents)
 * @method array getDatabaseOnly()
 * @method CheckInterface setDatabaseOnly(array $contents)
 * @method array getUnequals()
 * @method CheckInterface setUnequals(array $contents)
 */
interface CheckInterface extends RendererInterface
{
    /**
     * @return TablesInterface
     */
    public function getTablesRenderer();
}