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
namespace GI\Debugging\Handler;

use GI\Exception\AbstractException as GIException;

use GI\Debugging\Event\Manager as EventManager;
use GI\Debugging\Handler\View\View;
use GI\Debugging\Mock\View\View as MockView;
use GI\Debugging\Tracing\Tracing\Tracing;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Debugging\Event\ManagerInterface as EventManagerInterface;
use GI\Debugging\Handler\View\ViewInterface;
use GI\Debugging\Mock\View\ViewInterface as MockViewInterface;
use GI\Debugging\Tracing\Tracing\TracingInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\Debugging\Handler\Context\ContextInterface;

class Handler implements HandlerInterface
{
    use ServiceLocatorAwareTrait;


    const GI_EXCEPTION_TITLE    = 'GI Exception: ';

    const PHP_EXCEPTION_TITLE   = 'PHP Exception: ';

    const THROWABLE_ERROR_TITLE = 'Throwable Error: ';

    const ERROR_TITLE           = 'Error: ';

    const THROWABLE_TITLE       = 'Throwable: ';


    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * @var FSOFileInterface
     */
    private $target;


    /**
     * AbstractHandler constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);
            $this->target = $context->getFile();
        } catch (\Exception $exception) {}
    }

    /**
     * @return ViewInterface
     * @throws \Exception
     */
    protected function getView()
    {
        if (!($this->view instanceof ViewInterface)) {
            $this->view = $this->giGetDi(ViewInterface::class, View::class);
        }

        return $this->view;
    }

    /**
     * @return MockViewInterface
     * @throws \Exception
     */
    protected function createMockView()
    {
        try {
            $result = $this->giGetDi(MockViewInterface::class);
        } catch (\Exception $e) {
            $result = new MockView();
        }

        return $result;
    }

    /**
     * @return EventManagerInterface
     * @throws \Exception
     */
    protected function getEventManager()
    {
        if (!($this->eventManager instanceof EventManagerInterface)) {
            $this->eventManager = $this->giGetDi(EventManagerInterface::class, EventManager::class);
        }

        return $this->eventManager;
    }

    /**
     * @return FSOFileInterface
     */
    protected function getTarget()
    {
        return $this->target;
    }

    /**
     * @param array $contents
     * @return TracingInterface
     * @throws \Exception
     */
    protected function createTracing(array $contents)
    {
        try {
            $result = $this->giGetDi(TracingInterface::class, null, [$contents]);
        } catch (\Exception $e) {
            $result = new Tracing($contents);
        }

        return $result;
    }

    /**
     * @param string $file
     * @param int $line
     * @param mixed $code
     * @param string $message
     * @param array $tracing
     * @throws \Exception
     */
    protected function report(string $file, int $line, $code, string $message, array $tracing = [])
    {
        $this->getEventManager()->fireBefore([$file, $line, $code, $message]);

        $this->getView()
            ->setFile($file)
            ->setLine($line)
            ->setCode($code)
            ->setMessage($message)
            ->setTracing($this->createTracing($tracing));

        $target = $this->getTarget();

        if ($target instanceof FSOFileInterface) {
            $this->getView()->save($target);

            $mock = $this->createMockView()->toString();
            $this->giGetResponseFactory()->createStatus500($mock)->dispatch();
        } else {
            echo $this->getView()->toString();
        }

        $this->getEventManager()->fireAfter([$file, $line, $code, $message]);

        die();
    }

    /**
     * @param \Throwable $throwable
     * @throws \Exception
     */
    public function handleThrowable(\Throwable $throwable)
    {
        $this->getView()->setThrowableClass(get_class($throwable));

        if ($throwable instanceof GIException) {
            $this->getView()
                ->setExceptionType(true)
                ->setTitle(static::GI_EXCEPTION_TITLE)
                ->setExceptionCaller($throwable->getCallerClass());
        } elseif ($throwable instanceof \Exception) {
            $this->getView()->setExceptionType(true)->setTitle(static::PHP_EXCEPTION_TITLE);
        } elseif ($throwable instanceof \Error) {
            $this->getView()->setExceptionType(false)->setTitle(static::THROWABLE_ERROR_TITLE);
        }else {
            $this->getView()->setExceptionType(false)->setTitle(static::THROWABLE_TITLE);
        }

        $this->report(
            $throwable->getFile(),
            $throwable->getLine(),
            $throwable->getCode(),
            $throwable->getMessage(),
            $throwable->getTrace()
        );
    }

    /**
     * @param int $errorNumber
     * @param string $errorMessage
     * @param string $errorFile
     * @param int $errorLine
     * @throws \Exception
     */
    public function handleError(int $errorNumber, string $errorMessage, string $errorFile, int $errorLine)
    {
        $this->getView()->setExceptionType(false)->setTitle(static::ERROR_TITLE);

        $this->report($errorFile, $errorLine, $errorNumber, $errorMessage);
    }
}