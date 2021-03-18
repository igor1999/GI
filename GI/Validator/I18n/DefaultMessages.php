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
namespace GI\Validator\I18n;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class DefaultMessages
{
    use ServiceLocatorAwareTrait;


    const ALPHA                    = '\'%validatedParam%\' \'%source%\' includes not alphabet content';

    const ALPHA_NUMERIC            = '\'%validatedParam%\' \'%source%\' includes not alphanumeric content';

    const AUTH                     = 'Either login or password not found';

    const CAPTCHA                  = 'Captcha checkup failed (\'%source%\' given)';

    const CSRF                     = 'CSRF checkup failed';

    const DIGITS                   = '\'%validatedParam%\' \'%source%\' includes not digits content';

    const EMAIL                    = '\'%validatedParam%\' \'%source%\' is not a valid e-mail address';

    const EXISTENCE                = 'parameter \'%validatedParam%\' not found';

    const FILE_MIME_TYPES          = 'MIME-type of file \'%source%\' not in list of types: \'%mimeTypesAsString%\'';

    const GREATER_THAN             = '\'%validatedParam%\' should be greater than \'%minimum%\', \'%source%\' given';

    const GREATER_THAN_OR_EQUAL    = '\'%validatedParam%\' should be greater or equal \'%minimum%\', \'%source%\' given';

    const IP                       = '\'%validatedParam%\' \'%source%\' is not a valid IP';

    const IS_ARRAY                 = '\'%validatedParam%\' is not an array';

    const IS_EMAILS_IDENTICAL      = 'Given e-mails are not identical';

    const IS_FLOAT                 = '\'%validatedParam%\' \'%source%\' is not float';

    const IS_IDENTICAL             = '\'%validatedParam%\' \'%source%\' is not identical with token \'%token%\'';

    const IS_IN_ARRAY              = '\'%validatedParam%\' \'%source%\' is not in array \'%arrayAsString%\'';

    const IS_INT                   = '\'%validatedParam%\' \'%source%\' is not integer';

    const IS_NOT_IDENTICAL         = '\'%validatedParam%\' \'%source%\' is identical with token \'%token%\'';

    const IS_NOT_IN_ARRAY          = '\'%validatedParam%\' \'%source%\' is in array \'%arrayAsString%\'';

    const IS_NUMBER                = '\'%validatedParam%\' \'%source%\' is not a number';

    const IS_OBJECT                = '\'%validatedParam%\' is not an object';

    const IS_PASSWORDS_IDENTICAL   = 'Given passwords are not identical';

    const IS_SCALAR                = '\'%validatedParam%\' is not a scalar';

    const LEGAL_POLICY             = 'Please check and accept legal policy';

    const LESS_THAN                = '\'%validatedParam%\' should be less than \'%maximum%\', \'%source%\' given';

    const LESS_THAN_OR_EQUAL       = '\'%validatedParam%\' should be less or equal \'%maximum%\', \'%source%\' given';

    const MAX_FILE_SIZE            = 'Size of file \'%source%\' is greater than \'%maxFileSize%\'';

    const NOT_EMPTY                = '\'%validatedParam%\' should be set. Empty given';

    const PASSWORD_LENGTH_MAX      = 'Password has length greater than %maximum%';

    const PASSWORD_LENGTH_MIN      = 'Password has length less than %minimum%';

    const REGEXP                   = 'No matches in \'%validatedParam%\' \'%source%\' by \'%regExp%\' found';

    const SPECIFIC_PASSWORD_FORMAT = 'Password should to include at last one letter, one digit and one not alpha-numeric symbol';

    const STRING_LENGTH_MAX        = 'String of \'%validatedParam%\' \'%source%\' has length greater than %maximum%';

    const STRING_LENGTH_MIN        = 'String of \'%validatedParam%\' \'%source%\' has length less than %minimum%';

    const URL                      = '\'%validatedParam%\' \'%source%\' is not a valid URL';

    const WORD                     = '\'%validatedParam%\' \'%source%\' is not a word';
}