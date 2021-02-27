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

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Storage\Collection\StringCollection\HashSet\Closable\ClosableInterface as ParamsInterface;
use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;

class Segment implements SegmentInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $title = '';

    /**
     * @var bool
     */
    private $isParam = false;


    /**
     * Segment constructor.
     * @param string $title
     * @throws \Exception
     */
    public function __construct(string $title)
    {
        try {
            $this->title   = $this->giGetPSRFormatParser()->parseAfterPrefix($title, self::PARAM_PREFIX);
            $this->isParam = true;
        } catch (\Exception $exception) {
            $this->title   = $title;
            $this->isParam = false;
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function isParam()
    {
        return $this->isParam;
    }

    /**
     * @param string $value
     * @param ConstraintsInterface $constraints
     * @param ParamsInterface $params
     * @return bool
     * @throws \Exception
     */
    public function validate(string $value, ConstraintsInterface $constraints, ParamsInterface $params)
    {
        if ($this->isParam) {
            $params->set($this->title, $value);
            $result = $constraints->validate($this->title, $value);
        } else {
            $result = ($this->title == $value);
        }

        return $result;
    }

    /**
     * @param array $params
     * @return string
     */
    public function build(array $params)
    {
        if (!$this->isParam) {
            $result = $this->title;
        } elseif (array_key_exists($this->title, $params)) {
            $result = $params[$this->title];
        } else {
            $result = self::PARAM_PREFIX . $this->title;
        }

        return $result;
    }
}