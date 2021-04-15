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
namespace GI\Component\Base\Gate;

use GI\Identity\Exception\Access as AccessException;

use GI\Component\Base\Gate\Errors\Errors;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Application\Call\Web\CallInterface as WebCallInterface;
use GI\Component\Base\Gate\Errors\ErrorsInterface;

abstract class AbstractGate implements GateInterface
{
    use ServiceLocatorAwareTrait;


    const ACCESS_DENIED_MESSAGE = 'User has no privileges to this action';


    /**
     * @var WebCallInterface
     */
    private $call;

    /**
     * @var ErrorsInterface
     */
    private $commonErrors;

    /**
     * @var ErrorsInterface
     */
    private $ajaxErrors;


    /**
     * AbstractGate constructor.
     * @param WebCallInterface $call
     * @throws \Exception
     */
    public function __construct(WebCallInterface $call)
    {
        $this->call = $call;

        $this->commonErrors = $this->giGetDi(ErrorsInterface::class, Errors::class);
        $this->ajaxErrors   = $this->giGetDi(ErrorsInterface::class, Errors::class);

        $body     = $this->giGetComponentFactory()->getErrorFactory()->createAccessDenied(
            static::ACCESS_DENIED_MESSAGE
        );
        $response = $this->giGetResponseFactory()->createStatus403($body);
        $this->commonErrors->create(AccessException::class, $response);

        $response = $this->giGetResponseFactory()->createStatus403(static::ACCESS_DENIED_MESSAGE);
        $this->ajaxErrors->create(AccessException::class, $response);
    }

    /**
     * @return WebCallInterface
     */
    protected function getCall()
    {
        return $this->call;
    }

    /**
     * @return ErrorsInterface
     */
    protected function getCommonErrors()
    {
        return $this->commonErrors;
    }

    /**
     * @return ErrorsInterface
     */
    protected function getAjaxErrors()
    {
        return $this->ajaxErrors;
    }

    /**
     * @param \Throwable $throwable
     * @return static
     * @throws \Throwable
     */
    protected function handleError(\Throwable $throwable)
    {
        try {
            if ($this->giGetRequest()->getHeaders()->isAjaxRequest()) {
                $response = $this->getAjaxErrors()->findByThrowable($throwable);
            } else {
                $response = $this->getCommonErrors()->findByThrowable($throwable);
            }

            $this->getCall()->setResponse($response);
        } catch (\Exception $exception) {
            throw $throwable;
        }

        return $this;
    }
}