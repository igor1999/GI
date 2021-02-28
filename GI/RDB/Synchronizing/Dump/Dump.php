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
namespace GI\RDB\Synchronizing\Dump;

use GI\RDB\Synchronizing\AbstractSynchronizing;
use GI\RDB\Synchronizing\View\Dump\Dump as DumpView;

use GI\RDB\Synchronizing\View\Dump\DumpInterface as DumpViewInterface;

class Dump extends AbstractSynchronizing implements DumpInterface
{
    /**
     * @var DumpViewInterface
     */
    private $view;


    /**
     * Dump constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->view = $this->giGetDi(DumpViewInterface::class, DumpView::class);
    }

    /**
     * @return DumpViewInterface
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function dump()
    {
        try {
            $contents = $this->getDriver()->getTableList()->extract();
            $this->getView()->getTablesRenderer()->setContents($contents);
            $this->getView()->save($this->getDumpFile());

            $this->getResultMessageCreator()->createDump($this->getDumpFile()->getPath());
        } catch (\Exception $e) {
            $this->getResultMessageCreator()->createError($e->getMessage());
        }

        return $this;
    }
}