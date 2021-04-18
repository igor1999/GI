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
namespace GI\REST\Route\Segmented\Behaviour\Formatter;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Formatter implements FormatterInterface
{
    use ServiceLocatorAwareTrait;


    const SEPARATOR = '/';


    /**
     * @return bool
     */
    public function getDirection()
    {
        return true;
    }

    /**
     * @param string $source
     * @return array
     */
    public function parse(string $source)
    {
        $f = function(string $item)
        {
            return !empty($item) || ($item === '0');
        };

        return array_filter(explode(static::SEPARATOR, $source), $f);
    }

    /**
     * @param array $segments
     * @return string
     */
    public function compile(array $segments)
    {
        return implode(static::SEPARATOR, $segments);
    }

    /**
     * @param array $titles
     * @param int $templateLength
     * @return array
     * @throws \Exception
     */
    public function getTitlesAndRelativePath(array $titles, int $templateLength)
    {
        if (count($titles) < $templateLength) {
            $this->giThrowCommonException('Too less titles');
        }

        if ($this->getDirection()) {
            $segments     = array_slice($titles, 0, $templateLength);

            $relatives    = array_slice($titles, $templateLength);
            $relativePath = $this->compile($this->filterRelativePath($relatives));
        } else {
            $segments     = array_slice($titles, count($titles) - $templateLength);

            $relatives    = array_slice($titles, 0, count($titles) - $templateLength);
            $relativePath = $this->compile($this->filterRelativePath($relatives));
        }

        return [$segments, $relativePath];
    }

    /**
     * @param array $titles
     * @return array
     */
    protected function filterRelativePath(array $titles)
    {
        $f = function($title)
        {
            return $title != trim('..');
        };

        return array_filter($titles, $f);
    }
}