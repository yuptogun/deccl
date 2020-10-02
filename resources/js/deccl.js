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
                bootbox.alert({
                    title: '성공!',
                    message: data.message
                });
            }
            // if (data.data.token) {
            //     if (data.data.token == '') {
            //         Cookies.remove('Authorization');
            //     } else {
            //         Cookies.set('Authorization', data.data.token, {expires: 365});
            //     }
            // }
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        }).fail(function (xhr, err) {
            // if (xhr.status == 422) {
                var errors = xhr.responseJSON;
                // console.log(errors);
                if (formErrors.length) {
                    let output = form.find('.form-errors');
                    $.each(errors, function (key, value) {
                        let alertLevel = xhr.status >= 500 || xhr.status < 422 ? 'danger' : 'warning';
                        output.append(
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
                    bootbox.alert({
                        title: '오류!',
                        message: output.join("<br />")
                    });
                }
            // } else if (xhr.responseJSON) {
            //     bootbox.alert({
            //         title: '오류!',
            //         message: xhr.responseJSON.message
            //     });
            // }
        }).always(function () {
            $.unblockUI();
            return true;
        });
    }
});