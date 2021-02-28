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
namespace GI\Security\Captcha\ImageText\Graphic;

use GI\Security\Captcha\Base\Graphic\AbstractGraphic;
use GI\Security\Captcha\ImageText\Graphic\Context\Context;

use GI\Security\Captcha\ImageText\Graphic\Context\ContextInterface;

class Graphic extends AbstractGraphic implements GraphicInterface
{
    /**
     * @var ContextInterface
     */
    private $context;


    /**
     * @return static
     * @throws \Exception
     */
    protected function createContext()
    {
        $this->context = $this->giGetDi(ContextInterface::class, Context::class);

        return $this;
    }

    /**
     * @return ContextInterface
     */
    protected function getContext()
    {
        return $this->context;
    }

    /**
     * @return resource
     * @throws \Exception
     */
    protected function create()
    {
        $letters = str_split($this->getValue());

        $image = $this->getImageContext();

        $color = imagecolorallocatealpha(
            $image,
            $this->getContext()->getRedColor(),
            $this->getContext()->getGreenColor(),
            $this->getContext()->getBlueColor(),
            $this->getContext()->getOpaque()
        );

        $tx = $this->getContext()->getCoordinateX();
        $ty = $this->getContext()->getCoordinateY();

        foreach ($letters as $letter) {
            $angle = rand($this->getContext()->getMinAngle(), $this->getContext()->getMaxAngle());

            imagettftext(
                $image, $this->getContext()->getTtfSize(),
                $angle, $tx, $ty, $color,
                $this->getContext()->getTtfFile()->getPath(), $letter
            );

            $tx += rand($this->getContext()->getMinDeltaX(), $this->getContext()->getMaxDeltaX());
            $ty += rand($this->getContext()->getMinDeltaY(), $this->getContext()->getMaxDeltaY());
        }

        return $image;
    }
}