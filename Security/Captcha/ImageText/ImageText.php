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
namespace GI\Security\Captcha\ImageText;

use GI\Security\Captcha\Base\AbstractCaptcha;
use GI\Security\Captcha\ImageText\Graphic\Graphic;

use GI\Util\Crypt\Random\Word\WordInterface as RandomWordInterface;
use GI\Security\Captcha\ImageText\Graphic\GraphicInterface;
use GI\Security\Captcha\ImageText\Context\ContextInterface;

class ImageText extends AbstractCaptcha implements ImageTextInterface
{

    const DEFAULT_LENGTH = 8;


    /**
     * @var RandomWordInterface
     */
    private $randomWordGenerator;

    /**
     * @var int
     */
    private $length = 0;

    /**
     * @var GraphicInterface
     */
    private $graphic;


    /**
     * ImageText constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->randomWordGenerator = $this->giCreateRandomWordGenerator();

        $this->randomWordGenerator->getAlphabet()
            ->setAll(false)
            ->setUpperCaseFlag(true)
            ->setDigitsFlag(true);

        try {
            /** @var ContextInterface $context */
            $context      = $this->giGetDi(ContextInterface::class);
            $this->length = $context->getLength();
        } catch (\Exception $e) {
            $this->length = static::DEFAULT_LENGTH;
        }

        $this->graphic = $this->giGetDi(GraphicInterface::class, Graphic::class);
    }

    /**
     * @return RandomWordInterface
     */
    protected function getRandomWordGenerator()
    {
        return $this->randomWordGenerator;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return GraphicInterface
     */
    public function getGraphic()
    {
        return $this->graphic;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function generateValue()
    {
        return $this->getRandomWordGenerator()->create($this->length);
    }

    /**
     * @param string $value
     * @param string $cacheValue
     * @return bool
     */
    protected function validateValue($value, $cacheValue)
    {
        return ($value == $cacheValue);
    }
}