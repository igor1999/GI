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
namespace GI\DOM\HTML\Element\Input\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\DOM\HTML\Element\Input\Button\Button;
use GI\DOM\HTML\Element\Input\Button\Reset;
use GI\DOM\HTML\Element\Input\Button\Submit;

use GI\DOM\HTML\Element\Input\DateTime\DateInput;
use GI\DOM\HTML\Element\Input\DateTime\DateTimeLocal;
use GI\DOM\HTML\Element\Input\DateTime\Month;
use GI\DOM\HTML\Element\Input\DateTime\Time;
use GI\DOM\HTML\Element\Input\DateTime\Week;

use GI\DOM\HTML\Element\Input\File\File;

use GI\DOM\HTML\Element\Input\Hidden\Hidden;
use GI\DOM\HTML\Element\Input\Hidden\CSRF;

use GI\DOM\HTML\Element\Input\Image\Image;

use GI\DOM\HTML\Element\Input\Logical\Checkbox;
use GI\DOM\HTML\Element\Input\Logical\Radio;
use GI\DOM\HTML\Element\Input\Logical\Set\Checkbox as CheckboxSet;
use GI\DOM\HTML\Element\Input\Logical\Set\Radio as RadioSet;
use GI\DOM\HTML\Element\Input\Logical\Set\Advanced\Gender;
use GI\DOM\HTML\Element\Input\Logical\Set\Advanced\Salutation;
use GI\DOM\HTML\Element\Input\Logical\Set\Advanced\YesNo;
use GI\DOM\HTML\Element\Input\Logical\Set\Advanced\OnOff;

use GI\DOM\HTML\Element\Input\Misc\Color;
use GI\DOM\HTML\Element\Input\Misc\Search;
use GI\DOM\HTML\Element\Input\Misc\Tel;

use GI\DOM\HTML\Element\Input\Number\Number;
use GI\DOM\HTML\Element\Input\Number\Range;

use GI\DOM\HTML\Element\Input\Text\Password;
use GI\DOM\HTML\Element\Input\Text\Text;

use GI\DOM\HTML\Element\Input\Web\Email;
use GI\DOM\HTML\Element\Input\Web\URL;


use GI\DOM\HTML\Element\Input\InputInterface;
use GI\DOM\HTML\Element\Input\Logical\Set\SetInterface;

use GI\DOM\HTML\Element\Input\Button\ButtonInterface;
use GI\DOM\HTML\Element\Input\Button\ResetInterface;
use GI\DOM\HTML\Element\Input\Button\SubmitInterface;

use GI\DOM\HTML\Element\Input\DateTime\DateInputInterface;
use GI\DOM\HTML\Element\Input\DateTime\DateTimeLocalInterface;
use GI\DOM\HTML\Element\Input\DateTime\MonthInterface;
use GI\DOM\HTML\Element\Input\DateTime\TimeInputInterface;
use GI\DOM\HTML\Element\Input\DateTime\WeekInterface;

use GI\DOM\HTML\Element\Input\File\FileInterface;

use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\DOM\HTML\Element\Input\Hidden\CSRFInterface;

use GI\DOM\HTML\Element\Input\Image\ImageInterface;

use GI\DOM\HTML\Element\Input\Logical\CheckboxInterface;
use GI\DOM\HTML\Element\Input\Logical\RadioInterface;
use GI\DOM\HTML\Element\Input\Logical\Set\CheckboxInterface as CheckboxSetInterface;
use GI\DOM\HTML\Element\Input\Logical\Set\RadioInterface as RadioSetInterface;
use GI\DOM\HTML\Element\Input\Logical\Set\Advanced\GenderInterface;
use GI\DOM\HTML\Element\Input\Logical\Set\Advanced\OnOffInterface;
use GI\DOM\HTML\Element\Input\Logical\Set\Advanced\SalutationInterface;
use GI\DOM\HTML\Element\Input\Logical\Set\Advanced\YesNoInterface;

use GI\DOM\HTML\Element\Input\Misc\ColorInterface;
use GI\DOM\HTML\Element\Input\Misc\SearchInterface;
use GI\DOM\HTML\Element\Input\Misc\TelInterface;

use GI\DOM\HTML\Element\Input\Number\NumberInterface;
use GI\DOM\HTML\Element\Input\Number\RangeInterface;

use GI\DOM\HTML\Element\Input\Text\PasswordInterface;
use GI\DOM\HTML\Element\Input\Text\TextInterface;

use GI\DOM\HTML\Element\Input\Web\EmailInterface;
use GI\DOM\HTML\Element\Input\Web\URLInterface;

/**
 * Class Factory
 * @package GI\DOM\HTML\Element\Input\Factory
 *
 * @method ButtonInterface createButton(array $name = [], $value = '')
 * @method ResetInterface createReset(array $name = [], $value = '')
 * @method SubmitInterface createSubmit(array $name = [], $value = '')
 *
 * @method DateInputInterface createDateInput(array $name = [], $value = '')
 * @method DateTimeLocalInterface createDateTimeLocal(array $name = [], $value = '')
 * @method MonthInterface createMonth(array $name = [], $value = '')
 * @method TimeInputInterface createTime(array $name = [], $value = '')
 * @method WeekInterface createWeek(array $name = [], $value = '')
 *
 * @method FileInterface createFile(array $name = [], $value = '')
 *
 * @method HiddenInterface createHidden(array $name = [], $value = '')
 * @method CSRFInterface createCSRF()
 *
 * @method ImageInterface createImage(array $name = [], $value = '')
 *
 * @method CheckboxInterface createCheckbox(array $name = [], $value = '', bool $checked = false)
 * @method RadioInterface createRadio(array $name = [], $value = '', bool $checked = false)
 * @method CheckboxSetInterface createCheckboxSet(array $commonName, array $options = [])
 * @method RadioSetInterface createRadioSet(array $commonName, array $options = [])
 * @method YesNoInterface createYesNoSet(array $commonName)
 * @method OnOffInterface createOnOffSet(array $commonName)
 * @method GenderInterface createGenderSet(array $commonName)
 * @method SalutationInterface createSalutationSet(array $commonName)
 *
 * @method ColorInterface createColor(array $name = [], $value = '')
 * @method SearchInterface createSearch(array $name = [], $value = '')
 * @method TelInterface createTel(array $name = [], $value = '')
 *
 * @method NumberInterface createNumber(array $name = [], $value = '')
 * @method RangeInterface createRange(array $name = [], $value = '')
 *
 * @method PasswordInterface createPassword(array $name = [], $value = '')
 * @method TextInterface createText(array $name = [], $value = '')
 *
 * @method EmailInterface createEmail(array $name = [], $value = '')
 * @method URLInterface createURL(array $name = [], $value = '')
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(InputInterface::class)->add(SetInterface::class);

        $this->set(Button::class)
            ->set(Reset::class)
            ->set(Submit::class)

            ->set(DateInput::class)
            ->set(DateTimeLocal::class)
            ->set(Month::class)
            ->set(Time::class)
            ->set(Week::class)

            ->set(File::class)

            ->set(Hidden::class)
            ->set(CSRF::class)

            ->set(Image::class)

            ->set(Checkbox::class)
            ->set(Radio::class)
            ->setNamed('CheckboxSet', CheckboxSet::class)
            ->setNamed('RadioSet', RadioSet::class)
            ->set(YesNo::class)
            ->set(OnOff::class)
            ->set(Gender::class)
            ->set(Salutation::class)

            ->set(Color::class)
            ->set(Search::class)
            ->set(Tel::class)

            ->set(Number::class)
            ->set(Range::class)

            ->set(Password::class)
            ->set(Text::class)

            ->set(Email::class)
            ->set(URL::class);
    }
}