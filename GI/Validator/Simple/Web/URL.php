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
namespace GI\Validator\Simple\Web;

use GI\Validator\Simple\Base\AbstractSimple;
use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\Validator\I18n\Glossary\GlossaryInterface;

class URL extends AbstractSimple implements URLInterface
{
    /**
     * @var int
     */
    private $flags;


    /**
     * URL constructor.
     * @param int $flags
     * @param string $validatedParam
     */
    public function __construct(int $flags, string $validatedParam = '')
    {
        parent::__construct($validatedParam);

        $this->flags = $flags;
    }

    /**
     * @return int
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @param int $flags
     * @return static
     */
    public function setFlags(int $flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        $options = [
            'options' => [],
            'flags'   => (int)$this->flags,
        ];

        return (bool)filter_var($this->getSource(), FILTER_VALIDATE_URL, $options);
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->giTranslate(GlossaryInterface::class, Glossary::class,DefaultMessages::URL);
    }
}