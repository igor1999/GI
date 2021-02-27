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

use GI\JSON\Base\AbstractJson;
use GI\JSON\Decoder\Flags\Flags;

use GI\JSON\Decoder\Flags\FlagsInterface;

/**
 * Class Decoder
 * @package GI\JSON\Decoder
 *
 * @method DecoderInterface setFlagJsonBigintAsString(bool $flag)
 * @method DecoderInterface setFlagJsonInvalidUtf8Ignore(bool $flag)
 * @method DecoderInterface setFlagJsonInvalidUtf8Substitute(bool $flag)
 * @method DecoderInterface setFlagJsonObjectAsArray(bool $flag)
 * @method DecoderInterface setFlagJsonThrowOnError(bool $flag)
 */
class Decoder extends AbstractJson implements DecoderInterface
{
    /**
     * @var FlagsInterface
     */
    private $flags;

    /**
     * @var bool
     */
    private $assoc = true;


    /**
     * Decode constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->flags = $this->giGetDi(FlagsInterface::class, Flags::class);
    }

    /**
     * @return FlagsInterface
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @return bool
     */
    public function isAssoc()
    {
        return $this->assoc;
    }

    /**
     * @param bool $assoc
     * @return static
     */
    public function setAssoc(bool $assoc)
    {
        $this->assoc = $assoc;

        return $this;
    }

    /**
     * @param string $data
     * @return mixed
     * @throws \Exception
     */
    public function decode(string $data)
    {
        $result = json_decode($data, $this->assoc, $this->getDepth(), $this->getFlags()->build());

        $this->validate();

        return $result;
    }
}