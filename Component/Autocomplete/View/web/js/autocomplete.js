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
giClient.component.autocomplete.Autocomplete = function()
{
    giClient.core.widget.Base.call(this);


    let me = this;


    let _textbox = null;
    this.getTextbox = function()
    {
        return _textbox;
    };

    let _listContainer = null;
    this.getListContainer = function()
    {
        return _listContainer;
    };

    let _list = null;
    this.getList = function()
    {
        return _list;
    };

    let _uri;
    this.getUri = function()
    {
        return _uri;
    };

    let _cancel = false;
    this.getCancel = function()
    {
        return _cancel;
    };

    let _response = {};
    this.getResponse = function()
    {
        return _response;
    };

    let _duration = 500;
    this.getDuration = function()
    {
        return _duration;
    };
    this.setDuration = function(duration)
    {
        _duration = duration;

        return this;
    };

    let _blurPause = 200;
    this.getBlurPause = function()
    {
        return _blurPause;
    };
    this.setBlurPause = function(blurPause)
    {
        _blurPause = blurPause;

        return this;
    };

    let _selectedIndex = null;
    this.getSelectedIndex = function()
    {
        return _selectedIndex;
    };


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

        _textbox = this.getObjectElement('textbox');
        _uri     = this.getServerData('uri');

        _listContainer = this.getObjectElement('list-container');
        _list          = _listContainer.querySelector('ul');

        initTextbox();

        return this;
    };

    let initTextbox = function()
    {
        _textbox.addEventListener(
            'keyup',
            function(e)
            {
                if (e.key.toUpperCase() === 'ESC' || _textbox.value === '') {
                    hide();
                } else if (!_cancel) {
                    _cancel = true;

                    window.setTimeout(function() {send();}, _duration);
                }
            }
        );

        _textbox.addEventListener(
            'blur',
            function()
            {
                window.setTimeout(function() {hide();}, _blurPause);
            }
        );
    };

    let send = function()
    {
        if (_textbox.value !== '') {
            let request = {search: _textbox.value};

            me.createAjax().getUrlEncoded().setMethodToGet().setResponseTypeToJson().send(_uri, request, show);
        }
    };

    let show = function(response)
    {
        _response = response;

        _list.innerHTML = '';

        let dataName = _textbox.getAttribute('data-name');

        for (let i = 0; i <= _response.length - 1; i ++) {
            let option = document.createElement('li');
            option.innerHTML = _response[i][dataName];
            _list.appendChild(option);

            initOption(option, i);
        }

        if (_response.length > 0) {
            _listContainer.style.display = 'block';

            _listContainer.style.left = _textbox.offsetLeft + 'px';
            _listContainer.style.top = (_textbox.offsetTop + _textbox.offsetHeight) + 'px';
            _listContainer.style.width = _textbox.offsetWidth + 'px';
        }
    };

    let hide = function()
    {
        _listContainer.style.display = 'none';

        _cancel = false;
    };

    let initOption = function(option, index)
    {
        option.addEventListener(
            'click',
            function()
            {
                _selectedIndex = index;
                _textbox.value = me.getSelectedTitle();
            }
        );
    };

    this.getSelectedItem = function()
    {
        validateSelectedIndex();

        return _response[_selectedIndex];
    };

    this.getSelectedTitle = function()
    {
        validateSelectedIndex();

        let key = _textbox.getAttribute('data-name');

        return this.getSelectedItem()[key];
    };

    let validateSelectedIndex = function()
    {
        if (_selectedIndex === null) {
            throw new Error(`Selected index not set`);
        }

        if (!(_selectedIndex in _response)) {
            throw new Error(`Response option with selected index ${_selectedIndex} not found`);
        }
    };
};