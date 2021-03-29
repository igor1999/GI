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
namespace GI\Security\Captcha\Base;

use GI\Security\Captcha\Cache\Cache;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Security\Captcha\Cache\CacheInterface;
use GI\Security\Captcha\Base\Graphic\GraphicAwareInterface;
use GI\Security\Captcha\Base\Context\ContextInterface;

abstract class AbstractCaptcha implements CaptchaInterface
{
    use ServiceLocatorAwareTrait;


    const DEFAULT_EXPIRATION_TIME = 300;


    /**
     * @var CacheInterface
     */
    private static $sessionCache;

    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $value = '';

    /**
     * @var \DateTime
     */
    private $expires;

    /**
     * @var int
     */
    private $expirationTime = 0;


    /**
     * AbstractCaptcha constructor.
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
    public static function getDefaultSessionCacheClass()
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
            $this->giThrowInvalidMinimumException('Captcha expiration time', $expirationTime, 1);
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
        $this->value = $this->generateId()->generateExpires()->generateValue();

        $this->getSessionCache()->add($this->id, $this->value, $this->expires->getTimestamp());

        if ($this instanceof GraphicAwareInterface) {
            $this->getGraphic()->setValue($this->value);
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function generateId()
    {
        $this->id = $this->giGetRandomHashGenerator()->create();

        return $this;
    }

    /**
     * @return mixed
     */
    abstract protected function generateValue();

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
     * @param mixed $value
     * @return bool
     */
    public function validate(string $id, $value)
    {
        try {
            $item = $this->getSessionCache()->get($id);
            $date = new \DateTime();

            $expiresValid = ($date->getTimestamp() <= $item->getExpires());
            $valueValid   = $this->validateValue($value, $item->getValue());
            $result       = $expiresValid && $valueValid;
        } catch (\Exception $exception) {
            $result = false;
        }

        $this->remove($id);

        return $result;
    }

    /**
     * @param mixed $value
     * @param mixed $cacheValue
     * @return bool
     */
    abstract protected function validateValue($value, $cacheValue);

    /**
     * @param string $id
     * @return bool
     */
    public function remove(string $id)
    {
        return $this->getSessionCache()->remove($id);
    }
}