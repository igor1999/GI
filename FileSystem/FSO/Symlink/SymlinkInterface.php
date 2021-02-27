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
namespace GI\FileSystem\FSO\Symlink;

use GI\FileSystem\FSO\FSOInterface;

interface SymlinkInterface extends FSOInterface
{
    /**
     * @return FSOInterface
     * @throws \Exception
     */
    public function getRealTarget();

    /**
     * @return bool
     */
    public function isTargetReal();

    /**
     * @return static
     */
    public function setTargetToReal();

    /**
     * @return bool
     */
    public function hasTarget();

    /**
     * @return FSOInterface
     * @throws \Exception
     */
    public function getTarget();

    /**
     * @param FSOInterface|null $target
     * @return static
     */
    public function setTarget(FSOInterface $target = null);

    /**
     * @return static
     * @throws \Exception
     */
    public function create();

    /**
     * @param SymlinkInterface $symlink
     * @return static
     * @throws \Exception
     */
    public function makeCopy(SymlinkInterface $symlink);

    /**
     * @param SymlinkInterface $symlink
     * @return static
     * @throws \Exception
     */
    public function move(SymlinkInterface $symlink);

    /**
     * @return bool
     */
    public function isLink();
}