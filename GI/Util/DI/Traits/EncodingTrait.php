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
namespace GI\Util\DI\Traits;

use GI\Util\TextProcessing\Encoding\Encoder\Encoder;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\TextProcessing\Encoding\Encoder\EncoderInterface;

trait EncodingTrait
{
    /**
     * @var EncoderInterface
     */
    private $encoder;


    /**
     * @param string|null $caller
     * @return EncoderInterface
     */
    public function getEncoder(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(EncoderInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->encoder instanceof EncoderInterface)) {
                $this->encoder = new Encoder();
            }

            $result = $this->encoder;
        }

        return $result;
    }
}