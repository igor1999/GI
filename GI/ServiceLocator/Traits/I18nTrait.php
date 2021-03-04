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
namespace GI\ServiceLocator\Traits;

use GI\I18n\Translator\Translator;
use GI\I18n\Locales\Sounding\Sounding;

use GI\I18n\Translator\Glossary\GlossaryInterface as TranslatorGlossaryInterface;
use GI\I18n\Translator\TranslatorInterface;
use GI\I18n\Locales\Sounding\SoundingInterface;
use GI\ServiceLocator\ServiceLocatorInterface;

trait I18nTrait
{
    /**
     * @var string
     */
    private $userLocale = self::DEFAULT_USER_LOCALE;

    /**
     * @var TranslatorGlossaryInterface[]
     */
    private $glossaryCache = [];

    /**
     * @var TranslatorInterface
     */
    private $defaultTranslator;


    /**
     * @param string|null $caller
     * @return SoundingInterface
     */
    public function createSounding(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(SoundingInterface::class, $caller);
        } catch (\Exception $e) {
            $result = new Sounding();
        }

        return $result;
    }

    /**
     * @param string $interface
     * @param mixed $default
     * @return TranslatorGlossaryInterface
     * @throws \Exception
     */
    protected function getGlossary(string $interface, $default)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        if (!isset($this->glossaryCache[$interface])) {
            $this->glossaryCache[$interface] = $me->getDi()->find($interface, null, $default);
        }

        return $this->glossaryCache[$interface];
    }

    /**
     * @return TranslatorInterface
     */
    protected function getDefaultTranslator()
    {
        if (!($this->defaultTranslator instanceof TranslatorInterface)) {
            $this->defaultTranslator = $this->createTranslator();
        }

        return $this->defaultTranslator;
    }

    /**
     * @return Translator
     */
    protected function createTranslator()
    {
        return new Translator();
    }

    /**
     * @param string $interface
     * @param mixed $default
     * @param string $text
     * @return string
     */
    public function translate(string $interface, $default, string $text)
    {
        try {
            $result = $this->getDefaultTranslator()
                ->setGlossary($this->getGlossary($interface, $default))
                ->translate($text);
        } catch (\Exception $e) {
            $result = $text;
        }

        return $result;
    }

    /**
     * @param string $interface
     * @param mixed $default
     * @return TranslatorInterface
     * @throws \Exception
     */
    public function createDefaultTranslator(string $interface, $default)
    {
        return $this->createTranslator()->setGlossary($this->getGlossary($interface, $default));
    }

    /**
     * @return string
     */
    public function getUserLocale()
    {
        return $this->userLocale;
    }

    /**
     * @param string $userLocale
     * @return static
     */
    public function setUserLocale(string $userLocale)
    {
        $this->validateClosing();

        $this->userLocale = $userLocale;

        return $this;
    }
}