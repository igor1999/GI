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
giClient.core.ajax.Sender = function()
{
    const _methods = {get: 'get', post: 'post', put: 'put', delete: 'delete'};
    let _method = _methods.get;
    this.getMethod = function()
    {
        return _method;
    };
    let setMethod = function(method)
    {
        _method = method;
    }
    this.isMethodGet = function()
    {
        return _method === _methods.get;
    }
    this.setMethodToGet = function()
    {
        setMethod(_methods.get);

        return this;
    }
    this.setMethodToPost = function()
    {
        setMethod(_methods.post);

        return this;
    }
    this.setMethodToPut = function()
    {
        setMethod(_methods.put);

        return this;
    }
    this.setMethodToDelete = function()
    {
        setMethod(_methods.delete);

        return this;
    }

    const _requestTypes = {urlEncoded: 'url-encoded', json: 'json', xml: 'xml', multipart: 'multipart'};
    let _requestType = _requestTypes.urlEncoded;
    this.getRequestType = function()
    {
        return _requestType;
    };
    let setRequestType = function(requestType)
    {
        _requestType = requestType;
    }
    this.setRequestTypeToUrlEncoded = function()
    {
        setRequestType(_requestTypes.urlEncoded);

        return this;
    }
    this.setRequestTypeToJson = function()
    {
        setRequestType(_requestTypes.json);

        return this;
    }
    this.setRequestTypeToXML = function()
    {
        setRequestType(_requestTypes.xml);

        return this;
    }
    this.setRequestTypeToMultipart = function()
    {
        setRequestType(_requestTypes.multipart);

        return this;
    }

    let _customHeaders = {};
    this.getCustomHeaders = function()
    {
        return _customHeaders;
    };
    this.setCustomHeaders = function(customHeaders)
    {
        if (!customHeaders instanceof Object) {
            throw new Error('Custom headers should be an object');
        }

        _customHeaders = customHeaders;

        return this;
    };

    let _csrfHeader = true;
    this.isCSRFHeader = function()
    {
        return _csrfHeader;
    };
    this.setCSRFHeader = function(csrfHeader)
    {
        _csrfHeader = csrfHeader;

        return this;
    };

    const _responseTypes = {text: 'text', json: 'json', xml: 'xml', html: 'html'};
    let _responseType = _responseTypes.text;
    this.getResponseType = function()
    {
        return _responseType;
    };
    let setResponseType = function(responseType)
    {
        _responseType = responseType;
    }
    this.setResponseTypeToText = function()
    {
        setResponseType(_responseTypes.text);

        return this;
    }
    this.setResponseTypeToJson = function()
    {
        setResponseType(_responseTypes.json);

        return this;
    }
    this.setResponseTypeToXML = function()
    {
        setResponseType(_responseTypes.xml);

        return this;
    }
    this.setResponseTypeToHTML = function()
    {
        setResponseType(_responseTypes.html);

        return this;
    }


    this.reset = function()
    {
        this.setCustomHeaders({}).setCSRFHeader(true).setResponseTypeToText();

        return this;
    };

    this.send = function(url, query, successCallback, failCallback)
    {
        validate(url, query, successCallback, failCallback);

        let sender = createSender(url);
        setRequestHeaders(sender);

        sender.onreadystatechange = function() {
            if (sender.readyState === 4) {
                if ((sender.status === 200) && successCallback) {
                    let response = parseResponse(sender.responseText);
                    successCallback(response);
                }  else if (sender.status !== 200) {
                    if (failCallback) {
                        failCallback(sender.responseText, sender.status);
                    } else {
                        alert('Unexpected server error!')
                    }
                }
            }
        };

        sender.send(query);
    };

    let validate = function(url, query, successCallback, failCallback)
    {
        validateUrl(url);
        validateQuery(query);
        validateSuccessCallback(successCallback);
        validateFailCallback(failCallback);
    };

    let validateUrl = function(url)
    {
        if (typeof(url) !== 'string') {
            throw new Error('AJAX request URL should be a string only');
        }
    };

    let validateQuery = function(query)
    {
        let isString    = (typeof(query) === 'string');
        let isFormData  = (query instanceof FormData);
        let isMultipart = (_requestType === _requestTypes.multipart);
        let isPost      = (_method === _methods.post);

        if (isMultipart && !isFormData) {
            throw new Error('By AJAX request type \'multipart\' query should be a FormData object only');
        }

        if (isMultipart && !isPost) {
            throw new Error('By AJAX request type \'multipart\' HTTP-method should be a \'post\' only');
        }

        if (!isString) {
            throw new Error('By AJAX request types except of \'multipart\' query should be a string only');
        }
    };

    let validateSuccessCallback = function(successCallback)
    {
        if (successCallback && !(successCallback instanceof Function)) {
            throw new Error('AJAX request success callback should be a function only');
        }
    };

    let validateFailCallback = function(failCallback)
    {
        if (failCallback && !(failCallback instanceof Function)) {
            throw new Error('AJAX request fail callback should be a function only');
        }
    };

    let createSender = function(url)
    {
        let sender = new XMLHttpRequest();
        sender.open(_method, url, true);

        return sender;
    };

    let setRequestHeaders = function(sender)
    {
        for (let key in _customHeaders) {
            sender.setRequestHeader(key, _customHeaders[key]);
        }

        sender.setRequestHeader('X-Requested-With-Xhr', 'XMLHttpRequest');

        if ((_requestType === _requestTypes.urlEncoded) && (_method !== _methods.get)) {
            sender.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        } else if (_requestType === _requestTypes.json) {
            sender.setRequestHeader('Content-Type', 'application/json');
        } else if (_requestType === _requestTypes.xml) {
            sender.setRequestHeader('Content-Type', 'application/xml');
        }

        if (_csrfHeader) {
            try {
                sender.setRequestHeader('X-Csrf-Token', giClient.core.getCsrfToken());
            } catch (e) {}
        }
    };

    let parseResponse = function(response)
    {
        if (_responseType === _responseTypes.json) {
            response = JSON.parse(response);
        } else if (_responseType === _responseTypes.xml) {
            let domParser = new DOMParser();
            response = domParser.parseFromString(response, 'text/xml');
        } else if (_responseType === _responseTypes.html) {
            let domParser = new DOMParser();
            response = domParser.parseFromString(response, 'text/html');
        }

        return response;
    };
};