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
namespace GI\I18n\Translator;

use GI\I18n\Translator\Glossary\Glossary;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\I18n\Translator\Glossary\GlossaryInterface;

class Translator implements TranslatorInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var GlossaryInterface
     */
    private $glossary;

    /**
     * @var string
     */
    private $sourceLocale = '';

    /**
     * @var string
     */
    private $targetLocale = '';

    /**
     * @var bool
     */
    private $withMainLocales = true;

    /**
     * @var bool
     */
    private $found = false;


    /**
     * Translator constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->glossary = $this->giGetDi(GlossaryInterface::class, Glossary::class);

        $this->setSourceLocaleToDefault()->setTargetLocaleToDefault();
    }

    /**
     * @return GlossaryInterface
     */
    public function getGlossary()
    {
        return $this->glossary;
    }

    /**
     * @param GlossaryInterface $glossary
     * @return static
     */
    public function setGlossary(GlossaryInterface $glossary)
    {
        $this->glossary = $glossary;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceLocale()
    {
        return $this->sourceLocale;
    }

    /**
     * @param string $sourceLocale
     * @return static
     */
    public function setSourceLocale(string $sourceLocale)
    {
        $this->sourceLocale = $sourceLocale;

        return $this;
    }

    /**
     * @return static
     */
    public function setSourceLocaleToDefault()
    {
        $this->sourceLocale = self::DEFAULT_SOURCE_LOCALE;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargetLocale()
    {
        return $this->targetLocale;
    }

    /**
     * @param string $targetLocale
     * @return static
     */
    public function setTargetLocale(string $targetLocale)
    {
        $this->targetLocale = $targetLocale;

        return $this;
    }

    /**
     * @return static
     */
    public function setTargetLocaleToDefault()
    {
        $this->targetLocale = $this->giGetServiceLocator()->getUserLocale();

        return $this;
    }

    /**
     * @return bool
     */
    public function isWithMainLocales()
    {
        return $this->withMainLocales;
    }

    /**
     * @param bool $withMainLocales
     * @return static
     */
    public function setWithMainLocales(bool $withMainLocales)
    {
        $this->withMainLocales = $withMainLocales;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFound()
    {
        return $this->found;
    }

    /**
     * @param string $text
     * @return string
     * @throws \Exception
     */
    public function translate(string $text)
    {
        $result = $this->getGlossary()->translate(
            $this->sourceLocale, $this->targetLocale, $text, $this->withMainLocales
        );

        $this->found = ($result !== false);

        if (!$this->found) {
            $result = $text;
        }

        return $result;
    }
}