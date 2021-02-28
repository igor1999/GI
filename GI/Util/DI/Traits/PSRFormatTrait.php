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

use GI\Util\TextProcessing\PSRFormat\Parser\Parser as PSRFormatParser;
use GI\Util\TextProcessing\PSRFormat\Builder\Builder as PSRFormatBuilder;
use GI\Util\TextProcessing\PSRFormat\CamelCase\CamelCase as CamelCaseConverter;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\TextProcessing\PSRFormat\Parser\ParserInterface as PSRFormatParserInterface;
use GI\Util\TextProcessing\PSRFormat\Builder\BuilderInterface as PSRFormatBuilderInterface;
use GI\Util\TextProcessing\PSRFormat\CamelCase\CamelCaseInterface as CamelCaseConverterInterface;

trait PSRFormatTrait
{
    /**
     * @var PSRFormatParserInterface
     */
    private $psrFormatParser;

    /**
     * @var PSRFormatBuilderInterface
     */
    private $psrFormatBuilder;

    /**
     * @var CamelCaseConverterInterface
     */
    private $camelCaseConverter;


    /**
     * @param string|null $caller
     * @return PSRFormatParserInterface
     */
    public function getPSRFormatParser(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->giGetServiceLocator()->getDi()->find(
                PSRFormatParserInterface::class, $caller
            );
        } catch (\Exception $exception) {
            if (!($this->psrFormatParser instanceof PSRFormatParserInterface)) {
                $this->psrFormatParser = new PSRFormatParser();
            }

            $result = $this->psrFormatParser;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return PSRFormatBuilderInterface
     */
    public function getPSRFormatBuilder(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->giGetServiceLocator()->getDi()->find(
                PSRFormatBuilderInterface::class, $caller
            );
        } catch (\Exception $exception) {
            if (!($this->psrFormatBuilder instanceof PSRFormatBuilderInterface)) {
                $this->psrFormatBuilder = new PSRFormatBuilder();
            }

            $result = $this->psrFormatBuilder;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return CamelCaseConverterInterface
     */
    public function getCamelCaseConverter(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->giGetServiceLocator()->getDi()->find(
                CamelCaseConverterInterface::class, $caller
            );
        } catch (\Exception $e) {
            if (!($this->camelCaseConverter instanceof CamelCaseConverterInterface)) {
                $this->camelCaseConverter = new CamelCaseConverter();
            }

            $result = $this->camelCaseConverter;
        }

        return $result;
    }
}