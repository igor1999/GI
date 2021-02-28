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
giClient.component.captcha.imageText.ImageText = function()
{
    giClient.core.widget.Base.call(this);


    let me = this;


    let _container;
    this.getContainer = function()
    {
        return _container;
    };

    let _captchaImage;
    this.getCaptchaImage = function()
    {
        return _captchaImage;
    };

    let _idHidden;
    this.getIdHidden = function()
    {
        return _idHidden;
    };

    let _recaptchaButton;
    this.getRecaptchaButton = function()
    {
        return _recaptchaButton;
    };


    this.construct = function(objectHash)
    {
        this.setObjectHash(objectHash);

        _container       = this.getObjectElement('container');
        _captchaImage    = this.getObjectElement('captcha-image', _container);
        _idHidden        = this.getObjectElement('id-hidden', _container);
        _recaptchaButton = this.getObjectElement('recaptcha-button', _container);

        initRecaptchaButton();

        return this;
    };

    let initRecaptchaButton = function()
    {
        _recaptchaButton.addEventListener(
            'click',
            function()
            {
                let url = me.getServerData('recaptcha-url');

                me.createAjax().getUrlEncoded().setMethodToPost().setResponseTypeToJson().send(url, {}, refresh);
            }
        );
    };

    let refresh = function(response)
    {
        let {id = '', src = ''} = response;

        _idHidden.value   = id;
        _captchaImage.src = src;
    };
};