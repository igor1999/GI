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
namespace GI\ServiceLocator\Traits;

use GI\JSON\Encoder\Encoder as JsonEncoder;
use GI\JSON\Decoder\Decoder as JsonDecoder;

use GI\ServiceLocator\ServiceLocatorInterface;
use GI\JSON\Encoder\EncoderInterface as JsonEncoderInterface;
use GI\JSON\Decoder\DecoderInterface as JsonDecoderInterface;

trait JsonTrait
{
    /**
     * @param string|null $caller
     * @return JsonEncoderInterface
     */
    public function createJsonEncoder(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(JsonEncoderInterface::class, $caller);
        } catch (\Exception $e) {
            $result = new JsonEncoder();
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return JsonDecoderInterface
     */
    public function createJsonDecoder(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(JsonDecoderInterface::class, $caller);
        } catch (\Exception $e) {
            $result = new JsonDecoder();
        }

        return $result;
    }
}