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
namespace GI\I18n\Locales\Main;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\I18n\Locales\Main\Context\ContextInterface;

class Main implements MainInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var array
     */
    private $locales;


    /**
     * Main constructor.
     */
    public function __construct()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->getGiServiceLocator()->getDependency(ContextInterface::class);

            $this->locales = array_merge($this->getDefault(), $context->get());
        } catch (\Exception $e) {
            $this->locales = $this->getDefault();
        }
    }

    /**
     * @return array
     */
    protected function getDefault()
    {
        return [
            'en' => 'en_GB',
            'fr' => 'fr_FR',
            'de' => 'de_DE',
            'es' => 'es_ES',
            'it' => 'it_IT',
            'pt' => 'pt_PT',
            'nl' => 'nl_NL',
            'pl' => 'pl_PL',
            'uk' => 'uk_UA',
            'he' => 'he_IL',
       ];
    }

    /**
     * @return array
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * @param array $locales
     * @return static
     */
    protected function setLocales(array $locales)
    {
        $this->locales = $locales;

        return $this;
    }

    /**
     * @param string $locale
     * @return bool
     */
    public function has(string $locale)
    {
        return isset($this->locales[$this->getLanguage($locale)]);
    }

    /**
     * @param string $locale
     * @return mixed|string
     * @throws \Exception
     */
    public function get(string $locale)
    {
        if (!$this->has($locale)) {
            $this->getGiServiceLocator()->throwNotInScopeException($locale);
        }

        return $this->locales[$this->getLanguage($locale)];
    }

    /**
     * @param string $locale
     * @return string
     */
    public function getLanguage(string $locale)
    {
        return locale_get_primary_language($locale);
    }
}