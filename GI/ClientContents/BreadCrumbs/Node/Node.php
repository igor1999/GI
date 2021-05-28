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
namespace GI\ClientContents\BreadCrumbs\Node;

use GI\ClientContents\BreadCrumbs\Track\Track;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\ClientContents\NavigationNode\NavigationNodeTrait;

use GI\ClientContents\BreadCrumbs\Track\TrackInterface;

class Node implements NodeInterface
{
    use ServiceLocatorAwareTrait, NavigationNodeTrait;


    /**
     * @var NodeInterface
     */
    private $parent;

    /**
     * @var string
     */
    private $id = '';


    /**
     * Node constructor.
     * @param string $id
     * @param NodeInterface|null $parent
     */
    public function __construct(string $id, NodeInterface $parent = null)
    {
        $this->parent = $parent;
        $this->id     = $id;
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        return $this->parent instanceof NodeInterface;
    }

    /**
     * @return NodeInterface
     * @throws \Exception
     */
    protected function getParent()
    {
        if (!$this->hasParent()) {
            $this->getGiServiceLocator()->throwNotSetException('Parent');
        }

        return $this->parent;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param TrackInterface|null $track
     * @return TrackInterface
     * @throws \Exception
     */
    public function getBreadCrumbs(TrackInterface $track = null)
    {
        if (!($track instanceof TrackInterface)) {
            $track = $this->createBreadCrumbs();
        }

        $track->add($this);

        try {
            $this->getParent()->getBreadCrumbs($track);
        } catch (\Exception $e) {}

        return $track;
    }

    /**
     * @return TrackInterface
     */
    protected function createBreadCrumbs()
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(TrackInterface::class);
        } catch (\Exception $e) {
            $result = new Track();
        }

        return $result;
    }
}