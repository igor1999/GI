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
namespace GI\DOM\XML\Element\Root\Declaration;

use GI\DOM\Base\Element\AbstractAttributedElement;

use GI\DOM\XML\Element\XMLTrait;
use GI\Util\TextProcessing\XML\Version\VersionTrait;

class Declaration extends AbstractAttributedElement implements DeclarationInterface
{
    use XMLTrait, VersionTrait;


    const TAG = 'xml';


    /**
     * Declaration constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct(static::TAG);

        $this->initXMLVersionByContext();
    }

    /**
     * @return string
     */
    protected function getTagTemplate()
    {
        return '<?%s %s ?>';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $attributes = $this->getAttributes();

        $attributes->clean()
            ->set('version', $this->xmlVersion)
            ->set('encoding', $attributes->getEscaper()->getEncoding());

        return parent::toString();
    }
}