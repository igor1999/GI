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
namespace GI\Component\BreadCrumbs\Base;

use GI\Component\Base\AbstractComponent;

use GI\ClientContents\BreadCrumbs\Track\TrackInterface as BreadCrumbsTrackInterface;
use GI\ClientContents\BreadCrumbs\Container\ContainerInterface as BreadCrumbsContainerInterface;

abstract class AbstractBreadCrumbs extends AbstractComponent implements BreadCrumbsInterface
{
    /**
     * @var BreadCrumbsTrackInterface
     */
    private $breadCrumbsTrack;


    /**
     * @return BreadCrumbsTrackInterface
     */
    protected function getBreadCrumbsTrack()
    {
        return $this->breadCrumbsTrack;
    }

    /**
     * @param BreadCrumbsTrackInterface $breadCrumbsTrack
     * @return static
     */
    protected function setBreadCrumbsTrack(BreadCrumbsTrackInterface $breadCrumbsTrack)
    {
        $this->breadCrumbsTrack = $breadCrumbsTrack;

        return $this;
    }

    /**
     * @return BreadCrumbsContainerInterface
     */
    abstract protected function getBreadCrumbsContainer();

    /**
     * @param string $method
     * @param array $arguments
     * @return static
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        if (!method_exists($this->getBreadCrumbsContainer(), $method)) {
            $this->giThrowMagicMethodException($method);
        }

        $this->setBreadCrumbsTrack(call_user_func_array([$this->getBreadCrumbsContainer(), $method], $arguments));

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        return $this->getView()->setBreadCrumbsTrack($this->getBreadCrumbsTrack())->toString();
    }
}