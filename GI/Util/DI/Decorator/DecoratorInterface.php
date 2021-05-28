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
namespace GI\Util\DI\Decorator;

use GI\ServiceLocator\Decorator\DecoratorInterface as BaseInterface;

use GI\Util\ArrayProcessing\Assoc\AssocInterface as AssocProcessorInterface;
use GI\Util\ArrayProcessing\Extractor\ExtractorInterface;
use GI\Util\ArrayProcessing\Flat\CreatorInterface as FlatCreatorInterface;
use GI\Util\ArrayProcessing\Flat\ExtractorInterface as FlatExtractorInterface;

use GI\Util\Crypt\Password\Encriptor\EncriptorInterface as PasswordEncriptorInterface;
use GI\Util\Crypt\Password\Verifier\VerifierInterface as PasswordVerifierInterface;
use GI\Util\Crypt\Random\Hash\HashInterface as RandomHashGeneratorInterface;
use GI\Util\Crypt\Random\Word\WordInterface as RandomWordGeneratorInterface;

use GI\Util\TextProcessing\Encoding\Encoder\EncoderInterface;

use GI\Util\TextProcessing\Escaper\Factory\Factory\FactoryInterface as EscaperFactoryInterface;
use GI\Util\TextProcessing\Escaper\Factory\Container\ContainerInterface as EscaperContainerInterface;

use GI\Util\TextProcessing\PSRFormat\Parser\ParserInterface as PSRFormatParserInterface;
use GI\Util\TextProcessing\PSRFormat\Builder\BuilderInterface as PSRFormatBuilderInterface;
use GI\Util\TextProcessing\PSRFormat\CamelCase\CamelCaseInterface as CamelCaseConverterInterface;

use GI\Util\SourceMaker\FromFile\FromFileInterface;
use GI\Util\SourceMaker\FromResource\FromResourceInterface;

use GI\Util\TextProcessing\MarkupTextProcessor\MarkupTextProcessorInterface;
use GI\Util\TextProcessing\Splitter\SplitterInterface;

/**
 * Interface DecoratorInterface
 * @package GI\Util\DI\Decorator
 *
 * @method AssocProcessorInterface getAssocProcessor()
 * @method ExtractorInterface getExtractor()
 * @method FlatCreatorInterface getFlatCreator()
 * @method FlatExtractorInterface getFlatExtractor()
 *
 * @method PasswordEncriptorInterface getPasswordEncriptor()
 * @method PasswordVerifierInterface getPasswordVerifier()
 * @method RandomHashGeneratorInterface getRandomHashGenerator()
 * @method RandomWordGeneratorInterface createRandomWordGenerator()
 *
 * @method EncoderInterface getEncoder()
 *
 * @method EscaperFactoryInterface getEscaperFactory()
 * @method EscaperContainerInterface createEscaperContainer()
 *
 * @method PSRFormatParserInterface getPSRFormatParser()
 * @method PSRFormatBuilderInterface getPSRFormatBuilder()
 * @method CamelCaseConverterInterface getCamelCaseConverter()
 *
 * @method FromFileInterface getFromFile()
 * @method FromResourceInterface getFromResource()
 *
 * @method MarkupTextProcessorInterface createMarkupTextProcessor()
 * @method SplitterInterface getSplitter()
 */
interface DecoratorInterface extends BaseInterface
{

}