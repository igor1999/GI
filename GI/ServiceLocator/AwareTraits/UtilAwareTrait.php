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
namespace GI\ServiceLocator\AwareTraits;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\DI\DIInterface as UtilitesInterface;

use GI\Util\ArrayProcessing\Extractor\ExtractorInterface;
use GI\Util\ArrayProcessing\Assoc\AssocInterface;
use GI\Util\ArrayProcessing\Flat\CreatorInterface as FlatCreatorInterface;
use GI\Util\ArrayProcessing\Flat\ExtractorInterface as FlatExtractorInterface;

use GI\Util\Crypt\Password\Encriptor\EncriptorInterface as PasswordEncriptorInterface;
use GI\Util\Crypt\Password\Verifier\VerifierInterface as PasswordVerifierInterface;
use GI\Util\Crypt\Random\Hash\HashInterface as RandomHashGeneratorInterface;
use GI\Util\Crypt\Random\Word\WordInterface as RandomWordGeneratorInterface;

use GI\Util\SourceMaker\FromFile\FromFileInterface;
use GI\Util\SourceMaker\FromResource\FromResourceInterface;

use GI\Util\TextProcessing\Encoding\Encoder\EncoderInterface;

use GI\Util\TextProcessing\Escaper\Factory\Factory\FactoryInterface as EscaperFactoryInterface;
use GI\Util\TextProcessing\Escaper\Factory\Container\ContainerInterface as EscaperContainerInterface;

use GI\Util\TextProcessing\PSRFormat\Parser\ParserInterface as PSRFormatParserInterface;
use GI\Util\TextProcessing\PSRFormat\Builder\BuilderInterface as PSRFormatBuilderInterface;
use GI\Util\TextProcessing\PSRFormat\CamelCase\CamelCaseInterface as CamelCaseConverterInterface;

use GI\Util\TextProcessing\TextProcessor\MarkupTextProcessorInterface;
use GI\Util\TextProcessing\Splitter\SplitterInterface;

trait UtilAwareTrait
{
    /**
     * @return UtilitesInterface
     */
    protected function giGetUtilites()
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        return $me->giGetServiceLocator()->getUtilites();
    }

    /**
     * @return AssocInterface
     */
    protected function giGetAssocProcessor()
    {
        return $this->giGetUtilites()->getAssocProcessor(static::class);
    }

    /**
     * @return ExtractorInterface
     */
    protected function giGetExtractor()
    {
        return $this->giGetUtilites()->getExtractor(static::class);
    }

    /**
     * @return FlatCreatorInterface
     */
    protected function giGetFlatCreator()
    {
        return $this->giGetUtilites()->getFlatCreator(static::class);
    }

    /**
     * @return FlatExtractorInterface
     */
    protected function giGetFlatExtractor()
    {
        return $this->giGetUtilites()->getFlatExtractor(static::class);
    }

    /**
     * @return PasswordEncriptorInterface
     */
    protected function giGetPasswordEncriptor()
    {
        return $this->giGetUtilites()->getPasswordEncriptor(static::class);
    }

    /**
     * @return PasswordVerifierInterface
     */
    protected function giGetPasswordVerifier()
    {
        return $this->giGetUtilites()->getPasswordVerifier(static::class);
    }

    /**
     * @return RandomHashGeneratorInterface
     */
    protected function giGetRandomHashGenerator()
    {
        return $this->giGetUtilites()->getRandomHashGenerator(static::class);
    }

    /**
     * @return RandomWordGeneratorInterface
     */
    protected function giCreateRandomWordGenerator()
    {
        return $this->giGetUtilites()->createRandomWordGenerator(static::class);
    }

    /**
     * @return EncoderInterface
     */
    protected function giGetEncoder()
    {
        return $this->giGetUtilites()->getEncoder(static::class);
    }

    /**
     * @return EscaperFactoryInterface
     */
    protected function giGetEscaperFactory()
    {
        return $this->giGetUtilites()->getEscaperFactory(static::class);
    }

    /**
     * @return EscaperContainerInterface
     */
    protected function giCreateEscaperContainer()
    {
        return $this->giGetUtilites()->createEscaperContainer(static::class);
    }

    /**
     * @return PSRFormatParserInterface
     */
    protected function giGetPSRFormatParser()
    {
        return $this->giGetUtilites()->getPSRFormatParser(static::class);
    }

    /**
     * @return PSRFormatBuilderInterface
     */
    protected function giGetPSRFormatBuilder()
    {
        return $this->giGetUtilites()->getPSRFormatBuilder(static::class);
    }

    /**
     * @return CamelCaseConverterInterface
     */
    protected function giGetCamelCaseConverter()
    {
        return $this->giGetUtilites()->getCamelCaseConverter(static::class);
    }

    /**
     * @return FromFileInterface
     */
    protected function giGetFromFileSourceMaker()
    {
        return $this->giGetUtilites()->getFromFile(static::class);
    }

    /**
     * @return FromResourceInterface
     */
    protected function giGetFromResourceSourceMaker()
    {
        return $this->giGetUtilites()->getFromResource(static::class);
    }

    /**
     * @return MarkupTextProcessorInterface
     */
    protected function giCreateMarkupTextProcessor()
    {
        return $this->giGetUtilites()->createMarkupTextProcessor(static::class);
    }

    /**
     * @return SplitterInterface
     */
    protected function giGetSplitter()
    {
        return $this->giGetUtilites()->getSplitter(static::class);
    }
}