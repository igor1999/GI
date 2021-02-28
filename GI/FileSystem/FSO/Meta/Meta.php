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
namespace GI\FileSystem\FSO\Meta;

use GI\FileSystem\ContentTypes;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\FSO\FSOInterface;
use GI\FileSystem\FSO\Symlink\SymlinkInterface;

class Meta implements MetaInterface
{
    /**
     * @var FSOInterface
     */
    private $fso;


    /**
     * Meta constructor.
     * @param FSOInterface $fso
     */
    public function __construct(FSOInterface $fso)
    {
        $this->fso = $fso;
    }

    /**
     * @return FSOInterface
     */
    public function getFso()
    {
        return $this->fso;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMimeType()
    {
        $this->getFso()->fireInexistence();

        return mime_content_type($this->getFso()->getPath());
    }

    /**
     * @return array|false|string[]
     * @throws \Exception
     */
    public function getMimeTypeContents()
    {
        return explode(ContentTypes::SEPARATOR, $this->getMimeType());
    }

    /**
     * @return array
     */
    protected function getFileInfoFlags()
    {
        $flags = [
            FILEINFO_NONE,
            FILEINFO_SYMLINK,
            FILEINFO_MIME_TYPE,
            FILEINFO_MIME_ENCODING,
            FILEINFO_MIME,
            FILEINFO_DEVICES,
            FILEINFO_CONTINUE,
            FILEINFO_PRESERVE_ATIME,
            FILEINFO_RAW,
        ];

        if (defined('FILEINFO_EXTENSION')) {
            $flags[] = constant('FILEINFO_EXTENSION');
        }

        return $flags;
    }

    /**
     * @param int $flag
     * @param FSOFileInterface|null $magicFile
     * @return string
     * @throws \Exception
     */
    public function getFileInfo(int $flag, FSOFileInterface $magicFile = null)
    {
        $this->getFso()->fireInexistence();

        if (!in_array($flag, $this->getFileInfoFlags())) {
            trigger_error('Flag not found: ' . $flag, E_USER_ERROR);
        }

        if ($magicFile instanceof FSOFileInterface) {
            $magicFile->fireInexistence();
        }

        $info = new \finfo($flag, $magicFile);

        return $info->file($this->getFso()->getPath());
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getSize()
    {
        $this->getFso()->fireInexistence();

        return filesize($this->getFso()->getPath());
    }

    /**
     * @return false|int
     * @throws \Exception
     */
    public function getModificationTime()
    {
        $this->getFso()->fireInexistence();

        return filemtime($this->getFso()->getPath());
    }

    /**
     * @return array|false
     * @throws \Exception
     */
    public function getStat()
    {
        $this->getFso()->fireInexistence();

        return ($this->getFso() instanceof SymlinkInterface)
            ? lstat($this->getFso()->getPath())
            : stat($this->getFso()->getPath());
    }
}