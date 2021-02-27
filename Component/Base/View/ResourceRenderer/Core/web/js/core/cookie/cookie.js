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
giClient.core.cookie.Cookie = function()
{
    const DEFAULT_MAX_AGE = 3600;


    let _name;
    this.getName = function()
    {
        return _name;
    };

    let _maxAge = DEFAULT_MAX_AGE;
    this.getMaxAge = function()
    {
        return _maxAge;
    };
    let setMaxAge = function(maxAge, coefficient)
    {
        if (typeof(maxAge) !== 'number') {
            throw new Error(`Max age '${maxAge}' is not a number`);
        }

        if (maxAge <= 0) {
            throw new Error(`Max age '${maxAge}' should be a positive number`);
        }

        _maxAge = Math.ceil(maxAge) * coefficient;
    };
    this.setMaxAgeInSeconds = function(seconds)
    {
        setMaxAge(seconds, 1);

        return this;
    };
    this.setMaxAgeInHours = function(hours)
    {
        setMaxAge(hours, 3600);

        return this;
    };
    this.setMaxAgeInDays = function(days)
    {
        setMaxAge(days, 24 * 3600);

        return this;
    };
    this.setMaxAgeInYears = function(years)
    {
        setMaxAge(years, 36525 * 24 * 36);

        return this;
    };

    let _path = '/';
    this.getPath = function()
    {
        return _path;
    };
    this.setPath = function(path)
    {
        _path = path;

        return this;
    };

    let _domain;
    this.getDomain = function()
    {
        return _domain;
    };
    this.setDomain = function(domain)
    {
        _domain = domain;

        return this;
    };

    let _secure = false;
    this.isSecure = function()
    {
        return _secure;
    };
    this.setSecure = function(secure)
    {
        _secure = secure;

        return this;
    };


    this.construct = function(name)
    {
        _name = name;

        return this;
    };

    let find = function()
    {
        let items = document.cookie.split(";");
        let found = false;
        let value = '';

        for (let i = 0; i <= items.length - 1; i ++) {
            let [name, value] = items[i].trim().split('=');

            if (name === _name) {
                found = true;
                value = decodeURIComponent(value);
                break;
            }
        }

        return {found: found, value: value};
    };

    this.has = function()
    {
        let {found = false, value = ''} = find();

        return found;
    };

    this.get = function()
    {
        let {found = false, value = ''} = find();

        if (!found) {
            throw new Error(`Cookie '${_name}' not found`);
        }

        return value;
    };

    this.getOptional = function(defaultValue)
    {
        let value = defaultValue;

        try {
            value = this.get();
        } catch (e) {}

        return value;
    };

    this.reset = function()
    {
        this.setMaxAgeInSeconds(DEFAULT_MAX_AGE).setPath('/').setDomain('').setSecure(false);

        return this;
    };

    this.createForSessionOnly = function(value)
    {
        let parts = [
            `${_name}=${value}`,
        ];

        addOptionalParts(parts);
        compile(parts);

        return this;
    }

    this.createWithMaxAge = function(value)
    {
        let parts = [
            `${_name}=${value}`,
            `max-age=${_maxAge}`
        ];

        addOptionalParts(parts);
        compile(parts);

        return this;
    }

    this.remove = function()
    {
        let parts = [
            `${_name}=`,
            `max-age=0`
        ];

        addOptionalParts(parts);
        compile(parts);

        return this;
    }

    let addOptionalParts = function(parts)
    {
        parts.push(`path=${_path}`);

        if (_domain) {
            parts.push(`domain=${_domain}`);
        }

        if (_secure) {
            parts.push('secure');
        }
    };

    let compile = function(parts)
    {
        document.cookie = parts.join('; ');
    };
};