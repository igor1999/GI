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
namespace GI\Util\Crypt\Random\Word;

use GI\Util\Crypt\Random\Word\Alphabet\Alphabet;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\Crypt\Random\Word\Alphabet\AlphabetInterface;

class Word implements WordInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_SPLIT_LENGTH = 4;


    /**
     * @var AlphabetInterface
     */
    private $alphabet;


    /**
     * Word constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->alphabet = $this->getGiServiceLocator()->getDependency(AlphabetInterface::class,Alphabet::class);
    }

    /**
     * @return AlphabetInterface
     */
    public function getAlphabet()
    {
        return $this->alphabet;
    }

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function create(int $length)
    {
        $result = '';

        $alphabet = $this->getAlphabet()->merge();

        while (true) {
            $hash  = $this->getGiServiceLocator()->getUtilites()->getRandomHashGenerator()->create(count($alphabet));
            $codes = str_split($hash, static::DEFAULT_SPLIT_LENGTH);

            foreach ($codes as $code) {
                $sum = 0;
                foreach (str_split($code) as $letter) {
                    $sum += ord($letter);
                }
                $index = $sum % count($alphabet);
                $result .= $alphabet[$index];

                if (strlen($result) >= $length) {
                    break 2;
                }
            }
        }

        return $result;
    }
}