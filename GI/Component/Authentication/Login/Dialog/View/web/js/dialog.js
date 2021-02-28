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
giClient.component.authentication.login.dialog.Dialog = function()
{
    giClient.component.dialog.Dialog.call(this);


    let me = this;


    let _form;
    this.getForm = function()
    {
        return _form;
    };

    let _login;
    this.getLogin = function()
    {
        return _login;
    };

    let _password;
    this.getPassword = function()
    {
        return _password;
    };

    let _resultMessageContainer;
    this.getResultMessageContainer = function()
    {
        return _resultMessageContainer;
    };

    let _successMessage;
    this.getSuccessMessage = function()
    {
        return _successMessage;
    };


    let _parentConstruct = this.construct;
    this.construct = function(objectHash)
    {
        _parentConstruct.call(this, objectHash);

        _form                   = this.getObjectElement('form');
        _login                  = this.getObjectElement('login-textbox', _form);
        _password               = this.getObjectElement('password-textbox', _form);
        _resultMessageContainer = this.getObjectElement('result-message-container', _form);
        _successMessage         = this.getServerData('success-message');

        _form.addEventListener(
            'submit',
            function(ev)
            {
                ev.preventDefault();

                let url     = _form.getAttribute('action');
                let request = me.extractForm(_form);

                me.createAjax().getUrlEncoded().setMethodToPost().setResponseTypeToJson().send(
                    url, request, processResponse
                );
            }
        );

        return this;
    };

    let processResponse = function(response)
    {
        let {success = 0, redirectUri = '', message = ''} = response;

        if (success === 1) {
            redirect(redirectUri);
        } else {
            showFail(message);
        }
    };

    let redirect = function(redirectUri)
    {
        _resultMessageContainer.classList.remove('gi-error')

        _resultMessageContainer.innerHTML = _successMessage;

        document.location.href = redirectUri;
    };

    let showFail = function (message)
    {
        _resultMessageContainer.classList.add('gi-error')

        _resultMessageContainer.innerHTML = message;
    };
};