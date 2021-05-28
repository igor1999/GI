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
namespace GI\Component\Base\View\ResourceRenderer\Resource;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\DOM\HTML\Element\HTMLInterface;
use GI\FileSystem\FSO\Symlink\URLHolder\URLHolderInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;

abstract class AbstractResource implements ResourceInterface
{
    use ServiceLocatorAwareTrait;


    const COMMENT_TEMPLATE = 'resource %s already exists';


    /**
     * @var array
     */
    private static $cache = [];

    /**
     * @var URLHolderInterface
     */
    private $urlHolder;

    /**
     * @var bool
     */
    private $commentAsReplacement = true;


    /**
     * AbstractResource constructor.
     * @param FSOFileInterface $target
     * @param string $relativeURL
     */
    public function __construct(FSOFileInterface $target, string $relativeURL)
    {
        $this->urlHolder = $this->getGiServiceLocator()->getFileSystemFactory()->createURLHolder($target, $relativeURL);
    }

    /**
     * @return URLHolderInterface
     */
    protected function getUrlHolder()
    {
        return $this->urlHolder;
    }

    /**
     * @return HTMLInterface
     */
    abstract protected function createElement();

    /**
     * @return bool
     */
    public function isCommentAsReplacement()
    {
        return $this->commentAsReplacement;
    }

    /**
     * @param bool $commentAsReplacement
     * @return static
     */
    public function setCommentAsReplacement(bool $commentAsReplacement)
    {
        $this->commentAsReplacement = $commentAsReplacement;

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $url = $this->getUrlHolder()->create()->getUrl();

        if (isset(self::$cache[$url])) {
            if ($this->commentAsReplacement) {
                $comment = sprintf(static::COMMENT_TEMPLATE, $url);
                $result  = $this->getGiServiceLocator()->getDOMFactory()->createComment($comment)->toString();
            } else {
                $result = '';
            }
        } else {
            self::$cache[$url] = true;

            $result = $this->createElement()->toString();
        }

        return $result;
    }
}