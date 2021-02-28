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
namespace GI\RDB\Synchronizing\Check\Comparator;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Comparator implements ComparatorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var array
     */
    private $dumpOnly = [];

    /**
     * @var array
     */
    private $databaseOnly = [];

    /**
     * @var array
     */
    private $unequals = [];


    /**
     * @return array
     */
    public function getDumpOnly()
    {
        return $this->dumpOnly;
    }

    /**
     * @return array
     */
    public function getDatabaseOnly()
    {
        return $this->databaseOnly;
    }

    /**
     * @return array
     */
    public function getUnequals()
    {
        return $this->unequals;
    }

    /**
     * @param array $dumpContents
     * @param array $databaseContents
     * @return static
     * @throws \Exception
     */
    public function compare(array $dumpContents, array $databaseContents)
    {
        $this->dumpOnly = $this->databaseOnly = $this->unequals = [];

        $creator   = $this->giGetFlatCreator();
        $extractor = $this->giGetFlatExtractor();

        $dumpFlat     = $creator->createWithKeySeparatorPoint($dumpContents);
        $databaseFlat = $creator->createWithKeySeparatorPoint($databaseContents);

        $dumpOnlyFlat   = array_diff_key($dumpFlat, $databaseFlat);
        $this->dumpOnly = $extractor->extractWithKeySeparatorPoint($dumpOnlyFlat);

        $databaseOnlyFlat   = array_diff_key($databaseFlat, $dumpFlat);
        $this->databaseOnly = $extractor->extractWithKeySeparatorPoint($databaseOnlyFlat);

        $dumpIntersectFlat     = array_intersect_key($dumpFlat, $databaseFlat);
        $databaseIntersectFlat = array_intersect_key($databaseFlat, $dumpFlat);
        $unequalsFlat          = array_diff_assoc($dumpIntersectFlat, $databaseIntersectFlat);
        $this->unequals        = $extractor->extractWithKeySeparatorPoint($unequalsFlat);

        return $this;
    }

    /**
     * @return int
     */
    public function getCountOfDumpOnly()
    {
        return count($this->dumpOnly);
    }

    /**
     * @return int
     */
    public function getCountOfDatabaseOnly()
    {
        return count($this->databaseOnly);
    }

    /**
     * @return int
     */
    public function getCountOfUnequals()
    {
        return count($this->unequals);
    }

    /**
     * @return bool
     */
    public function isOk()
    {
        return empty($this->dumpOnly) && empty($this->databaseOnly) && empty($this->unequals);
    }
}