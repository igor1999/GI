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
namespace GI\REST\Route\Segmented\Behaviour\Constraint;

use GI\Storage\Collection\MixedCollection\HashSet\Closable\Closable;

class Constraints extends Closable implements ConstraintsInterface
{
    /**
     * @param string $param
     * @param string|\Closure $constraint
     * @param int|null $position
     * @return static
     * @throws \Exception
     */
    public function set(string $param, $constraint, int $position = null)
    {
        if (!$this->validateConstraint($constraint)) {
            trigger_error('Constraint should be a Closure or reg exp; ' . $param, E_USER_ERROR);
        }

        parent::set($param, $constraint);

        return $this;
    }

    /**
     * @param string|\Closure $constraint
     * @return bool
     */
    protected function validateConstraint($constraint)
    {
        $reExp   = is_string($constraint) && $this->getGiServiceLocator()->getUtilites()->getSplitter()
                ->isRegExp($constraint);
        $closure = ($constraint instanceof \Closure);

        return $reExp || $closure;
    }

    /**
     * @param ConstraintsInterface $constraints
     * @return static
     * @throws \Exception
     */
    public function import(ConstraintsInterface $constraints)
    {
        $this->merge($constraints);

        return $this;
    }

    /**
     * @param string $param
     * @param string $value
     * @return bool
     */
    public function validate(string $param, string $value)
    {
        try {
            $constraint = $this->get($param);

            $reExp   = is_string($constraint) && preg_match($constraint, $value);
            $closure = ($constraint instanceof \Closure) && call_user_func($constraint, $value);

            $result = $reExp || $closure;
        } catch (\Exception $e) {
            $result = true;
        }

        return $result;
    }
}