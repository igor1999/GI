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
namespace GI\Util\TextProcessing\Encoding;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\TextProcessing\Encoding\Context\ContextInterface;

trait EncodingTrait
{
    /**
     * @var string
     */
    private $encoding = EncodingInterface::DEFAULT_ENCODING;


    /**
     * @var array
     */
    private $encodings = [
        'iso-8859-1',   'iso8859-1',    'iso-8859-5', 'iso8859-5', 'iso-8859-15',
        'iso8859-15',   'utf-8',        'cp866',      'ibm866',    '866',
        'cp1251',       'windows-1251', 'win-1251',   '1251',      'cp1252',
        'windows-1252', '1252',         'koi8-r',     'koi8-ru',   'koi8r',
        'big5',         '950',          'gb2312',     '936',       'big5-hkscs',
        'shift_jis',    'sjis',         'sjis-win',   'cp932',     '932',
        'euc-jp',       'eucjp',        'eucjp-win',  'macroman'
    ];


    /**
     * @return array
     */
    protected function getEncodings()
    {
        return $this->encodings;
    }

    /**
     * @param array $encodings
     * @return static
     */
    protected function setEncodings(array $encodings)
    {
        $this->encodings = $encodings;

        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     * @return static
     * @throws \Exception
     */
    public function setEncoding(string $encoding)
    {
        if (!in_array(strtolower($encoding), $this->encodings)) {
            /** @var ServiceLocatorAwareTrait $me */
            $me = $this;
            $me->giThrowCommonException('Encoding \'%s\' is not supported', [$encoding]);
        }

        $this->encoding = $encoding;

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function initEncodingByContext()
    {
        try {
            /** @var ContextInterface $context */
            $context  = $this->giGetDi(ContextInterface::class);

            $this->encodings = array_unique(array_merge($this->encodings, $context->getEncodings()));

            $this->setEncoding($context->getEncoding());
        } catch (\Exception $e) {
            $this->setEncoding(EncodingInterface::DEFAULT_ENCODING);
        }

        return $this;
    }
}