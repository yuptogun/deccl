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
    let action = form.data('action');
    let method = form.data('method');
    let showErrors = function (errors, xhr) {
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
    if (action && method) {
        $.blockUI({
            message: ''
        });
        if (formErrors.length) {
            formErrors.html('');
        }
        let ajax = {
            url: action,
            type: method,
            dataType: 'JSON',
            data: form.serializeArray()
        };
        if (Cookies.get('Authorization')) {
            ajax.headers.Authorization = 'Bearer ' + Cookies.get('Authorization');
        }
        $.ajax(ajax)
        .done(function (data) {
            if (data.message) {
                let success = {
                    title: '성공!',
                    message: data.message
                };
                if (data.redirect) {
                    success.callback = function () {
                        window.location.href = data.redirect;
                    };
                }
                bootbox.alert(success);
            }
        }).fail(function (xhr, err) {
            var errors = xhr.responseJSON;
            if (errors.message) {
                showErrors([errors.message], xhr);
            } else {
                showErrors(errors, xhr);
            }
        }).always(function () {
            $.unblockUI();
            return true;
        });
    }
});