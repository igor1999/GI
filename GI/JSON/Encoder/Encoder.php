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
namespace GI\JSON\Encoder;

use GI\JSON\Base\AbstractJson;
use GI\JSON\Encoder\Flags\Flags;

use GI\JSON\Encoder\Flags\FlagsInterface;

/**
 * Class Encoder
 * @package GI\JSON\Encoder
 * 
 * @method EncoderInterface setFlagJsonForceObject(bool $flag)
 * @method EncoderInterface setFlagJsonHexQuot(bool $flag)
 * @method EncoderInterface setFlagJsonHexTag(bool $flag)
 * @method EncoderInterface setFlagJsonHexAmp(bool $flag)
 * @method EncoderInterface setFlagJsonHexApos(bool $flag)
 * @method EncoderInterface setFlagJsonInvalidUtf8Ignore(bool $flag)
 * @method EncoderInterface setFlagJsonInvalidUtf8Substitute(bool $flag)
 * @method EncoderInterface setFlagJsonNumericCheck(bool $flag)
 * @method EncoderInterface setFlagJsonPartialOutputOnError(bool $flag)
 * @method EncoderInterface setFlagJsonPreserveZeroFraction(bool $flag)
 * @method EncoderInterface setFlagJsonPrettyPrint(bool $flag)
 * @method EncoderInterface setFlagJsonUnescapedLineTerminators(bool $flag)
 * @method EncoderInterface setFlagJsonUnescapedSlashes(bool $flag)
 * @method EncoderInterface setFlagJsonUnescapedUnicode(bool $flag)
 * @method EncoderInterface setFlagJsonThrowOnError(bool $flag)
 */
class Encoder extends AbstractJson implements EncoderInterface
{
    /**
     * @var FlagsInterface
     */
    private $flags;


    /**
     * Encode constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->flags = $this->getGiServiceLocator()->getDependency(FlagsInterface::class, Flags::class);
    }

    /**
     * @return FlagsInterface
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @param mixed $data
     * @return string
     * @throws \Exception
     */
    public function encode($data)
    {
        $result = json_encode($data, $this->getFlags()->build(), $this->getDepth());

        $this->validate();

        return $result;
    }

    /**
     * @param mixed $data
     * @return string
     * @throws \Exception
     */
    public function extractAndEncode($data)
    {
        return $this->encode($this->getGiServiceLocator()->getUtilites()->getExtractor()->extract($data));
    }
}