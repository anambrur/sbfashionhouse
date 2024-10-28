/**
 * Form validation rules
 * @author Engr. Mizanur Rahman Khan <engr.mrksohag@gmail.com>
 * @version 1.0.0
 */
if ("undefined" == typeof jQuery) {
    throw new Error("SM Validation JavaScript needs jQuery JS file.");
}
$(document).ajaxError(function () {
    $(".log").text("Triggered ajaxError handler.");
    return false;
})
var smValidator;
(function ($) {
    smValidator = function (id, obj, type, callback, beforeCallback) {
        // console.log("id " + id);
        // console.log(obj);
        var hasRecaptcha = false;

        function check_fields(id, obj) {
            var error = 0;
            // console.log("id " + id);
            // console.log(obj);
            // $('#' + id).find('.form-group').removeClass("has-error");
            if (jQuery.type(obj) == 'object') {
                for (var item in obj) {
                    var obj1 = obj[item];
                    var errorArray = [];
                    var selector = $('#' + id).find('[name="' + item + '"]');
                    var loop = 0;
                    if (jQuery.type(obj1) == 'object') {
                        for (var item2 in obj1) {
                            // console.log("item2 " + item2);
                            var obj2 = obj1[item2];
                            // console.log(obj2);

                            if (jQuery.type(obj2) == 'object') {
                                var selectorLength = selector.length;
                                if (selectorLength > 0 || item2 == 'count' || item2 == 'reCaptcha') {
                                    if (item2 != 'count' && item2 != 'reCaptcha') {
                                        if (typeof CKEDITOR !== "undefined") {
                                            for (var instance in CKEDITOR.instances) {
                                                CKEDITOR.instances[instance].updateElement();
                                            }
                                        }
                                        var val = selector.val();
                                        var length = val.length;
                                    }

                                    // console.log(item+" "+item2+' val '+val +' length '+length);

                                    if (item2 == 'notEmpty') {
                                        if (length < 1) {
                                            error++;
                                            errorArray.push(obj2.message);
                                        }
                                    } else if (length > 0 && item2 == 'stringLength') {
                                        if (obj2.min && obj2.max) {
                                            if (length < obj2.min || (length > obj2.max)) {
                                                if ((obj2.max && length > obj2.max)) {
                                                    selector.val(val.substr(0, obj2.max));
                                                } else {
                                                    error++;
                                                    errorArray.push(obj2.message);
                                                }
                                            }
                                        } else {
                                            if (length < obj2.min) {
                                                error++;
                                                errorArray.push(obj2.message);
                                            }
                                        }

                                    } else if (length > 0 && item2 == 'match') {
                                        if ($('#' + id).find('[name="' + obj2.field + '"]').val() != val) {
                                            error++;
                                            errorArray.push(obj2.message);
                                        }
                                    } else if (length > 0 && item2 == 'email') {
                                        if (obj1['notEmpty'] !== undefined) {
                                            if (!ValidateEmail(val)) {
                                                error++;
                                                errorArray.push(obj2.message);
                                            }
                                        } else {
                                            if (length > 0) {
                                                if (!ValidateEmail(val)) {
                                                    error++;
                                                    errorArray.push(obj2.message);
                                                }
                                            }
                                        }
                                    } else if (length > 0 && item2 == 'mobile') {
                                        if (obj1['notEmpty'] !== undefined) {
                                            if (!phonenumber(val)) {
                                                error++;
                                                errorArray.push(obj2.message);
                                            }
                                        } else {
                                            if (length > 0) {
                                                if (!phonenumber(val)) {
                                                    error++;
                                                    errorArray.push(obj2.message);
                                                }
                                            }
                                        }
                                    } else if (length > 0 && item2 == 'count') {
                                        var count = 0;
                                        if (obj2.type == 'checkbox') {
                                            $('.' + obj2.countClass).each(function () {
                                                if ($(this).is(":checked")) {
                                                    count++;
                                                }
                                            });
                                        } else if (obj2.type == 'class') {
                                            $(obj2.selector).each(function () {
                                                count++;
                                            });
                                        }
                                        //										console.log("count "+count+" min "+obj2.min);
                                        if (count < obj2.min) {
                                            error++;
                                            if ($('#' + obj2.massageDivId + '_warning').length > 0) {
                                                $('#' + obj2.massageDivId + '_warning')
                                                    .html('<i class="help-block">' + obj2.message + "</i>");
                                            } else {
                                                $('#' + obj2.massageDivId)
                                                    .after('<div id="' + obj2.massageDivId + '_warning" class="has-error"><i class="help-block">' + obj2.message + "</i></div>")
                                            }
                                        } else {
                                            $('#' + obj2.massageDivId + '_warning').remove();
                                        }
                                    } else if (length > 0 && item2 == 'remote') {
                                        var data = item + "=" + val;
                                        $.ajax({
                                            url: obj2.url,
                                            type: obj2.type,
                                            async: false,
                                            data: data,
                                            success: function (response) {
                                                if (parseInt(response) == 1) {
                                                    error++;
                                                    errorArray.push(obj2.message);
                                                }
                                            },
                                            error: function (error) {
                                                error++;
                                                errorArray.push(obj2.message);
                                            }
                                        });
                                    } else if (length > 0 && item2 == 'itsDependable') {
                                        if (length > 0 && obj2.rules[val]) {
                                            var rules = obj2.rules[val];
                                            error += check_fields(id, rules);
                                        }
                                    } else if (length > 0 && item2 == 'visaCard') {
                                        if (!visaCard(val)) {
                                            error++;
                                            errorArray.push(obj2.message);
                                        }
                                    } else if (length > 0 && item2 == 'masterCard') {
                                        if (!masterCard(val)) {
                                            error++;
                                            errorArray.push(obj2.message);
                                        }
                                    } else if (length > 0 && item2 == 'cardDateMonth') {
                                        if (!datemonthValiate(val)) {
                                            error++;
                                            errorArray.push(obj2.message);
                                        }
                                    } else if (length > 0 && item2 == 'url') {
                                        if (!isUrlValid(val)) {
                                            error++;
                                            errorArray.push(obj2.message);
                                        }
                                    } else if (length > 0 && item2 == 'custom') {
                                        var customReturn = obj2.callback(selector, val, length);
                                        if (customReturn.error > 0) {
                                            error++;
                                            errorArray.push(customReturn.message);
                                        }
                                    } else if (item2 == 'reCaptcha') {
                                        selector = $('#g-recaptcha-response').parent("div").parents('.g-recaptcha');
                                        if ($('.g-recaptcha').length > 0) {
                                            hasRecaptcha = true;
                                            var v = grecaptcha.getResponse();
                                            if (v.length == 0) {
                                                error++;
                                                errorArray.push(obj2.message);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (errorArray.length > 0) {
                        showError(selector, errorArray);
                    } else {
                        removeError(selector);
                    }
                }
            }
            return error;
        }

        for (var item in obj) {
            $('#' + id + ' [name="' + item + '"]').on('keyup', function () {
                var field = $(this).attr('name');
                // console.log("keyup " + field);

                var rulesKeyup = {};
                rulesKeyup[field] = obj[field];
                check_fields(id, rulesKeyup);
            });
            $('#' + id + ' [name="' + item + '"]').on('change', function () {
                var field = $(this).attr('name');
                // console.log("change " + field);

                var rulesChange = {};
                rulesChange[field] = obj[field];
                check_fields(id, rulesChange);
            });
        }

        //type validation only
        if (type == 2) {
            if ($(".loading").length > 0) {
                $(".loading").fadeOut();
            }
            var error = check_fields(id, obj);
            if (hasRecaptcha) {
                grecaptcha.reset();
            }
            if (error > 0) {
                return false;
            } else {
                return true;
            }
        } else if (type == 3) {
            // console.log("ajax");
            $('#' + id).on('submit', function (e) {
                if ($(".loading").length > 0) {
                    $(".loading").fadeIn();
                }
                var id = $(this).attr('id');
                var error = check_fields(id, obj);
                if (hasRecaptcha) {
                    grecaptcha.reset();
                }
                $('#' + id).find('[type="submit"]').prop('disabled', true);
                if (error === 0) {
                    if (beforeCallback !== undefined) {
                        beforeCallback();
                    }
                    // console.log("ajax");
                    var data = $('#' + id).serialize();
                    var type = $('#' + id).attr('method');
                    var url = $('#' + id).attr('action');
                    $.ajax({
                        type: type,
                        url: url,
                        data: data,
                        success: function (response) {
                            $('#' + id).find('[type="submit"]').removeAttr('disabled');
                            if (jQuery.type(obj) == 'object') {
                                for (item in obj) {
                                    $('#' + id).find('[name="' + item + '"]').val("");
                                }
                            }
                            if ($(".loading").length > 0) {
                                $(".loading").fadeOut();
                            }
                            callback({
                                isSuccess: true,
                                response: response
                            });
                        },
                        error: function (error) {
                            $('#' + id).find('[type="submit"]').removeAttr('disabled');
                            console.log(error);
                            var errors = error.responseJSON.errors;
                            var errorCannotShow = '';
                            for (var err in errors) {
                                // console.log("err "+err);
                                var selector = $('#' + id).find('[name="' + err + '"]');
                                if (selector.length > 0) {
                                    showError(selector, errors[err]);
                                } else {
                                    var text = errors[err][0];
                                    errorCannotShow += text + " \n";
                                }
                            }
                            if (errorCannotShow != '') {
                                callback({
                                    isSuccess: false,
                                    response: errorCannotShow
                                });
                            } else {
                                callback({
                                    isSuccess: false,
                                    response: error.responseJSON.message
                                });
                            }
                            if ($(".loading").length > 0) {
                                $(".loading").fadeOut();
                            }
                        }
                    });
                } else {
                    $('#' + id).find('[type="submit"]').removeAttr('disabled');
                    if ($(".loading").length > 0) {
                        $(".loading").fadeOut();
                    }
                }
                return false;
            });
        } else {
            $('#' + id).on('submit', function (e) {
                var error = check_fields(id, obj);
                if (hasRecaptcha) {
                    grecaptcha.reset();
                }
                // console.log("error before " + error);
                if (error > 0) {
                    return false;
                }
            });
        }
    }
})(jQuery);

function ValidateEmail(mail) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,5})+$/;

    if (!filter.test(mail)) {
        return (false)
    }
    return (true)
}

function datemonthValiate(dateExpire) {
    var validate = /^[0-9]{2}\/[0-9]{4}$/;
    if (validate.test(dateExpire)) {
        return true;
    }
    return false;
}

function visaCard(feild_value) {
    var text = feild_value.replace(/-/g, "");
    text = text.replace(/ /g, "");
    var card = /^[4]{1}[0-9]{15}$/;

    if (card.test(text)) {
        return true;
    }
    return false;
}

function masterCard(feild_value) {
    var text = feild_value.replace(/-/g, "");
    text = text.replace(/ /g, "");

    var card = /^[5]{1}[0-9]{15}$/;
    var card2 = /^[2]{1}[0-9]{15}$/;

    if (card.test(text) || card2.test(text)) {
        return true;
    }
    return false;
}

String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

function phonenumber(inputtxt) {
    var text = inputtxt.replaceAll("-", "");
    text = text.replaceAll(" ", "");
    var mob = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
    if (mob.test(text)) {
        return true;
    } else {
        return false;
    }
}

function isUrlValid(userInput) {
    var res = userInput.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
    if (res == null)
        return false;
    else
        return true;
}

function showError(selector, errorArray) {
    selector.parent('div').addClass("has-error");
    if (selector.siblings('.help-block').length > 0) {
        selector.siblings('.help-block').html(errorArray[0]);
    } else {
        selector.after('<i class="help-block">' + errorArray[0] + "</i>");
    }
}

function removeError(selector) {
    selector.parent('div').removeClass("has-error");
    if (selector.siblings('.help-block').length > 0) {
        selector.siblings('.help-block').remove();
    }
}