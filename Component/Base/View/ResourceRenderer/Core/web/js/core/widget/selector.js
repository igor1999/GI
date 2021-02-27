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
giClient.core.widget.selector = new function()
{
    this.getOneByJSClass = function(container, jsClass)
    {
        let result = container.querySelector(createJSClassSelector(jsClass));

        if (!result) {
            throw new Error(`Element with js-class \'${jsClass}\' not found`);
        }

        return result;
    };

    this.getAllByJSClass = function(container, jsClass)
    {
        return container.querySelectorAll(createJSClassSelector(jsClass));
    };

    let createJSClassSelector = function(jsClass)
    {
        return `[data-gi-js-class="${jsClass}"]`;
    };

    this.getOneByCSS = function(container, classCSS, giID)
    {
        let result = container.querySelector(createCSSSelector(classCSS, giID));

        if (!result) {
            throw new Error(`Element with class-css \'${classCSS}\' and gi-id \'${giID}\' not found`);
        }

        return result;
    };

    this.getAllByCSS = function(container, classCSS, giID)
    {
        return container.querySelectorAll(createCSSSelector(classCSS, giID));
    };

    let createCSSSelector = function(classCSS, giID)
    {
        return `[data-gi-css~="${classCSS}"][data-gi-id="${giID}"]`;
    };

    this.getJSObjectElement = function(container, objectHash, giID)
    {
        let result = container.querySelector(createJSObjectSelector(objectHash, giID));

        if (!result) {
            throw new Error(`Element with object hash \'${objectHash}\' and gi-id \'${giID}\' not found`);
        }

        return result;
    };

    this.getJSObjectElementList = function(container, objectHash, giID)
    {
        return container.querySelectorAll(createJSObjectSelector(objectHash, giID));
    };

    let createJSObjectSelector = function(objectHash, giID)
    {
        return `[data-gi-js-object="${objectHash}"][data-gi-id="${giID}"]`;
    };

    this.getJSRelationElement = function(objectHash, relation)
    {
        let result = document.querySelector(createJSRelationSelector(objectHash, relation));

        if (!result) {
            throw new Error(
                `Related element with object hash \'${objectHash}\' and relation \'${relation}\' not found`
            );
        }

        return result;
    };

    let createJSRelationSelector = function(objectHash, relation)
    {
        return `[data-gi-js-object="${objectHash}"][data-gi-relation="${relation}"]`;
    };

    this.getServerDataElement = function(objectHash, key)
    {
        let result = document.querySelector(createServerDataSelector(objectHash, key));

        if (!result) {
            throw new Error(
                `Server data with object hash \'${objectHash}\' and key \'${key}\' not found`
            );
        }

        return result;
    };

    let createServerDataSelector = function(objectHash, key)
    {
        return `[data-gi-js-object="${objectHash}"][data-gi-server-data="${key}"]`;
    };
};