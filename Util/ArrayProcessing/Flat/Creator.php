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

class Creator implements CreatorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @param array $contents
     * @param \Closure|null $localKeyMaker
     * @return array
     */
    public function create(array $contents, \Closure $localKeyMaker = null)
    {
        return $this->processCreating($contents, $localKeyMaker);
    }
    
    /**
     * @param array $contents
     * @param \Closure|null $localKeyMaker
     * @param string|null $globalKey
     * @return array
     */
    protected function processCreating(array $contents, \Closure $localKeyMaker = null, $globalKey = null)
    {
        $result = [];

        $isLocalKeyMakerClosure = ($localKeyMaker instanceof \Closure);

        foreach ($contents as $key => $value) {
            $localKey = (empty($globalKey) || !$isLocalKeyMakerClosure)
                ? $key
                : call_user_func($localKeyMaker, $globalKey, $key);

            switch (true) {
                case is_array($value) && $isLocalKeyMakerClosure:
                    $result = array_merge($result, $this->processCreating($value, $localKeyMaker, $localKey));
                    break;
                case !is_array($value) && $isLocalKeyMakerClosure:
                    $result[$localKey] = $value;
                    break;
                case is_array($value) && !$isLocalKeyMakerClosure:
                    $result = array_merge($result, $this->processCreating($value));
                    break;
                default:
                    $result[] = $value;
                    break;
            }
        }

        return $result;
    }

    /**
     * @param array $contents
     * @param string $separator
     * @return array
     */
    public function createWithKeySeparator(array $contents, string $separator)
    {
        $f = function($globalKey, $key) use ($separator)
        {
            return $globalKey . $separator . $key;
        };

        return $this->create($contents, $f);
    }

    /**
     * @param array $contents
     * @return array
     */
    public function createWithKeySeparatorPoint(array $contents)
    {
        return $this->createWithKeySeparator($contents, '.');
    }

    /**
     * @param array $contents
     * @return array
     */
    public function createWithKeySeparatorSlash(array $contents)
    {
        return $this->createWithKeySeparator($contents, '/');
    }

    /**
     * @param array $contents
     * @return array
     */
    public function createWithKeySeparatorHyphen(array $contents)
    {
        return $this->createWithKeySeparator($contents, '-');
    }

    /**
     * @param array $contents
     * @return array
     */
    public function createWithArrayLikeKeys(array $contents)
    {
        $f = function($globalKey, $key)
        {
            return $globalKey . '[' . $key . ']';
        };

        return $this->create($contents, $f);
    }
}