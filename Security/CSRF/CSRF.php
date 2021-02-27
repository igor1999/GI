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
namespace GI\Security\CSRF;

use GI\Security\CSRF\Cache\Cache;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Security\CSRF\Cache\CacheInterface;
use GI\Security\CSRF\Context\ContextInterface;

class CSRF implements CSRFInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_EXPIRATION_TIME = 900;


    /**
     * @var CacheInterface
     */
    private static $sessionCache;

    /**
     * @var string
     */
    private $token = '';

    /**
     * @var \DateTime
     */
    private $expires;

    /**
     * @var int
     */
    private $expirationTime = 0;


    /**
     * CSRFToken constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);
            $this->setExpirationTime($context->getExpirationTime());
        } catch (\Exception $e) {
            $this->setExpirationTime(static::DEFAULT_EXPIRATION_TIME);
        }
    }

    /**
     * @return string
     */
    public static function getSessionCacheClass()
    {
        return Cache::class;
    }

    /**
     * @return CacheInterface
     */
    protected function getSessionCache()
    {
        return self::$sessionCache;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return \DateTime
     */
    public function getExpires()
    {
        return clone $this->expires;
    }

    /**
     * @return int
     */
    public function getExpirationTime()
    {
        return $this->expirationTime;
    }

    /**
     * @param int $expirationTime
     * @return static
     * @throws \Exception
     */
    protected function setExpirationTime(int $expirationTime)
    {
        if ($expirationTime <= 0) {
            $this->giThrowInvalidMinimumException('Token expiration time', $expirationTime, '1');
        }

        $this->expirationTime = $expirationTime;

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function generate()
    {
        $this->generateId()->generateExpires();

        $this->getSessionCache()->add($this->token, $this->expires->getTimestamp());

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function generateId()
    {
        $this->token = $this->giGetRandomHashGenerator()->create();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function generateExpires()
    {
        $this->expires = new \DateTime();

        $interval = new \DateInterval('PT' . $this->expirationTime . 'S');
        $this->expires->add($interval);

        return $this;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function validate(string $id)
    {
        try {
            $currentTime = new \DateTime();
            $result = ($currentTime->getTimestamp()) <= $this->getSessionCache()->get($id)->getExpires();
        } catch (\Exception $exception) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function remove(string $id)
    {
        return $this->getSessionCache()->remove($id);
    }
}