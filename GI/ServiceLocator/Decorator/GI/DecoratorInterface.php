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
namespace GI\ServiceLocator\Decorator\GI;

use GI\ServiceLocator\Decorator\DecoratorInterface as BaseInterface;

use GI\RDB\DI\Decorator\DecoratorAwareInterface as RDBDecoratorAwareInterface;
use GI\Util\DI\Decorator\DecoratorAwareInterface as UtilDecoratorAwareInterface;

use GI\ServiceLocator\ServiceLocatorInterface;
use GI\CLI\Factory\FactoryInterface as CLIFactoryInterface;
use GI\FileSystem\Factory\FactoryInterface as FileSystemFactoryInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\FSO\Symlink\URLHolder\URLHolderInterface;
use GI\Filter\Factory\FactoryInterface as FilterFactoryInterface;
use GI\Validator\Factory\FactoryInterface as ValidatorFactoryInterface;
use GI\I18n\Locales\Sounding\SoundingInterface;
use GI\Identity\Access\ProfileInterface as AccessProfileInterface;
use GI\JSON\Decoder\DecoderInterface as JsonDecoderInterface;
use GI\JSON\Encoder\EncoderInterface as JsonEncoderInterface;
use GI\ClientContents\Selection\Factory\FactoryInterface as ClientSelectionFactoryInterface;
use GI\Email\EmailInterface;
use GI\Calendar\Factory\FactoryInterface as CalendarFactoryInterface;
use GI\Logger\LoggerInterface;
use GI\Storage\Factory\FactoryInterface as StorageFactoryInterface;
use GI\SocketDemon\Factory\FactoryInterface as SocketDemonFactoryInterface;
use GI\REST\Route\Factory\FactoryInterface as RouteFactoryInterface;
use GI\REST\Response\Factory\FactoryInterface as ResponseFactoryInterface;
use GI\REST\URL\Builder\BuilderInterface as URLBuilderInterface;
use GI\Security\Captcha\Factory\FactoryInterface as CaptchaFactoryInterface;
use GI\Security\CSRF\CSRFInterface;
use GI\DOM\Factory\FactoryInterface as DOMFactoryInterface;
use GI\Component\Factory\FactoryInterface as ComponentFactoryInterface;
use GI\DI\DIInterface;
use GI\Event\ManagerInterface;
use GI\I18n\Translator\TranslatorInterface;
use GI\Meta\MetaInterface as GIMetaInterface;
use GI\Meta\ClassMeta\ClassMetaInterface;
use GI\CLI\CommandLine\CommandLineInterface;
use GI\REST\Request\Factory\FactoryInterface as RequestFactoryInterface;
use GI\REST\Request\Server\ServerInterface;
use GI\REST\Route\RouteInterface;

/**
 * Interface DecoratorInterface
 * @package GI\ServiceLocator\Decorator\GI
 *
 * @method CLIFactoryInterface getCLIFactory()
 * @method FileSystemFactoryInterface getFileSystemFactory()
 * @method FilterFactoryInterface getFilterFactory()
 * @method ValidatorFactoryInterface getValidatorFactory()
 * @method SoundingInterface createSounding()
 * @method AccessProfileInterface getAccessProfile()
 * @method JsonEncoderInterface createJsonEncoder()
 * @method JsonDecoderInterface createJsonDecoder()
 * @method ClientSelectionFactoryInterface getClientSelectionFactory()
 * @method EmailInterface createEmail()
 * @method CalendarFactoryInterface getCalendarFactory()
 * @method LoggerInterface createLogger()
 * @method StorageFactoryInterface getStorageFactory()
 * @method SocketDemonFactoryInterface getSocketDemonFactory()
 * @method RouteFactoryInterface getRouteFactory()
 * @method ResponseFactoryInterface getResponseFactory()
 * @method URLBuilderInterface createURLBuilder()
 * @method CaptchaFactoryInterface getCaptchaFactory()
 * @method CSRFInterface createSecureCSRF()
 * @method DOMFactoryInterface getDOMFactory()
 * @method ComponentFactoryInterface getComponentFactory()
 */
interface DecoratorInterface
    extends BaseInterface, ExceptionAwareInterface, UtilDecoratorAwareInterface, RDBDecoratorAwareInterface
{
    /**
     * @return ServiceLocatorInterface
     */
    public function getInstance();

    /**
     * @return bool
     */
    public function isClosed();

    /**
     * @return static
     */
    public function close();

    /**
     * @return static
     * @throws \Exception
     */
    public function setExceptionHandler();

    /**
     * @return bool
     */
    public function isCLI();

    /**
     * @return DIInterface
     */
    public function getDi();

    /**
     * @param string $interface
     * @param mixed|null $default
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function getDependency(string $interface, $default = null, array $params = []);

    /**
     * @param DIInterface $di
     * @return static
     * @throws \Exception
     */
    public function setDi(DIInterface $di);

    /**
     * @param ManagerInterface $eventManager
     * @return static
     * @throws \Exception
     */
    public function mergeEvents(ManagerInterface $eventManager);

    /**
     * @param string $event
     * @param array $params
     * @return array
     */
    public function fireEvent(string $event, array $params = []);

    /**
     * @param string $path
     * @return FSODirInterface
     */
    public function createFSODir(string $path);

    /**
     * @param string $path
     * @return FSOFileInterface
     */
    public function createFSOFile(string $path);

    /**
     * @param string $class
     * @param string $childPath
     * @return FSODirInterface
     */
    public function createClassDirChildDir(string $class, string $childPath);

    /**
     * @param string $class
     * @param string $childPath
     * @return FSOFileInterface
     */
    public function createClassDirChildFile(string $class, string $childPath);

    /**
     * @param string $class
     * @param string $relativePathToTarget
     * @param string $relativeURL
     * @param bool $withCreate
     * @return URLHolderInterface
     * @throws \Exception
     */
    public function createURLHolderByClass(
        string $class, string $relativePathToTarget, string $relativeURL, bool $withCreate = true);

    /**
     * @param FSODirInterface $targetBase
     * @param FSODirInterface $urlBase
     * @param string $relativePath
     * @param bool $withCreate
     * @return URLHolderInterface
     * @throws \Exception
     */
    public function createURLHolderByRelativePath(
        FSODirInterface $targetBase, FSODirInterface $urlBase, string $relativePath, bool $withCreate = true);

    /**
     * @param string $interface
     * @param mixed $default
     * @param string $text
     * @return string
     */
    public function translate(string $interface, $default, string $text);

    /**
     * @param string $interface
     * @param mixed $default
     * @return TranslatorInterface
     * @throws \Exception
     */
    public function createDefaultTranslator(string $interface, $default);

    /**
     * @return string
     */
    public function getUserLocale();

    /**
     * @param string $userLocale
     * @return static
     * @throws \Exception
     */
    public function setUserLocale(string $userLocale);

    /**
     * @return GIMetaInterface
     */
    public function getMeta();

    /**
     * @param mixed|null $source
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function getClassMeta($source = null);

    /**
     * @param string|null $descriptor
     * @return array
     * @throws \Exception
     */
    public function extract(string $descriptor = null);

    /**
     * @param array $data
     * @param string|null $descriptor
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $data, string $descriptor = null);

    /**
     * @param string|null $descriptor
     * @return static
     * @throws \Exception
     */
    public function validate(string $descriptor = null);

    /**
     * @return RequestFactoryInterface
     */
    public function getRequest();

    /**
     * @return RequestFactoryInterface
     */
    public function createRequestFactory();

    /**
     * @param RequestFactoryInterface $request
     * @return static
     * @throws \Exception
     */
    public function setRequest(RequestFactoryInterface $request);

    /**
     * @return ServerInterface
     */
    public function getServer();

    /**
     * @return CommandLineInterface
     */
    public function getCommandLine();

    /**
     * @return RouteInterface
     * @throws \Exception
     */
    public function getRoute();

    /**
     * @param RouteInterface $route
     * @return static
     * @throws \Exception
     */
    public function setRoute(RouteInterface $route);

    /**
     * @return string
     */
    public function getSessionID();

    /**
     * @param string[] $classes
     * @return static
     * @throws \Exception
     */
    public function setSessionExchangeClasses(array $classes);

    /**
     * @param array|null $session
     * @return static
     * @throws \Exception
     */
    public function loadSession(array $session = null);

    /**
     * @return array
     * @throws \Exception
     */
    public function saveSession();
}