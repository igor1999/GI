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
namespace GI\REST\Route\Segmented;

use GI\REST\Route\RouteInterface;
use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;

interface SegmentedInterface extends RouteInterface
{
    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @return ConstraintsInterface
     */
    public function getConstraints();

    /**
     * @param string $param
     * @param string|\Closure $constraint
     * @return static
     * @throws \Exception
     */
    public function setConstraint(string $param, $constraint);

    /**
     * @param string $param
     * @return bool
     */
    public function hasParam(string $param);

    /**
     * @param string $param
     * @return string
     */
    public function getParam(string $param);

    /**
     * @return string
     */
    public function getRelativePath();

    /**
     * @return bool
     */
    public function isRelativeMode();

    /**
     * @param bool $relativeMode
     * @return static
     * @throws \Exception
     */
    public function setRelativeMode(bool $relativeMode);

    /**
     * @param string $source
     * @return bool
     * @throws \Exception
     */
    public function validateByString(string $source);

    /**
     * @param array $params
     * @return string
     */
    public function build(array $params = []);
}