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

use GI\ServiceLocator\Decorator\AbstractDecorator as Base;
use GI\ServiceLocator\ServiceLocator;

use GI\RDB\DI\Decorator\DecoratorAwareTrait as RDBDecoratorAwareTrait;
use GI\Util\DI\Decorator\DecoratorAwareTrait as UtilDecoratorAwareTrait;

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
 * Class Decorator
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
class Decorator extends Base implements DecoratorInterface
{
    use ExceptionAwareTrait, UtilDecoratorAwareTrait, RDBDecoratorAwareTrait;

    /**
     * @return ServiceLocatorInterface
     */
    protected function getServiceLocator()
    {
        return ServiceLocator::getInstance();
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getInstance()
    {
        return $this->getServiceLocator();
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->getServiceLocator()->isClosed();
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->getServiceLocator()->close();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function setExceptionHandler()
    {
        $this->getServiceLocator()->setExceptionHandler();

        return $this;
    }

    /**
     * @return bool
     */
    public function isCLI()
    {
        return $this->getServiceLocator()->isCLI();
    }

    /**
     * @return DIInterface
     */
    public function getDi()
    {
        return $this->getServiceLocator()->getDi();
    }

    /**
     * @param string $interface
     * @param mixed|null $default
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function getDependency(string $interface, $default = null, array $params = [])
    {
        return $this->getServiceLocator()->getDi()->find($interface, static::class, $default, $params);
    }

    /**
     * @param DIInterface $di
     * @return static
     * @throws \Exception
     */
    public function setDi(DIInterface $di)
    {
        $this->getServiceLocator()->setDi($di);

        return $this;
    }

    /**
     * @param ManagerInterface $eventManager
     * @return static
     * @throws \Exception
     */
    public function mergeEvents(ManagerInterface $eventManager)
    {
        $this->getServiceLocator()->mergeEvents($eventManager);

        return $this;
    }

    /**
     * @param string $event
     * @param array $params
     * @return array
     */
    public function fireEvent(string $event, array $params = [])
    {
        return $this->getServiceLocator()->fireEvent($event, $params);
    }

    /**
     * @param string $path
     * @return FSODirInterface
     */
    public function createFSODir(string $path)
    {
        return $this->getFileSystemFactory()->createDir($path);
    }

    /**
     * @param string $path
     * @return FSOFileInterface
     */
    public function createFSOFile(string $path)
    {
        return $this->getFileSystemFactory()->createFile($path);
    }

    /**
     * @param string $class
     * @param string $childPath
     * @return FSODirInterface
     */
    public function createClassDirChildDir(string $class, string $childPath)
    {
        return $this->getFileSystemFactory()->createClassDir($class)->createChildDir($childPath);
    }

    /**
     * @param string $class
     * @param string $childPath
     * @return FSOFileInterface
     */
    public function createClassDirChildFile(string $class, string $childPath)
    {
        return $this->getFileSystemFactory()->createClassDir($class)->createChildFile($childPath);
    }

    /**
     * @param string $class
     * @param string $relativePathToTarget
     * @param string $relativeURL
     * @param bool $withCreate
     * @return URLHolderInterface
     * @throws \Exception
     */
    public function createURLHolderByClass(
        string $class, string $relativePathToTarget, string $relativeURL, bool $withCreate = true)
    {
        $target = $this->createClassDirChildFile($class, $relativePathToTarget);
        $result = $this->getFileSystemFactory()->createURLHolder($target, $relativeURL);

        if ($withCreate) {
            $result->create();
        }

        return $result;
    }

    /**
     * @param FSODirInterface $targetBase
     * @param FSODirInterface $urlBase
     * @param string $relativePath
     * @param bool $withCreate
     * @return URLHolderInterface
     * @throws \Exception
     */
    public function createURLHolderByRelativePath(
        FSODirInterface $targetBase, FSODirInterface $urlBase, string $relativePath, bool $withCreate = true)
    {
        $target = $targetBase->createChildFile($relativePath);
        $url    = $urlBase->createChildFile($relativePath)->getPath();

        $result = $this->getFileSystemFactory()->createURLHolder($target, $url);

        if ($withCreate) {
            $result->create();
        }

        return $result;
    }

    /**
     * @param string $interface
     * @param mixed $default
     * @param string $text
     * @return string
     */
    public function translate(string $interface, $default, string $text)
    {
        return $this->getServiceLocator()->translate($interface, $default, $text);
    }

    /**
     * @param string $interface
     * @param mixed $default
     * @return TranslatorInterface
     * @throws \Exception
     */
    public function createDefaultTranslator(string $interface, $default)
    {
        return $this->getServiceLocator()->createDefaultTranslator($interface, $default);
    }

    /**
     * @return string
     */
    public function getUserLocale()
    {
        return $this->getServiceLocator()->getUserLocale();
    }

    /**
     * @param string $userLocale
     * @return static
     * @throws \Exception
     */
    public function setUserLocale(string $userLocale)
    {
        $this->getServiceLocator()->setUserLocale($userLocale);

        return $this;
    }

    /**
     * @return GIMetaInterface
     */
    public function getMeta()
    {
        return $this->getServiceLocator()->getMeta();
    }

    /**
     * @param mixed|null $source
     * @return ClassMetaInterface
     * @throws \Exception
     */
    public function getClassMeta($source = null)
    {
        if (empty($source)) {
            $source = static::class;
        }

        return $this->getMeta()->getClassMeta($source);
    }

    /**
     * @param string|null $descriptor
     * @return array
     * @throws \Exception
     */
    public function extract(string $descriptor = null)
    {
        return $this->getClassMeta()->extract($this, $descriptor);
    }

    /**
     * @param array $data
     * @param string|null $descriptor
     * @return static
     * @throws \Exception
     */
    public function hydrate(array $data, string $descriptor = null)
    {
        $this->getClassMeta()->hydrate($this, $data, $descriptor);

        return $this;
    }

    /**
     * @param string|null $descriptor
     * @return static
     * @throws \Exception
     */
    public function validate(string $descriptor = null)
    {
        $this->getClassMeta()->getMethods()->validate($this, $descriptor);

        return $this;
    }

    /**
     * @return RequestFactoryInterface
     */
    public function getRequest()
    {
        return $this->getServiceLocator()->getRequest();
    }

    /**
     * @return RequestFactoryInterface
     */
    public function createRequestFactory()
    {
        return $this->getServiceLocator()->createRequestFactory();
    }

    /**
     * @param RequestFactoryInterface $request
     * @return static
     * @throws \Exception
     */
    public function setRequest(RequestFactoryInterface $request)
    {
        $this->getServiceLocator()->setRequest($request);

        return $this;
    }

    /**
     * @return ServerInterface
     */
    public function getServer()
    {
        return $this->getServiceLocator()->getServer();
    }

    /**
     * @return CommandLineInterface
     */
    public function getCommandLine()
    {
        return $this->getServiceLocator()->getCommandLine();
    }

    /**
     * @return RouteInterface
     * @throws \Exception
     */
    public function getRoute()
    {
        return $this->getServiceLocator()->getRoute();
    }

    /**
     * @param RouteInterface $route
     * @return static
     * @throws \Exception
     */
    public function setRoute(RouteInterface $route)
    {
        $this->getServiceLocator()->setRoute($route);

        return $this;
    }

    /**
     * @return string
     */
    public function getSessionID()
    {
        return $this->getServiceLocator()->getSessionID();
    }

    /**
     * @param string[] $classes
     * @return static
     * @throws \Exception
     */
    public function setSessionExchangeClasses(array $classes)
    {
        $this->getServiceLocator()->setSessionExchangeClasses($classes);

        return $this;
    }

    /**
     * @param array|null $session
     * @return static
     * @throws \Exception
     */
    public function loadSession(array $session = null)
    {
        $this->getServiceLocator()->loadSession($session);

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function saveSession()
    {
        return $this->getServiceLocator()->saveSession();
    }
}