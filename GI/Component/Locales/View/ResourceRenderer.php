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
namespace GI\Component\Locales\View;

use GI\Component\Menu\View\ResourceRenderer as Base;
use GI\Storage\Collection\StringCollection\HashSet\Alterable\Alterable as LocaleImages;

use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\Storage\Collection\StringCollection\HashSet\Alterable\AlterableInterface as LocaleImagesInterface;

class ResourceRenderer extends Base implements ResourceRendererInterface
{
    const URL_BASE_DIR = 'GI/Component/Locales';


    const CSS_PATHS = [
        'css/locales.css',
    ];

    const JS_PATHS = [
        'js/locales.js',
        'js/factory.js',
    ];


    /**
     * @var LocaleImagesInterface
     */
    private $localeImages;


    /**
     * ResourceRenderer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->createClassContents(self::class);

        $this->localeImages = $this->giGetDi(LocaleImagesInterface::class, LocaleImages::class);

        $this->createLocaleImages();
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createLocaleImages()
    {
        $this->getLocaleImages()->clean();

        foreach ($this->getImageDirs() as $dirs) {
            /** @var FSODirInterface $sourceDir */
            list($sourceDir, $targetDir) = $dirs;

            /** @var FSOFileInterface $image */
            foreach ($sourceDir->getChildren()->getItems() as $image) {
                $locale = $image->getFilename();
                $url    = $targetDir . '/' . $image->getBasename();
                $url    = $image->createURLHolder($url)->create()->getUrlWithModificationTime();

                $this->getLocaleImages()->set($locale, $url);
            }
        }

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getImageDirs()
    {
        return [
            [
                $this->giCreateClassDirChildDir(self::class,'web/img'),
                'GI/Component/Locales/img'
            ]
        ];
    }

    /**
     * @return LocaleImagesInterface
     */
    public function getLocaleImages()
    {
        return $this->localeImages;
    }
}