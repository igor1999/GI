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
namespace GI\I18n\Locales\Sounding;

use GI\I18n\Locales\Sounding\Glossary\Glossary;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\I18n\Translator\TranslatorInterface;
use GI\I18n\Locales\UserLocaleContextInterface;
use GI\I18n\Locales\Sounding\Glossary\GlossaryInterface;

class Sounding implements SoundingInterface
{
    use ServiceLocatorAwareTrait;


    const DUMMY_SOURCE_LOCALE = 'xx_XX';


    /**
     * @var array
     */
    private $usedLocales = [];

    /**
     * @var TranslatorInterface
     */
    private $translator;


    /**
     * Sounding constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setUsedLocalesToDefault();

        $this->translator = $this->giCreateDefaultTranslator(GlossaryInterface::class, Glossary::class);

        $this->translator->setSourceLocale(static::DUMMY_SOURCE_LOCALE);
    }

    /**
     * @return array
     */
    public function getUsedLocales()
    {
        return $this->usedLocales;
    }

    /**
     * @param array $usedLocales
     * @return static
     */
    public function setUsedLocales(array $usedLocales)
    {
        $this->usedLocales = $usedLocales;

        return $this;
    }

    /**
     * @return static
     */
    public function setUsedLocalesToDefault()
    {
        try {
            /** @var UserLocaleContextInterface $context */
            $context = $this->giGetDi(UserLocaleContextInterface::class);
            $this->setUsedLocales($context->getUsedLocales());
        } catch (\Exception $e) {
            $this->setUsedLocales([]);
        }

        return $this;
    }

    /**
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @return string
     */
    public function getTargetLocaleSounding()
    {
        return $this->getTranslator()->translate($this->getTranslator()->getTargetLocale());
    }

    /**
     * @return array
     */
    public function getUsedLocalesSoundingList()
    {
        $list = [];

        foreach ($this->usedLocales as $usedLocale) {
            $sounding = $this->getTranslator()->translate($usedLocale);
            if ($this->getTranslator()->isFound()) {
                $list[$usedLocale] = $sounding;
            }
        }

        return $list;
    }
}