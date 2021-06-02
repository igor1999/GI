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
namespace GI\Application\Call\Web;

use GI\Application\Call\AbstractCall;
use GI\FileSystem\FSO\Symlink\URLHolder\Context\Context as URLHolderContext;
use GI\Application\Mock\AccessDenied\View\View as AccessDeniedView;
use GI\Application\Mock\CSRFFailed\View\View as CSRFFailedView;

use GI\REST\Route\WebInterface;
use GI\Identity\Access\ProfileInterface as AccessProfileInterface;
use GI\Identity\IdentityInterface;
use GI\REST\Request\Factory\FactoryInterface as RequestFactoryInterface;
use GI\REST\Response\ResponseInterface;
use GI\FileSystem\FSO\Symlink\URLHolder\Context\ContextInterface as URLHolderContextInterface;
use GI\I18n\Locales\UserLocaleContextInterface;
use GI\Application\Mock\AccessDenied\View\ViewInterface as AccessDeniedViewInterface;
use GI\Application\Mock\CSRFFailed\View\ViewInterface as CSRFFailedViewInterface;

/**
 * Class Call
 * @package GI\Application\Call\Web
 *
 * @method CallInterface setResponseToDownload(string $file, string $contentType)
 * @method CallInterface setResponseToExcel(string $file)
 * @method CallInterface setResponseToGZIP(string $file)
 * @method CallInterface setResponseToOctetStream(string $file)
 * @method CallInterface setResponseToPDF(string $file)
 * @method CallInterface setResponseToWord(string $file)
 * @method CallInterface setResponseToZIP(string $file)
 * @method CallInterface setResponseToGIF($resource)
 * @method CallInterface setResponseToJPEG($resource)
 * @method CallInterface setResponseToPNG($resource)
 * @method CallInterface setResponseToJSON($data)
 * @method CallInterface setResponseToLocation(string $url)
 * @method CallInterface setResponseToRefresh(int $time, string $url)
 * @method CallInterface setResponseToStatus200(string $output = '', string $protocol = '')
 * @method CallInterface setResponseToStatus403(string $output = '', string $protocol = '')
 * @method CallInterface setResponseToStatus404(string $output = '', string $protocol = '')
 * @method CallInterface setResponseToStatus500(string $output = '', string $protocol = '')
 * @method CallInterface setResponseToHTML(string $text)
 * @method CallInterface setResponseToXML(string $text)
 * @method CallInterface setResponseToSimple($output)
 */
class Call extends AbstractCall implements CallInterface
{
    /**
     * @var IdentityInterface
     */
    private $identity;

    /**
     * @var AccessProfileInterface
     */
    private $accessProfile;

    /**
     * @var ResponseInterface
     */
    private $response;


    /**
     * Call constructor.
     * @param WebInterface $route
     * @param \Closure $handler
     * @param AccessProfileInterface|null $accessProfile
     * @throws \Exception
     */
    public function __construct(WebInterface $route, \Closure $handler, AccessProfileInterface $accessProfile = null)
    {
        parent::__construct($route, $handler);

        $this->accessProfile = $accessProfile;
    }

    /**
     * @return RequestFactoryInterface
     */
    public function getRequest()
    {
        return parent::getRequest();
    }

    /**
     * @return AccessProfileInterface
     */
    protected function getAccessProfile()
    {
        return $this->accessProfile;
    }

    /**
     * @return IdentityInterface
     */
    public function getIdentity()
    {
        if (!($this->identity instanceof IdentityInterface)) {
            try {
                $this->identity = $this->getGiServiceLocator()->getDependency(IdentityInterface::class);
            } catch (\Exception $e) {}
        }

        return $this->identity;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     * @return static
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return static
     * @throws \Exception
     */
    public function __call(string $method, array $arguments)
    {
        /** @var ResponseInterface $response */
        $response = $this->getGiServiceLocator()->getResponseFactory()
            ->create($method, $arguments, self::SET_RESPONSE_METHOD_PREFIX);

        $this->setResponse($response);

        return $this;
    }

    /**
     * @return AccessDeniedViewInterface
     */
    protected function createAccessDeniedView()
    {
        return new AccessDeniedView();
    }

    /**
     * @return static
     */
    public function setResponseToAccessDenied()
    {
        $this->setResponseToStatus403($this->createAccessDeniedView());

        return $this;
    }

    /**
     * @return CSRFFailedViewInterface
     */
    protected function createCSRFFailedView()
    {
        return new CSRFFailedView();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function handle()
    {
        $this->validateClosing();

        $result = $this->getRoute()->validateByServer($this->getRequest()->getServer());

        if ($result) {
            $this->close();
            $this->saveCallAndModuleContents();
            $this->getGiServiceLocator()->loadSession();
            $this->saveUserLocale()->createSymlinksDir();
            $this->getGiServiceLocator()->close();

            $identity = $this->getIdentity();
            if ($identity instanceof IdentityInterface) {
                $identity->authenticateByCookie();
            }

            if (!$this->validateCSRFToken()) {
                $this->setResponseToStatus403($this->createCSRFFailedView());
            } elseif (($this->getAccessProfile() instanceof AccessProfileInterface)
                    && !$this->getAccessProfile()->validate()) {
                $this->setResponseToAccessDenied();
            }else {
                $this->getHandlers()->executeSequentially([$this]);
            }

            if ($this->getResponse() instanceof ResponseInterface) {
                $this->getResponse()->dispatch();
            }

            $this->getGiServiceLocator()->saveSession();
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function saveUserLocale()
    {
        try {
            /** @var UserLocaleContextInterface $context */
            $context = $this->getGiServiceLocator()->getDependency(UserLocaleContextInterface::class);

            $cookie = $context->getCookieName();
            $locale = $this->findLocale($context);

            if (!$this->getRequest()->getCookie()->has($cookie)) {
                setcookie($cookie, $locale,time() + $context->getCookieExpires());
            }

            setlocale(LC_ALL, $locale);

            $this->getGiServiceLocator()->setUserLocale($locale);
        } catch (\Exception $e) {}

        return $this;
    }

    /**
     * @param UserLocaleContextInterface $context
     * @return string
     * @throws \Exception
     */
    protected function findLocale(UserLocaleContextInterface $context)
    {
        try {
            $locale = $this->getRequest()->getCookie()->get($context->getCookieName());
        } catch (\Exception $e) {
            $locale = null;
        }

        if (!in_array($locale, $context->getUsedLocales())) {
            $locale = $this->getRequest()->getHeaders()->getLocale($context->getUsedLocales());
        }

        if (empty($locale))
        {
            $locale = $context->getDefaultLocale();
        }

        if (!in_array($locale, $context->getUsedLocales())) {
            $locale = '';
        }

        return $locale;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createSymlinksDir()
    {
        /** @var URLHolderContextInterface $context */
        $context = $this->getGiServiceLocator()
            ->getDependency(URLHolderContextInterface::class, URLHolderContext::class);

        $context->getWebRoot()->create();

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function validateCSRFToken()
    {
        if ($this->getRequest()->getServer()->isRequestMethodForChange() && $this->validateCSRFIsOn()) {
            try {
                $token  = $this->getRequest()->getHeaders()->getCSRFToken();
                $result = $this->getGiServiceLocator()->createSecureCSRF()->validate($token);
            } catch (\Exception $exception) {
                try {
                    $token  = $this->getRequest()->getPost()->getCSRFToken();
                    $result = $this->getGiServiceLocator()->createSecureCSRF()->validate($token);
                } catch (\Exception $exception) {
                    $result = false;
                }
            }
        } else {
            $result = true;
        }

        return $result;
    }

    /**
     * @return bool
     */
    protected function validateCSRFIsOn()
    {
        return true;
    }
}