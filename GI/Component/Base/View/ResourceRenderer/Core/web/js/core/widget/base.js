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
giClient.core.widget.Base = function()
{
    let _singletonSelector       = giClient.core.widget.selector;
    let _singletonRepository     = giClient.core.widget.repository;
    let _nsAjax                  = giClient.core.ajax;
    let _singletonForm           = giClient.core.form;
    let _singletonTextProcessing = giClient.core.textProcessing;
    let _nsCookie                = giClient.core.cookie;

    let _objectHash;
    this.getObjectHash = function()
    {
        return _objectHash;
    };
    this.setObjectHash = function(objectHash)
    {
        if (_objectHash) {
            throw new Error('Object hash already set');
        } else {
            _objectHash = objectHash;
        }

        return this;
    };

    this.createAjax = function()
    {
        return new _nsAjax.Ajax();
    };

    this.getObjectElement = function(giID, container)
    {
        if (!container) {
            container = document;
        }

        return _singletonSelector.getJSObjectElement(container, _objectHash, giID);
    };

    this.getObjectElementList = function(giID, container)
    {
        if (!container) {
            container = document;
        }

        return _singletonSelector.getJSObjectElementList(container, _objectHash, giID);
    };

    this.findRelationTarget = function(relation)
    {
        let hidden = _singletonSelector.getJSRelationElement(_objectHash, relation);
        let id     = hidden.getAttribute('data-gi-related-object');

        return _singletonRepository.get(id);
    };

    this.getServerData = function(key)
    {
        let hidden = _singletonSelector.getServerDataElement(_objectHash, key);

        return hidden.value;
    };

    this.getSessionId = function()
    {
        return this.getServerData('gi-session');
    };

    this.extractForm = function(form)
    {
        return _singletonForm.extract(form);
    };

    this.submitControlRelatedForm = function(control)
    {
        _singletonForm.submitControlRelatedForm(control);

        return this;
    };

    this.createCookie = function(name)
    {
        return new _nsCookie.Cookie().construct(name);
    };

    this.createCookieCollection = function()
    {
        return new _nsCookie.Collection();
    };

    this.render = function(template, params)
    {
        return _singletonTextProcessing.render(template, params);
    };

    this.getCsrfToken = function()
    {
        return giClient.core.getCsrfToken();
    };
};