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
namespace GI\JSON\Decoder;

use GI\JSON\Base\JsonInterface;
use GI\JSON\Decoder\Flags\FlagsInterface;

/**
 * Interface DecoderInterface
 * @package GI\JSON\Decoder
 *
 * @method DecoderInterface setFlagJsonBigintAsString(bool $flag)
 * @method DecoderInterface setFlagJsonInvalidUtf8Ignore(bool $flag)
 * @method DecoderInterface setFlagJsonInvalidUtf8Substitute(bool $flag)
 * @method DecoderInterface setFlagJsonObjectAsArray(bool $flag)
 * @method DecoderInterface setFlagJsonThrowOnError(bool $flag)
 */
interface DecoderInterface extends JsonInterface
{
    /**
     * @return FlagsInterface
     */
    public function getFlags();

    /**
     * @return bool
     */
    public function isAssoc();

    /**
     * @param bool $assoc
     * @return static
     */
    public function setAssoc(bool $assoc);

    /**
     * @param string $data
     * @return mixed
     * @throws \Exception
     */
    public function decode(string $data);
}