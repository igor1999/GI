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
namespace GI\REST\Route\Segmented\Behaviour\Segment;

use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;
use GI\Storage\Collection\StringCollection\HashSet\Closable\ClosableInterface as ParamsInterface;

interface SegmentInterface
{
    const PARAM_PREFIX = ':';


    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return bool
     */
    public function isParam();

    /**
     * @param string $value
     * @param ConstraintsInterface $constraints
     * @param ParamsInterface $params
     * @return bool
     * @throws \Exception
     */
    public function validate(string $value, ConstraintsInterface $constraints, ParamsInterface $params);

    /**
     * @param array $params
     * @return string
     */
    public function build(array $params);
}