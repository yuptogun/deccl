import Echo from 'laravel-echo';
import Cookies from 'js-cookie';
import 'block-ui';
import 'popper.js';
import 'bootstrap';
import 'summernote/dist/summernote-bs4';
import { confirm } from 'bootbox';

window.$ = window.jQuery = require('jquery');
window.bootbox = require('bootbox');

// #62 잠시만 안녕
// window.io = require('socket.io-client');
// window.Echo = new Echo({
//     broadcaster: 'socket.io',
//     host: 'http://localhost:6001',
//     auth: {
//         headers: {
//             Authorization: 'Bearer ' + localStorage.getItem('token')
//         }
//     }
// });

/**
 * $.ajax() 호출에 사용할 설정객체를 만든다.
 * @param {string} action 호출할 URL
 * @param {string} method 기본값은 'POST'
 * @param {mixed} ajaxData 전송할 데이터
 * @param {string} contentType enctype 필드 값
 * @returns {object} 이걸 가지고 $.ajax() 할수있음
 */
window.getAJAXConfig = function (action, method = 'POST', ajaxData = null, contentType = null) {
    let ajax = {
        url: action,
        type: method,
        dataType: 'JSON',
    };
    if (contentType == 'multipart/form-data') {
        ajax.processData = false;
        ajax.contentType = false;
        ajax.data = ajaxData;
    }
    if (ajaxData) {
        ajax.data = ajaxData;
    }
    if (Cookies.get('Authorization')) {
        ajax.headers.Authorization = 'Bearer ' + Cookies.get('Authorization');
    }
    return ajax;
};

/**
 * 공통 AJAX 처리
 * @param {string} action 호출할 URL
 * @param {string} method 기본값은 `POST`
 * @param {mixed} ajaxData 전송할 데이터. 없으면 안넘겨도 됨. form 에 대해서는 selializeArray() 를 넘길것
 * @param {string} confirm 이 값을 주면 그 값대로 폼제출 전에 물어본다.
 * @param {string} redirect 이 값을 주면 성공시 그 url로 넘어간다.
 * @param {jQueryDOM} errorsDOM 이 값을 주면 실패시 에러메시지들을 여기에 뿌린다.
 * @param {string} contentType 파일업로드 폼일 경우 multipart/form-data 를 넘긴다.
 * @returns {object} 성공시 성공으로 돌아온 데이터 일체, 실패시 xhr error 객체
 */
window.doAJAX = function (action, method = 'POST', ajaxData = null, confirm = null, redirect = null, errorsDOM = null, contentType = null) {
    let onSuccess = function (data) {
        let redirectIfSet = function (r = null) {
            if (redirect) {
                r = redirect;
            }
            if (r) {
                if (r == '#') {
                    window.location.reload();
                } else {
                    window.location.href = r;
                }
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
                success.callback = function () { redirectIfSet(data.redirect); };
            }
            bootbox.alert(success);
        }
    };
    let onFailure = function (errors, xhr) {
        if (errorsDOM && errorsDOM.length) {
            $.each(errors, function (key, value) {
                let alertLevel = xhr.status >= 500 || xhr.status < 422 ? 'danger' : 'warning';
                errorsDOM.append(
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
    let _doAJAX = function (action, method, ajaxData, redirect, errorsDOM, contentType) {
        let ajax = getAJAXConfig(action, method, ajaxData, contentType);
        if (errorsDOM && errorsDOM.length) {
            errorsDOM.html('');
        }
        $.blockUI({message: ''});
        $.ajax(ajax)
        .done(function (data) {
            onSuccess(data, redirect);
        }).fail(function (xhr, err) {
            let errors = xhr.responseJSON;
            if (errors.message) {
                onFailure([errors.message], xhr);
            } else {
                onFailure(errors, xhr);
            }
        }).always(function () {
            $.unblockUI();
        });
    };
    if (action && method) {
        if (confirm) {
            bootbox.confirm(confirm, function (result) {
                if (result) {
                    _doAJAX(action, method, ajaxData, redirect, errorsDOM, contentType);
                }
            });
        } else {
            _doAJAX(action, method, ajaxData, redirect, errorsDOM, contentType);
        }
    }
};

/**
 * 특정 폼에 ajax 클래스를 주면 AJAX 요청으로 처리한다.
 * @param {jQueryDOM} form .ajax 클래스가 붙어있는 폼태그
 */
window.formAJAX = function (form) {
    let formAction = form.data('action');
    let formMethod = form.data('method');
    let formContentType = form.attr('enctype') || null;
    let formData = form.serializeArray();
    if (formContentType == 'multipart/form-data') {
        formData = new FormData(form[0]);
    }
    let formConfirm = form.data('confirm');
    let formRedirect = form.data('redirect');
    let formErrors = form.find('.form-errors');
    return doAJAX(formAction, formMethod, formData, formConfirm, formRedirect, formErrors, formContentType);
};
/**
 * 특정 요소에 ajax 클래스를 주면 data 속성들을 읽어서 AJAX 콜한다.
 * @param {jQueryDOM} element a 또는 button 태그 요소
 */
window.buttonAJAX = function (element) {
    let formAction = element.data('action');
    let formMethod = element.data('method');
    let formData = element.data();
    let formConfirm = element.data('confirm');
    let formRedirect = element.data('redirect');
    return doAJAX(formAction, formMethod, formData, formConfirm, formRedirect);
};

$('body').on('submit', 'form.ajax', function (e) {
    e.preventDefault();
    e.stopPropagation();
    return formAJAX($(e.target));
});
$('body').on('click', 'a.ajax, button.ajax', function (e) {
    e.preventDefault();
    e.stopPropagation();
    return buttonAJAX($(e.target));
});

$('body').on('change', '.custom-file-input', function (event) {
    $(this).next('.custom-file-label').html(event.target.files[0].name);
});

(function ($) {
    let commentInput = $('#comment');
    commentInput.summernote({
        height: 240,
        placeholder: '이 기사에 대해 한마디 해 주세요.',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['paragraph', ['style']],
            ['etc', ['codeview']]
        ],
        styleTags: [
            'p',
            { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' }
        ],
        blockquoteBreakingLevel: 1
    });
})(jQuery);