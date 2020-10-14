import $ from 'jquery';
import Echo from 'laravel-echo';
import Cookies from 'js-cookie';
import 'block-ui';
import 'popper.js';
import 'bootstrap';

window.bootbox = require('bootbox');

window.io = require('socket.io-client');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: 'http://localhost:6001',
    auth: {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }
});

$('body').on('submit', 'form.ajax', function (e) {
    e.preventDefault();
    e.stopPropagation();
    let form = $(e.target);
    let formErrors = form.find('.form-errors');
    let formAction = form.data('action');
    let formMethod = form.data('method');
    let formConfirm = form.data('confirm');
    let formRedirect = form.data('redirect');
    let onSuccess = function (data) {
        let redirectIfSet = function (redirect = null) {
            if (formRedirect) {
                redirect = formRedirect;
            }
            if (redirect) {
                window.location.href = redirect;
            }
        };
        if (!data.message) {
            redirectIfSet(data.redirect);
        } else {
            let success = {
                title: '성공!',
                message: data.message
            };
            if (data.redirect) {
                success.callback = redirectIfSet(data.redirect);
            }
            bootbox.alert(success);
        }
    };
    let onFailure = function (errors, xhr) {
        if (formErrors.length) {
            $.each(errors, function (key, value) {
                let alertLevel = xhr.status >= 500 || xhr.status < 422 ? 'danger' : 'warning';
                formErrors.append(
                    '<div class="alert alert-' + alertLevel + ' alert-dismissible fade show" role="alert">'
                    + value
                    + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    + '</div>');
            });
        } else {
            let output = [];
            $.each(errors, function (key, value) {
                output.push(value);
            });
            let failure = {
                title: '오류!',
                message: output.join("<br />")
            };
            if (xhr.responseJSON.redirect) {
                failure.callback = function () {
                    window.location.href = xhr.responseJSON.redirect;
                };
            }
            bootbox.alert(failure);
        }
    };
    if (formAction && formMethod) {
        if (!formConfirm || bootbox.confirm(formConfirm)) {
            let ajax = {
                url: formAction,
                type: formMethod,
                dataType: 'JSON',
                data: form.serializeArray()
            };
            if (Cookies.get('Authorization')) {
                ajax.headers.Authorization = 'Bearer ' + Cookies.get('Authorization');
            }
            if (formErrors.length) {
                formErrors.html('');
            }
            $.blockUI({message: ''});
            $.ajax(ajax)
            .done(function (data) {
                onSuccess(data);
            }).fail(function (xhr, err) {
                var errors = xhr.responseJSON;
                if (errors.message) {
                    onFailure([errors.message], xhr);
                } else {
                    onFailure(errors, xhr);
                }
            }).always(function () {
                $.unblockUI();
                return true;
            });
        }
    }
});