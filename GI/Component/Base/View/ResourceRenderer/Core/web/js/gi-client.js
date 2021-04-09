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
let giClient = {
    core: {
        cookie: {},
        widget: {},
        ajax: {
            configurator: {}
        }
    },
    component: {
        authentication: {
            login: {
                dialog: {}
            },
            logout: {}
        },
        autocomplete: {},
        calendar: {},
        captcha: {
            imageText: {}
        },
        csrfToken: {},
        dateTime: {
            base: {
                handlers: {}
            },
            date: {},
            dateHourMinute: {},
            dateTime: {},
            hourMinute: {},
            time: {},
            year: {},
            yearMonth: {}
        },
        dialog: {},
        locales: {},
        menu: {},
        paging: {
            base: {},
            chain: {},
            dropdown: {}
        },
        switcher: {},
        table: {}
    },
    custom: {}
};

giClient.core.getCsrfToken = function()
{
    let tokenHiddens = document.getElementsByName('gi-csrf-token');

    if (tokenHiddens.length === 0) {
        throw new Error('CSRF-Token not found');
    }

    return tokenHiddens[0].value;
};

giClient.core.customNamespace = function(namespace)
{
    let parts = namespace.split('.');

    let container = giClient.custom;

    for (let i = 0; i <= parts.length - 1; i ++) {
        let part = parts[i];

        if (!(part in container)) {
            container[part] = {};
        }

        container = container[part];
    }
};