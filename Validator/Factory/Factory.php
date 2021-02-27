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
namespace GI\Validator\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\Validator\Simple\ArrayContents\InArray;
use GI\Validator\Simple\ArrayContents\NotInArray;

use GI\Validator\Simple\Comparison\GreaterThan;
use GI\Validator\Simple\Comparison\GreaterThanOrEqual;
use GI\Validator\Simple\Comparison\LessThan;
use GI\Validator\Simple\Comparison\LessThanOrEqual;

use GI\Validator\Simple\DateTime\Date;
use GI\Validator\Simple\DateTime\DateHourMinute;
use GI\Validator\Simple\DateTime\DateTime;
use GI\Validator\Simple\DateTime\HourMinute;
use GI\Validator\Simple\DateTime\Time;
use GI\Validator\Simple\DateTime\Year;
use GI\Validator\Simple\DateTime\YearMonth;

use GI\Validator\Simple\Email\Email;
use GI\Validator\Simple\Email\EmailsIdentical;

use GI\Validator\Simple\Existence\Existence;
use GI\Validator\Simple\Existence\NotEmpty;

use GI\Validator\Simple\FileContents\FileMimeTypes;
use GI\Validator\Simple\FileContents\MaxFileSize;

use GI\Validator\Simple\Identity\IsIdentical;
use GI\Validator\Simple\Identity\IsNotIdentical;

use GI\Validator\Simple\Password\PasswordLengthMax;
use GI\Validator\Simple\Password\PasswordLengthMin;
use GI\Validator\Simple\Password\PasswordsIdentical;
use GI\Validator\Simple\Password\SpecificPasswordFormat;

use GI\Validator\Simple\Policy\LegalPolicy;

use GI\Validator\Simple\Security\Captcha;

use GI\Validator\Simple\StringValidation\Alpha;
use GI\Validator\Simple\StringValidation\AlphaNumeric;
use GI\Validator\Simple\StringValidation\Digits;
use GI\Validator\Simple\StringValidation\RegExp;
use GI\Validator\Simple\StringValidation\StringLengthMax;
use GI\Validator\Simple\StringValidation\StringLengthMin;
use GI\Validator\Simple\StringValidation\Word;

use GI\Validator\Simple\TypeChecking\IsArray;
use GI\Validator\Simple\TypeChecking\IsFloat;
use GI\Validator\Simple\TypeChecking\IsInt;
use GI\Validator\Simple\TypeChecking\IsNumber;
use GI\Validator\Simple\TypeChecking\IsObject;
use GI\Validator\Simple\TypeChecking\IsScalar;

use GI\Validator\Simple\Web\IP;
use GI\Validator\Simple\Web\URL;

use GI\Validator\Container\Chain\Chain;
use GI\Validator\Container\Recursive\Recursive;
use GI\Validator\Container\Map\Map;


use GI\Validator\ValidatorInterface;

use GI\Security\Captcha\Base\CaptchaInterface as SecureCaptchaInterface;

use GI\Validator\Simple\ArrayContents\InArrayInterface;
use GI\Validator\Simple\ArrayContents\NotInArrayInterface;

use GI\Validator\Simple\Comparison\GreaterThanInterface;
use GI\Validator\Simple\Comparison\GreaterThanOrEqualInterface;
use GI\Validator\Simple\Comparison\LessThanInterface;
use GI\Validator\Simple\Comparison\LessThanOrEqualInterface;

use GI\Validator\Simple\DateTime\DateInterface;
use GI\Validator\Simple\DateTime\DateHourMinuteInterface;
use GI\Validator\Simple\DateTime\DateTimeInterface;
use GI\Validator\Simple\DateTime\HourMinuteInterface;
use GI\Validator\Simple\DateTime\TimeInterface;
use GI\Validator\Simple\DateTime\YearInterface;
use GI\Validator\Simple\DateTime\YearMonthInterface;

use GI\Validator\Simple\Email\EmailInterface;
use GI\Validator\Simple\Email\EmailsIdenticalInterface;

use GI\Validator\Simple\Existence\ExistenceInterface;
use GI\Validator\Simple\Existence\NotEmptyInterface;

use GI\Validator\Simple\FileContents\FileMimeTypesInterface;
use GI\Validator\Simple\FileContents\MaxFileSizeInterface;

use GI\Validator\Simple\Identity\IsIdenticalInterface;
use GI\Validator\Simple\Identity\IsNotIdenticalInterface;

use GI\Validator\Simple\Password\PasswordLengthMaxInterface;
use GI\Validator\Simple\Password\PasswordLengthMinInterface;
use GI\Validator\Simple\Password\PasswordsIdenticalInterface;
use GI\Validator\Simple\Password\SpecificPasswordFormatInterface;

use GI\Validator\Simple\Policy\LegalPolicyInterface;

use GI\Validator\Simple\Security\CaptchaInterface;

use GI\Validator\Simple\StringValidation\AlphaInterface;
use GI\Validator\Simple\StringValidation\AlphaNumericInterface;
use GI\Validator\Simple\StringValidation\DigitsInterface;
use GI\Validator\Simple\StringValidation\RegExpInterface;
use GI\Validator\Simple\StringValidation\StringLengthMaxInterface;
use GI\Validator\Simple\StringValidation\StringLengthMinInterface;
use GI\Validator\Simple\StringValidation\WordInterface;

use GI\Validator\Simple\TypeChecking\IsArrayInterface;
use GI\Validator\Simple\TypeChecking\IsFloatInterface;
use GI\Validator\Simple\TypeChecking\IsIntInterface;
use GI\Validator\Simple\TypeChecking\IsNumberInterface;
use GI\Validator\Simple\TypeChecking\IsObjectInterface;
use GI\Validator\Simple\TypeChecking\IsScalarInterface;

use GI\Validator\Simple\Web\IPInterface;
use GI\Validator\Simple\Web\URLInterface;

use GI\Validator\Container\Chain\ChainInterface;
use GI\Validator\Container\Recursive\RecursiveInterface;
use GI\Validator\Container\Map\MapInterface;

/**
 * Class Factory
 * @package GI\Validator\Factory
 *
 * @method InArrayInterface createInArray(array $array, string $validatedParam = '')
 * @method NotInArrayInterface createNotInArray(array $array, string $validatedParam = '')
 *
 * @method GreaterThanInterface createGreaterThan(int $minimum, string $validatedParam = '')
 * @method GreaterThanOrEqualInterface createGreaterThanOrEqual(int $minimum, string $validatedParam = '')
 * @method LessThanInterface createLessThan(int $maximum, string $validatedParam = '')
 * @method LessThanOrEqualInterface createLessThanOrEqual($maximum, string $validatedParam = '')
 *
 * @method DateInterface createDate(string $validatedParam = '')
 * @method DateHourMinuteInterface createDateHourMinute(string $validatedParam = '')
 * @method DateTimeInterface createDateTime(string $validatedParam = '')
 * @method HourMinuteInterface createHourMinute(string $validatedParam = '')
 * @method TimeInterface createTime(string $validatedParam = '')
 * @method YearInterface createYear(string $validatedParam = '')
 * @method YearMonthInterface createYearMonth(string $validatedParam = '')
 *
 * @method EmailInterface createEmail(string $validatedParam = '')
 * @method EmailsIdenticalInterface createEmailsIdentical(\Closure $email2Finder, string $validatedParam = '')
 *
 * @method ExistenceInterface createExistence(string $validatedParam = '')
 * @method NotEmptyInterface createNotEmpty(string $validatedParam = '')
 *
 * @method FileMimeTypesInterface createFileMimeTypes(array $mimeTypes, string $validatedParam = '')
 * @method MaxFileSizeInterface createMaxFileSize(int $maxFileSize, string $validatedParam = '')
 *
 * @method IsIdenticalInterface createIsIdentical($token, string $validatedParam = '')
 * @method IsNotIdenticalInterface createIsNotIdentical($token, string $validatedParam = '')
 *
 * @method PasswordLengthMaxInterface createPasswordLengthMax(int $maximum, string $validatedParam = '')
 * @method PasswordLengthMinInterface createPasswordLengthMin(int $minimum, string $validatedParam = '')
 * @method PasswordsIdenticalInterface createPasswordsIdentical(\Closure $password2Finder, string $validatedParam = '')
 * @method SpecificPasswordFormatInterface createSpecificPasswordFormat(string $validatedParam = '')
 *
 * @method LegalPolicyInterface createLegalPolicy(string $validatedParam = '')
 *
 * @method CaptchaInterface createCaptcha(\Closure $idFinder, SecureCaptchaInterface $secureCaptcha, string $validatedParam = '')
 *
 * @method AlphaInterface createAlpha(string $validatedParam = '')
 * @method AlphaNumericInterface createAlphaNumeric(string $validatedParam = '')
 * @method DigitsInterface createDigits(string $validatedParam = '')
 * @method RegExpInterface createRegExp(string $regExp = '', string $validatedParam = '')
 * @method StringLengthMaxInterface createStringLengthMax(int $maximum, string $validatedParam = '')
 * @method StringLengthMinInterface createStringLengthMin(int $minimum, string $validatedParam = '')
 * @method WordInterface createWord(string $validatedParam = '')
 *
 * @method IsArrayInterface createIsArray(string $validatedParam = '')
 * @method IsFloatInterface createIsFloat(string $validatedParam = '')
 * @method IsIntInterface createIsInt(string $validatedParam = '')
 * @method IsNumberInterface createIsNumber(string $validatedParam = '')
 * @method IsObjectInterface createIsObject(string $validatedParam = '')
 * @method IsScalarInterface createIsScalar(string $validatedParam = '')
 *
 * @method IPInterface createIP(int $flags, string $validatedParam = '')
 * @method URLInterface createURL(int $flags, string $validatedParam = '')
 *
 * @method ChainInterface createChain(array $contents = [], string $validatedParam = '')
 * @method RecursiveInterface createRecursive(array $contents = [])
 * @method MapInterface createMap(ValidatorInterface $validator)
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(ValidatorInterface::class);

        $this->set(InArray::class)
            ->set(NotInArray::class)

            ->set(GreaterThan::class)
            ->set(GreaterThanOrEqual::class)
            ->set(LessThan::class)
            ->set(LessThanOrEqual::class)

            ->set(Date::class)
            ->set(DateHourMinute::class)
            ->set(DateTime::class)
            ->set(HourMinute::class)
            ->set(Time::class)
            ->set(Year::class)
            ->set(YearMonth::class)

            ->set(Email::class)
            ->set(EmailsIdentical::class)

            ->set(Existence::class)
            ->set(NotEmpty::class)

            ->set(FileMimeTypes::class)
            ->set(MaxFileSize::class)

            ->set(IsIdentical::class)
            ->set(IsNotIdentical::class)

            ->set(PasswordLengthMax::class)
            ->set(PasswordLengthMin::class)
            ->set(PasswordsIdentical::class)
            ->set(SpecificPasswordFormat::class)

            ->set(LegalPolicy::class)

            ->set(Captcha::class)

            ->set(Alpha::class)
            ->set(AlphaNumeric::class)
            ->set(Digits::class)
            ->set(RegExp::class)
            ->set(StringLengthMax::class)
            ->set(StringLengthMin::class)
            ->set(Word::class)

            ->set(IsArray::class)
            ->set(IsFloat::class)
            ->set(IsInt::class)
            ->set(IsNumber::class)
            ->set(IsObject::class)
            ->set(IsScalar::class)

            ->set(IP::class)
            ->set(URL::class)

            ->set(Chain::class)
            ->set(Recursive::class)
            ->set(Map::class);
    }
}