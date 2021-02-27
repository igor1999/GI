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
namespace GI\Validator\Simple\FileContents;

use GI\Validator\Simple\Base\AbstractSimple;
use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\Validator\I18n\Glossary\GlossaryInterface;

class FileMimeTypes extends AbstractSimple implements FileMimeTypesInterface
{
    const ARRAY_STRING_SEPARATOR = ',';


    /**
     * @var array
     */
    private $mimeTypes;


    /**
     * FileMimeTypes constructor.
     * @param array $mimeTypes
     * @param string $validatedParam
     */
    public function __construct(array $mimeTypes, string $validatedParam = '')
    {
        parent::__construct($validatedParam);

        $this->mimeTypes = $mimeTypes;
    }

    /**
     * @return array
     */
    public function getMimeTypes()
    {
        return $this->mimeTypes;
    }

    /**
     * @param array $mimeTypes
     * @return static
     */
    public function setMimeTypes(array $mimeTypes)
    {
        $this->mimeTypes = $mimeTypes;

        return $this;
    }

    /**
     * @message
     * @return string
     */
    protected function getMimeTypesAsString()
    {
        return implode(static::ARRAY_STRING_SEPARATOR, $this->mimeTypes);
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $result   = in_array(finfo_file($fileInfo, $this->getSource()), $this->mimeTypes);
        finfo_close($fileInfo);

        return $result;
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->giTranslate(
            GlossaryInterface::class, Glossary::class,DefaultMessages::FILE_MIME_TYPES
        );
    }
}