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
giClient.core.form = new function()
{
    this.extract = function(form)
    {
        let formControls   = form.querySelectorAll('[name]');
        let externControls = document.querySelectorAll(`[form="${form.id}"]`);
        let values         = {};

        fillValues(formControls, values);
        fillValues(externControls, values);

        return values;
    };

    let fillValues = function(controls, values)
    {
        for (let i = 0; i <= controls.length - 1; i ++) {
            let name  = controls[i].name;
            let value = getValue(controls[i]);

            if (value !== null) {
                if (!(name in values)) {
                    values[name] = [];
                }

                values[name].push(value);
            }
        }

        return values;
    };

    let getValue = function(control)
    {
        let value = null;

        if (control.name) {
            let tagName = control.tagName.toUpperCase();
            let type    = control.getAttribute('type');
            if (type) {
                type = type.toUpperCase();
            }

            if ((tagName === 'INPUT') && (type === 'CHECKBOX' || type === 'RADIO')) {
                value = control.checked ? control.value : null;
            } else if (tagName === 'INPUT' || tagName === 'SELECT' || tagName === 'TEXTAREA') {
                value = control.value;
            }
        }

        return value;
    };

    this.hydrate = function(values, form)
    {
        let formControls   = form.querySelectorAll('[name]');
        let externControls = document.querySelectorAll(`[form="${form.id}"]`);

        hydrateControls(values, formControls);
        hydrateControls(values, externControls);

        return this;
    };

    let hydrateControls = function(values, controls)
    {
        for (let i = 0; i <= controls.length - 1; i ++) {
            let control = controls[i];
            let name    = control.name;

            if (name in values) {
                hydrateControl(values[name], control);
            }
        }
    };

    let hydrateControl = function(value, control)
    {
        let tagName = control.tagName.toUpperCase();
        let type    = control.getAttribute('type');
        if (type) {
            type = type.toUpperCase();
        }

        if ((tagName === 'INPUT') && (type === 'CHECKBOX' || type === 'RADIO')) {
            control.checked = (control.value === value);
        } else if (tagName === 'INPUT' || tagName === 'SELECT' || tagName === 'TEXTAREA') {
            control.value = value;
        }
    };

    this.submitControlRelatedForm = function(control)
    {
        let formId = control.getAttribute('form');
        let form   = document.getElementById(formId);

        if (!form) {
            throw new Error(`Form with id '${formId}' not found`);
        }

        if (form.tagName.toUpperCase() !== 'FORM') {
            throw new Error(`HTML-object '${formId}' is not a form`);
        }

        form.submit();

        return this;
    };
};