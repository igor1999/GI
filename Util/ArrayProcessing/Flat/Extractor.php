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
namespace GI\Util\ArrayProcessing\Flat;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class Extractor implements ExtractorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @param array $source
     * @param \Closure $keysMaker
     * @return array
     */
    public function extract(array $source, \Closure $keysMaker)
    {
        $result = [];

        foreach ($source as $key => $value) {
            $keys = call_user_func($keysMaker, $key);

            if (!is_array($keys) || empty($keys)) {
                trigger_error(
                    'Keys maker should return an array with at least one element', E_USER_ERROR
                );
            }

            $lastKey = array_pop($keys);

            $current = &$result;
            foreach ($keys as $key) {
                if ($key === '') {
                    $last = [];
                    $current[] = $last;
                    $current = &$last;
                } else {
                    if (!array_key_exists($key, $current)) {
                        $current[$key] = [];
                    }
                    $current = &$current[$key];
                }
            }

            if ($lastKey === '') {
                $current[] = $value;
            } else {
                $current[$lastKey] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array $source
     * @param string $separator
     * @return array
     */
    public function extractWithKeySeparator(array $source, string $separator)
    {
        $f = function($key) use ($separator)
        {
            return explode($separator, $key);
        };

        return $this->extract($source, $f);
    }

    /**
     * @param array $source
     * @return array
     */
    public function extractWithKeySeparatorPoint(array $source)
    {
        return $this->extractWithKeySeparator($source, '.');
    }

    /**
     * @param array $source
     * @return array
     */
    public function extractWithKeySeparatorSlash(array $source)
    {
        return $this->extractWithKeySeparator($source, '/');
    }

    /**
     * @param array $source
     * @return array
     */
    public function extractWithKeySeparatorHyphen(array $source)
    {
        return $this->extractWithKeySeparator($source, '-');
    }

    /**
     * @param array $source
     * @return array
     */
    public function extractWithArrayLikeKeys(array $source)
    {
        $f = function($key)
        {
            $key = str_replace(']', '', $key);

            return explode('[', $key);
        };

        return $this->extract($source, $f);
    }
}