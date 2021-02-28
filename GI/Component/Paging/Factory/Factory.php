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
namespace GI\Component\Paging\Factory;

use GI\Component\Factory\Base\AbstractFactory;

use GI\Component\Paging\Common\Common;
use GI\Component\Paging\Dash\Dash;
use GI\Component\Paging\Dropdown\Dropdown;
use GI\Component\Paging\Snapshot\Snapshot;
use GI\Component\Paging\Wings\Wings;


use GI\Component\Paging\Base\ViewModel\ViewModelInterface;

use GI\Component\Paging\Common\CommonInterface;
use GI\Component\Paging\Dash\DashInterface;
use GI\Component\Paging\Dropdown\DropdownInterface;
use GI\Component\Paging\Snapshot\SnapshotInterface;
use GI\Component\Paging\Wings\WingsInterface;

/**
 * Class Factory
 * @package GI\Component\Paging\Factory
 *
 * @method CommonInterface createCommon(ViewModelInterface $viewModel = null, int $entriesTotal = 0)
 * @method DashInterface createDash(ViewModelInterface $viewModel = null, int $entriesTotal = 0)
 * @method DropdownInterface createDropdown(ViewModelInterface $viewModel = null, int $entriesTotal = 0)
 * @method SnapshotInterface createSnapshot(ViewModelInterface $viewModel = null, int $entriesTotal = 0)
 * @method WingsInterface createWings(ViewModelInterface $viewModel = null, int $entriesTotal = 0)
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->set(Common::class)
            ->set(Dash::class)
            ->set(Dropdown::class)
            ->set(Snapshot::class)
            ->set(Wings::class);
    }
}