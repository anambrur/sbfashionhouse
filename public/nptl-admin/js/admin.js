function generateInput(html, value, formattedValue) {
    $("body").append('<div id="mrks">' + html + '</div>>');
    $("#mrks").find("input").val(value);
    $("#mrks").find("input").attr('data-formattedvalue', formattedValue);
    var returnval = $("#mrks").html();
    $("#mrks").remove();
    return returnval;
}

(function ($) {
    'use strict';
    /**
     * Close modal on click
     */

    if ($('.close_modal').length > 0) {
        $('.close_modal').on('click', function () {
            var close = $(this).data('close');
            $('#' + close).modal('hide');
        });
    }
    /**
     *  Status chnge
     * @return void
     */
    // if ($('.data_table, .sm_table').length > 0) {
    $('.data_table, .sm_table, #example').on('change', '.change_status', function () {
        var status = $(this).val();
        var post_id = $(this).attr('post_id');
        var route = $(this).attr('route');
        var _token = $('#table_csrf_token').val();
        //console.log(status + ' ' + post_id + ' ' + route + ' ' + _token);
        $.ajax({
            type: 'post',
            url: url + route,
            data: {post_id: post_id, status: status, _token: _token},
            success: function (response) {
//            console.log(response);
                swal({
                    type: 'success',
                    icon: "success",
                    title: 'Status updated Successfully',
                    showConfirmButton: false,
                    timer: 3000
                });
                location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
        return false;
    });
    // }

    /**
     * delete data from table
     */
    // if ($('.delete_data_row').length > 0) {

    $(document).on('click', '.delete_data_row', function () {
        var url = $(this).attr('href');
        var delete_row = $(this).attr('delete_row');
        var delete_message = $(this).attr('delete_message');
        swal({
            title: "Are you sure?",
            text: delete_message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'get',
                    url: url,
                    success: function (response) {
                        if (parseInt(response) == 1) {
                            // var elem = document.getElementById(delete_row);
                            // elem.parentNode.removeChild(elem);

                            swal({
                                type: 'success',
                                icon: "success",
                                title: 'Deleted Successfully',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            location.reload();
                        } else if (parseInt(response) == 0) {
                            swal({
                                type: 'warning',
                                icon: "warning",
                                title: 'Deleted Failed',
                                showConfirmButton: false,
                                timer: 4000
                            });
                        } else {
                            // var elem = document.getElementById(delete_row);
                            // elem.parentNode.removeChild(elem);
                            swal({
                                type: 'warning',
                                icon: "warning",
                                title: 'Success',
                                text: response,
                                showConfirmButton: false,
                                timer: 4000
                            });
                            location.reload();
                        }
                    },
                    error: function (error) {
                        //console.log(error);
                        swal({
                            type: 'error',
                            icon: "error",
                            title: 'Warning!',
                            text: error.responseText,
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }
                });
            } else {
                swal({
                    type: 'warning',
                    icon: "warning",
                    title: 'Delete Cancelled',
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });
        return false;
    });
    // }
    /**
     *  This function will work to add active clss in admin menu
     */

    if ($('#admin_main_nav').length > 0) {
//      console.log(controller + ' ' + method);
        $('#admin_main_nav').find('[ctrl="' + controller + '"]').addClass('active open');
        $('#admin_main_nav [ctrl="' + controller + '"]').children('ul').find('>li[mtd="' + method + '"]').addClass('active');
    }

    /**
     *  This function will work to add active clss in front menu
     */

    if ($('#front_dashboard_main_nav').length > 0) {
        $('#front_dashboard_main_nav').find('[mtd="' + method + '"]').addClass('active');
    }


    /**
     *  Admin username name checking function
     */
    if ($('#add_buser_form').length > 0) {
        $('#add_buser_form').on('change', '#username', function () {
            var username = $(this).val();
            check_username(username);
        });
        $('#add_buser_form').on('change', '#email', function () {
            var email = $(this).val();
            check_email(email);
        });
        $('#add_buser_form').on('submit', function () {
            var email = $('#email').val();
            var username = $('#username').val();
            var em = check_email(email);
            var us = check_username(username);
            // console.log(em + ' ' + us);
            if (parseInt(em) == 1 && parseInt(us) == 1) {
                return false;
            }
        });


    }


    function check_username(username) {
        var _token = $('#table_csrf_token').val();
        var ret = 0;
        $.ajax({
            type: 'post',
            url: smAdminUrl + 'check_username',
            async: false,
            data: {username: username, _token: _token},
            success: function (res) {
                if (res == 1) {
                    $('#add_user_btn').attr('disabled', true);
                    $('.username_wr').slideDown();
                    $('#username').css('border', '1px solid red');
                    ret = 1;
                } else {
                    $('.username_wr').slideUp();
                    $('#username').css('border', '1px solid #CCCCCC');
                    $('#add_user_btn').attr('disabled', false);
                }
            }
        });
        return ret;
    }

    function check_email(email) {
        var _token = $('#table_csrf_token').val();
        var ret = 0;
        $.ajax({
            type: 'post',
            url: smAdminUrl + 'check_email',
            async: false,
            data: {email: email, _token: _token},
            success: function (res) {
                if (res == 1) {
                    $('#add_user_btn').attr('disabled', true);
                    $('#email').css('border', '1px solid red');
                    $('.email_wr').slideDown();
                    ret = 1;
                } else {
                    $('#email').css('border', '1px solid #CCCCCC');
                    $('.email_wr').slideUp();
                    $('#add_user_btn').attr('disabled', false);
                }
            }
        });
        return ret;
    }


    /**
     *  Front username name checking function
     * @return null
     */
    if ($('#add_front_user_form').length > 0) {
        $('#add_front_user_form').on('change', '#username', function () {
            var username = $(this).val();
            check_front_username(username);
        });
        $('#add_front_user_form').on('change', '#email', function () {
            var email = $(this).val();
            check_front_email(email);
        });
        $('#add_front_user_form').on('submit', function () {
            var email = $('#email').val();
            var username = $('#username').val();
            var em = check_front_email(email);
            var us = check_front_username(username);
            //console.log(em + ' ' + us);
            if (parseInt(em) == 1 && parseInt(us) == 1) {
                return false;
            }
        });


    }

    /**
     * -----------------------------------------------------------------------------
     * Checking front user username
     * -----------------------------------------------------------------------------
     */
    function check_front_username(username) {
        var _token = $('#table_csrf_token').val();
        var ret = 0;
        $.ajax({
            type: 'post',
            url: smAdminUrl + 'front_user/check_username',
            async: false,
            data: {username: username, _token: _token},
            success: function (res) {
                if (res == 1) {
                    $('#add_user_btn').attr('disabled', true);
                    $('.username_wr').slideDown();
                    $('#username').css('border', '1px solid red');
                    ret = 1;
                } else {
                    $('.username_wr').slideUp();
                    $('#username').css('border', '1px solid #CCCCCC');
                    $('#add_user_btn').attr('disabled', false);
                }
            }
        });
        return ret;
    }

    /**
     * -----------------------------------------------------------------------------
     * Checking front user email
     * -----------------------------------------------------------------------------
     */
    function check_front_email(email) {
        var _token = $('#table_csrf_token').val();
        var ret = 0;
        $.ajax({
            type: 'post',
            url: smAdminUrl + 'front_user/check_email',
            async: false,
            data: {email: email, _token: _token},
            success: function (res) {
                if (res == 1) {
                    $('#add_user_btn').attr('disabled', true);
                    $('#email').css('border', '1px solid red');
                    $('.email_wr').slideDown();
                    ret = 1;
                } else {
                    $('#email').css('border', '1px solid #CCCCCC');
                    $('.email_wr').slideUp();
                    $('#add_user_btn').attr('disabled', false);
                }
            }
        });
        return ret;
    }

    /**
     * -----------------------------------------------------------------------------
     * Seo title on change or keyup it will show keyword length
     * @return length in text id
     * -----------------------------------------------------------------------------
     */

    if ($('#seo_title').length > 0) {
        change_seo_title();
        $('#seo_title').on('change', function () {
            change_seo_title();
        });
        $('#seo_title').on('keyup', function () {
            change_seo_title();
        });
    }

    function change_seo_title() {
        var length = parseInt($('#seo_title').val().length);
        $('#seo_title_length').text(70 - length);
    }

    /**
     * -----------------------------------------------------------------------------
     * Meta keyword on change or keyup it will show keyword length
     * @return length in text id
     * -----------------------------------------------------------------------------
     */

    // if ($('#meta_key').length > 0) {
    //     change_meta_key();
    //     $('#meta_key').on('change', function () {
    //         change_meta_key();
    //     });
    //     $('#meta_key').on('keyup', function () {
    //         change_meta_key();
    //     });
    // }
    //
    // function change_meta_key() {
    //     var length = parseInt($('#meta_key').val().length);
    //     $('#meta_key_length').text(160 - length);
    // }

    /**
     * -----------------------------------------------------------------------------
     * Meta description on change or keyup it will show description length
     * @return length in text id
     * -----------------------------------------------------------------------------
     */
    if ($('#meta_description').length > 0) {
        change_meta_description();
        $('#meta_description').on('change', function () {
            change_meta_description();
        });
        $('#meta_description').on('keyup', function () {
            change_meta_description();
        });
    }

    function change_meta_description() {
        var length = parseInt($('#meta_description').val().length);
        $('#meta_description_length').text(215 - length);
    }

    /**
     * -----------------------------------------------------------------------------
     * Main menu section
     * -----------------------------------------------------------------------------
     */
    if ($('#nestable_main_menu').length > 0) {
        $('#nestable_main_menu').on('click', '.dd3-content', function () {
            var icon = $(this).children('.show_menu_content').children('i').attr('class');
            if (icon == 'fa fa-chevron-down') {
                $(this).children('.show_menu_content').children('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                $(this).children('.show_menu_content').children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
            $(this).siblings('.menu_content').slideToggle();
        });

        $('#nestable_main_menu').on('keyup', '.menu_content_title', function () {
            var menu_content_title = $(this).val();
            $(this).parent('.input').parent('.menu_content').siblings('.dd3-content').children('.menu_content_title_display').text(menu_content_title);
        });
        $('#nestable_main_menu').on('change', '.menu_content_title', function () {
            var menu_content_title = $(this).val();
            $(this).parent('.input').parent('.menu_content').siblings('.dd3-content').children('.menu_content_title_display').text(menu_content_title);
        });


        $('#add_custom_menu_button').on('click', function () {

            var item_l = parseInt($('#menu_item_count').val());
            item_l++;
            var add_custom_menu_title = $('#add_custom_menu_title').val();
            var add_custom_menu_link = $('#add_custom_menu_link').val();
            var data = '<li class="dd-item li_' + item_l + '" data-id="' + item_l + '">';
            data += '<input class="id" type="hidden" name="menu_item[' + item_l + '][id]" value="' + item_l + '">';
            data += '<input class="p_id" type="hidden" name="menu_item[' + item_l + '][p_id]" value="0">';
            data += '<input class="menu_type" type="hidden" name="menu_item[' + item_l + '][menu_type]" value="cl">';
            data += '<div class="dd-handle dd3-handle">';
            data += '&nbsp;';
            data += '</div>';
            data += '<div class="dd3-content">';
            data += '<span class="menu_content_title_display">' + add_custom_menu_title + '</span>';
            data += '<span class="pull-right show_menu_content"><i class="fa fa-chevron-down"></i></span>';
            data += '</div>';
            data += '<div class="menu_content smart-form">';
            data += '<label class="input">';
            data += '<i class="icon-append fa fa-navicon" title="Add your Title here"></i>';
            data += '<input class="form-control menu_content_title title" name="menu_item[' + item_l + '][title]" type="text" placeholder="title" value="' + add_custom_menu_title + '">';
            data += '</label>';
            data += '<label class="input">';
            data += '<i class="icon-append fa fa-link" title="Add your Link here"></i>';
            data += '<input class="form-control link" type="url" name="menu_item[' + item_l + '][link]" placeholder="Url like http://nextpagetl.com" value="' + add_custom_menu_link + '">';
            data += '</label>';
            data += '<label class="input">';
            data += '<i class="icon-append" title="Add your Link Wrapper Class here">Cls</i>';
            data += '<input class="form-control cls" type="text" name="menu_item[' + item_l + '][cls]" placeholder="Add your Link Wrapper class here like home, smddtech" value="">';
            data += '</label>';
            data += '<label class="input">';
            data += '<i class="icon-append" title="Add your Link Class here">Cls</i>';
            data += '<input class="form-control link_cls" type="text" name="menu_item[' + item_l + '][link_cls]" placeholder="Add your Link class here like home, smddtech" value="">';
            data += '</label>';
            data += '<label class="input">';
            data += '<i class="icon-append" title="Add your Icon Class here">Cls</i>';
            data += '<input class="form-control icon_cls" type="text" name="menu_item[' + item_l + '][icon_cls]" placeholder="Add your Icon class here like  fa fa-plus-square" value="">';
            data += '</label>';
            data += '<a href="javascript:void(0)" class="btn btn-sm btn-danger menu_remove"><i class="fa fa-minus"></i> Remove menu</a>  <a href="javascript:void(0)" class="pull-right btn btn-sm btn-warning menu_cancel"><i class="fa fa-reply"></i> Cancel</a>';
            data += '</div>';
            data += '</li>';
            $('#menu_item_count').val(item_l);
            $('#nestable_main_menu>ol').append(data);
        });
    }
    $('#nestable_main_menu').nestable();

    $('.add_posts_menu_button').on('click', function () {
        var container = $(this).parents(".add_custom_menu").attr("id");
        var checkedProperty = $('#' + container + ' input:checkbox:checked').map(function () {
            return $(this).val();
        }).get();
        var data = '';
        if (checkedProperty.length > 0) {
            var item_l = parseInt($('#menu_item_count').val());
            for (var loop = 0; loop < checkedProperty.length; loop++) {
                item_l++;
                var row = checkedProperty[loop];
                var add_custom_menu_title = $('#page_checkbox_' + row).attr('menu_title');
                var menu_type = $('#page_checkbox_' + row).attr('menu_type');
                var add_custom_menu_link = $('#page_checkbox_' + row).val();
                data += '<li class="dd-item li_' + item_l + '" data-id="' + item_l + '">';
                data += '<input class="id" value="' + item_l + '" type="hidden" name="menu_item[' + item_l + '][id]">';
                data += '<input class="p_id" type="hidden" name="menu_item[' + item_l + '][p_id]" value="0">';
                data += '<input class="menu_type" type="hidden" name="menu_item[' + item_l + '][menu_type]" value="' + menu_type + '">';
                data += '<div class="dd-handle dd3-handle">';
                data += '&nbsp;';
                data += '</div>';
                data += '<div class="dd3-content">';
                data += '<span class="menu_content_title_display">' + add_custom_menu_title + '</span>';
                data += '<span class="pull-right show_menu_content"><i class="fa fa-chevron-down"></i></span>';
                data += '</div>';
                data += '<div class="menu_content smart-form">';
                data += '<label class="input">';
                data += '<i class="icon-append fa fa-navicon" title="Add your Title here"></i>';
                data += '<input class="form-control menu_content_title title" name="menu_item[' + item_l + '][title]" type="text" placeholder="title" value="' + add_custom_menu_title + '">';
                data += '</label>';
                data += '<label class="input">';
                data += '<i class="icon-append fa fa-link" title="Add your Link here"></i>';
                data += '<input class="form-control link" type="url" name="menu_item[' + item_l + '][link]" placeholder="Url like http://nextpagetl.com" value="' + add_custom_menu_link + '">';
                data += '</label>';
                data += '<label class="input">';
                data += '<i class="icon-append" title="Add your Link Wrapper Class here">Cls</i>';
                data += '<input class="form-control cls" type="text" name="menu_item[' + item_l + '][cls]" placeholder="Add your Link Wrapper class here like home, smddtech" value="">';
                data += '</label>';
                data += '<label class="input">';
                data += '<i class="icon-append" title="Add your Link Class here">Cls</i>';
                data += '<input class="form-control link_cls" type="text" name="menu_item[' + item_l + '][link_cls]" placeholder="Add your Link class here like home, smddtech" value="">';
                data += '</label>';
                data += '<label class="input">';
                data += '<i class="icon-append" title="Add your Icon Class here">Cls</i>';
                data += '<input class="form-control icon_cls" type="text" name="menu_item[' + item_l + '][icon_cls]" placeholder="Add your Icon class here like  fa fa-plus-square" value="">';
                data += '</label>';
                data += '<a href="javascript:void(0)" class="btn btn-sm btn-danger menu_remove"><i class="fa fa-minus"></i> Remove menu</a>  <a href="javascript:void(0)" class="pull-right btn btn-sm btn-warning menu_cancel"><i class="fa fa-reply"></i> Cancel</a>';
                data += '</div>';
                data += '</li>';
            }
        }
        $('#menu_item_count').val(item_l);
        $('#add_page_div input:checkbox:checked').map(function () {
            $(this).attr('checked', false);
        });
        $('#nestable_main_menu>ol').append(data);
    });

    $('#nestable_main_menu').on('click', '.menu_remove', function () {
        $(this).parent('.menu_content').parent('li').remove();
    });
    $('#nestable_main_menu').on('click', '.menu_cancel', function () {
        $(this).parent('.menu_content').siblings('.dd3-content').children('.show_menu_content').children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        $(this).parent('.menu_content').slideToggle();
    });


    $('#save_menu').on('click', function () {
        var save_menu = $(this);
        save_menu.attr('disabled', true);
        var loop = 0;
        $('#nestable_main_menu .id').each(function () {
            loop++;
            var id = $(this).val();
//         console.log(id + ' ' + loop);
            $(this).val(loop);
            $(this).attr('name', 'menu_item[' + loop + '][id]');
            $('.li_' + id).attr('data-id', loop);
            $('.li_' + id).children('.p_id').attr('name', 'menu_item[' + loop + '][p_id]');
            $('.li_' + id).children('.menu_type').attr('name', 'menu_item[' + loop + '][menu_type]');
            $('.li_' + id).children('.menu_content').children('.input').children('.title').attr('name', 'menu_item[' + loop + '][title]');
            $('.li_' + id).children('.menu_content').children('.input').children('.link').attr('name', 'menu_item[' + loop + '][link]');
            $('.li_' + id).children('.menu_content').children('.input').children('.cls').attr('name', 'menu_item[' + loop + '][cls]');
            $('.li_' + id).children('.menu_content').children('.input').children('.link_cls').attr('name', 'menu_item[' + loop + '][link_cls]');
            $('.li_' + id).children('.menu_content').children('.input').children('.icon_cls').attr('name', 'menu_item[' + loop + '][icon_cls]');
        });
        var loop = 0;
        $('#nestable_main_menu>.dd-list>.dd-item').each(function () {
            var $this = $(this),
                parent_id = $this.attr('data-id');
            $this.children('.p_id').val('0');
//         console.log(' main id ' + parent_id + ' new ' + $(this).children('.p_id').val());
            set_parent_id($this, parent_id);
        });

        function set_parent_id($this, parent_id) {
            if ($this.children('.dd-list').length > 0) {
                $this.children('.dd-list').children('.dd-item').each(function () {
                    var parent_id1 = $(this).attr('data-id');
                    $(this).children('.p_id').val(parent_id);
//               console.log(parent_id1 + ' set to ' + parent_id + ' new ' + $(this).children('.p_id').val());
                    set_parent_id($(this), parent_id1);
                });
            }
        }

        $('#nestable_main_menu').wrapInner('<form></form>');
        var _token = $('#table_csrf_token').val();
        var data = $('#nestable_main_menu > form').serialize()
        if (data != '') {
            data += '&' + $.param({'_token': _token});
            $.ajax({
                type: 'post',
                url: smAdminUrl + 'appearance/save_menus',
                data: data,
                success: function (response) {
                    //console.log(response);
                    if (parseInt(response) == 1) {
                        swal({
                            type: 'success',
                            icon: "success",
                            title: "Success!",
                            text: 'Menu Saved successfully!',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }

                    save_menu.attr('disabled', false);
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                },
                error: function (error) {
                    //console.log(error);
                }
            });
        } else {
            window.location.reload();
        }
        return false;
    });

    /**
     * Media library functionality
     */

    if ($('#sm_media_tab_content').length > 0) {
        $('#sm_media_tab_content').on('click', '.sm_media_file_delete', function () {
            var selector = $(this).parent('span').siblings('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            swal({
                title: "Warning?",
                text: 'Are you sure delete this file?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var _token = $('#table_csrf_token').val();
                    $.ajax({
                        type: 'post',
                        url: smAdminUrl + 'media/delete',
                        data: {_token: _token, id: id},
                        success: function (response) {
                            $('#sm_media_tab_content .sm_file_' + id).remove();
                            $('.superbox-show').slideUp();
                        },
                        error: function (error) {
                            //console.log(error);
                        }
                    });
                } else {
                    swal({
                        type: 'warning',
                        icon: "warning",
                        title: 'Delete Cancelled',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });

        });
        $('#sm_media_tab_content').on('click', '.sm_media_file_download', function () {
            var selector = $(this).parent('span').siblings('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            window.location.href = smAdminUrl + 'media/download/' + id;
        });
        $('#sm_media_tab_content').on('click', '.sm_media_file_copy', function () {
            var selector = $(this).attr("copy");
            var copyText = document.getElementById(selector);
            copyText.select();
            document.execCommand("Copy");
            swal({
                type: 'success',
                icon: 'success',
                title: 'Successfully Copied!',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        });
        $('#sm_media_tab_content').on('click', '#sm_galary_meta_save', function () {
            var selector = $(this).parent('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            var title = selector.find('#file_title').val();
            var alt = selector.find('#file_alt').val();
            var caption = selector.find('#file_caption').val();
            var description = selector.find('#file_description').val();
            var _token = $('#table_csrf_token').val();
            $.ajax({
                type: 'post',
                url: smAdminUrl + 'media/update',
                data: {_token: _token, id: id, title: title, alt: alt, caption: caption, description: description},
                success: function (response) {
                    swal({
                        type: 'success',
                        icon: "success",
                        title: "Success!",
                        text: 'File Meta Saved successfully!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                },
                error: function (error) {
                    //console.log(error);
                }
            });

        });
        $("#sm_media_load_more").on('click', function (e, $affected) {
            var $this = $(this);
            var btnHtml = $this.html();
            $this.html('<i class="fa fa-refresh fa-spin"></i> Loading..');

            var loaded = $this.data("loaded");
            var need_to_load = $this.data("need_to_load");
            $.ajax({
                type: 'get',
                url: smAdminUrl + 'media/' + loaded,
                success: function (response) {
                    var data = JSON.parse(response);
                    loaded = data.load;
                    $('.superbox').find('.superbox-float').before(data.media);
                    loaded = $this.data("loaded", loaded);
                    $this.html(btnHtml);
                    // console.log("need_to_load = "+need_to_load+" data.count ="+data.count);
                    if (need_to_load > data.count) {
                        $this.fadeOut();
                    }
                }
            });

        });

    }
    if ($('#sm_media_modal').length > 0) {
        $('#media_library_tab .superbox').on('click', '.superbox-list', function () {
            var is_multiple = parseInt($('#media_insert').attr('is_multiple'));
            if (is_multiple == 0) {
                $('#media_library_tab .superbox').find('.sm_media_selected').removeClass('sm_media_selected');
                $(this).addClass('sm_media_selected');
            } else {
                if ($(this).hasClass('sm_media_selected')) {
                    $(this).removeClass('sm_media_selected');
                } else {
                    $(this).addClass('sm_media_selected');
                }
            }
        });
        $('body').on('click', '.sm_media_modal_show', function () {
            var input_holder = $(this).attr('input_holder');
            var img_holder = $(this).attr('img_holder');
            var is_multiple = parseInt($(this).attr('is_multiple'));
            $('#media_insert').attr('input_holder', input_holder);
            $('#media_insert').attr('img_holder', img_holder);
            $('#media_insert').attr('is_multiple', is_multiple);
            if ($(this).attr('media_width')) {
                $('#media_insert').attr('media_width', $(this).attr('media_width'));
            }
            if ($(this).attr('img_width')) {
                $('#media_insert').attr('img_width', $(this).attr('img_width'));
            }
            $('#sm_media_modal').modal('show');
        });


        $('#media_insert').on('click', function () {
            var input_holder = $(this).attr('input_holder');
            var img_holder = $(this).attr('img_holder');
            var is_multiple = parseInt($(this).attr('is_multiple'));
            var media_width = parseInt($(this).attr('media_width'));
            var img_width = parseInt($(this).attr('img_width'));
            if (is_multiple === 0) {
                var selector = $('#media_library_tab .superbox').find('.sm_media_selected').find('img');
                var id = selector.attr('img_id');
                var img_slug = selector.attr('img_slug');
                var src = get_the_file_width(selector.attr('src'), media_width);

                $('#' + input_holder).val(img_slug);
//            $('#' + img_holder + ' .media_img').attr('src', src);
                $('#' + img_holder).html('<img class="media_img" src="' + src + '" width="' + img_width + 'px" />');
            } else {
                var id = '', images = '', slug = '';
                $('#media_library_tab .superbox .sm_media_selected').each(function (index) {
                    var selector = $(this).find('img');
                    if (index > 0) {
                        id += ',';
                        slug += ',';
                    }
                    var img_id = selector.attr('img_id');
                    var img_slug = selector.attr('img_slug');
                    id += img_id;
                    slug += img_slug;
                    var src = get_the_file_width(selector.attr('src'), media_width);
                    images += '<span class="gl_img"><img class="" src="' + src + '" width="' + img_width + 'px" /><span class="displayNone remove"><i class="fa fa-times-circle remove_img" data-img="' + img_slug + '"  data-input_holder="' + input_holder + '"></i></span></span>';
                });
                var old_ids = $('#' + input_holder).val();
                //console.log('old=' + old_ids);
                if (old_ids.trim() == '') {
                    $('#' + input_holder).val(slug);
                } else {
                    $('#' + input_holder).val(old_ids + ',' + slug);
                }

                $('#' + img_holder).html($('#' + img_holder).html() + images);
            }
            $('#sm_media_modal').modal('hide');
        });
    }

    /**
     * Add new Functionality
     */

    if ($('.add_new_btn').length > 0) {
        $('.add_new_btn').on('click', function () {
            $(this).parent('.add_new_btn_div').siblings('.add_new_content_div').slideToggle();
            return false;
        });
    }
    if ($('.toggle_field').length > 0) {
        $('.toggle_field').on('click', function () {
            var data_toggle = $(this).attr('data_toggle');
            if ($(this).is(':checked')) {
                $("." + data_toggle).slideDown();
            } else {
                $("." + data_toggle).slideUp();
            }
        });
    }
    if ($('#first_ph, #gallery_first_ph, #order_mail').length > 0) {
        $('#first_ph, #gallery_first_ph, #order_mail').on('click', '.remove_img', function () {
            var img_slug = $(this).data('img');
            var input_holder = $(this).data('input_holder');
            if (input_holder === undefined) {
                input_holder = 'image';
            }
            var image = $('#' + input_holder).val();
            if (image.indexOf(',' + img_slug) != '-1') {
                image = image.replace(',' + img_slug, '');
            } else if (image.indexOf(img_slug + ',') != '-1') {
                image = image.replace(img_slug + ',', '');
            } else {
                image = image.replace(img_slug, '');
            }
            $('#' + input_holder).val(image);
            $(this).parent('.remove').parent('.gl_img').remove();
        });
    }

    if ($('.smto_gallery').length > 0) {
        $('.smto_gallery').on('click', '.remove_img', function () {
            var img_slug = $(this).data('img');
            var input_holder = $(this).data('input_holder');
            if (input_holder === undefined) {
                input_holder = 'image';
            }
            var image = $('#' + input_holder).val();
            if (image.indexOf(',' + img_slug) != '-1') {
                image = image.replace(',' + img_slug, '');
            } else if (image.indexOf(img_slug + ',') != '-1') {
                image = image.replace(img_slug + ',', '');
            } else {
                image = image.replace(img_slug, '');
            }
            $('#' + input_holder).val(image);
            $(this).parent('.remove').parent('.gl_img').remove();
        });
    }
    if ($(".sm_theme_option_move_to_top").length > 0) {
        $(".sm_theme_option_move_to_top").on('click', function () {
            $('html, body').animate({scrollTop: 0}, 'slow');
        });
    }

    /**
     * If cart page qty changed then this function call on change and keyup method
     */
    function cart_qty_changed($this) {
        var id = parseInt($this.data('id')),
            qty = parseInt($this.val()),
            price = parseFloat($('.cart_price_' + id).text()),
            cart_subtotal = parseFloat($('.cart_subtotal_' + id).text()),
            order_total = parseFloat($('.order_total').text()),
            paid = parseFloat($('#paid').text());
        if (qty.length < 1 || isNaN(qty)) {
            $this.val('1');
            qty = 1;
        }
        var new_cart_subtotal = qty * price;

        if ($('.cart_product_price').length > 0) {
            var cart_product_price = parseFloat($('.cart_product_price').text());
            cart_product_price = cart_product_price - cart_subtotal + new_cart_subtotal;
            $('.cart_product_price').text(cart_product_price.toFixed(2));
        }

        order_total = order_total - cart_subtotal + new_cart_subtotal;
        var need_to_pay = order_total - paid;
        $('#need_to_pay').val(need_to_pay);
        $('.cart_subtotal_' + id).text(new_cart_subtotal.toFixed(2));
        $('.order_total').text(order_total.toFixed(2));
        $('.coupon_money_input').data('order_total', order_total);
    }

    function cart_coupon_discount($this) {
        var less = parseInt($this.val()),
            order_total = parseFloat($($this).data('order_total')),
            paid = parseFloat($('#paid').text());

        order_total = order_total - less;
        var need_to_pay = order_total - paid;
        $('#need_to_pay').val(need_to_pay);
        $('.order_total').text(order_total.toFixed(2));
    }

    function cart_extra_charge($this) {
        var charge = parseInt($this.val()),
            order_total = parseFloat($('.coupon_money_input').data('order_total')),
            paid = parseFloat($('#paid').text());

        order_total = order_total + charge;
        var need_to_pay = order_total - paid;
        $('#need_to_pay').val(need_to_pay);
        $('.order_total').text(order_total.toFixed(2));
    }

    if ($('#cart_table').length > 0) {
        $('#cart_table').on('change', '.cart_qty', function () {
            cart_qty_changed($(this));
        });
        $('#cart_table').on('keyup', '.cart_qty', function () {
            cart_qty_changed($(this));
        });
        $('#cart_table').on('change', '.coupon_money_input', function () {
            cart_coupon_discount($(this));
        });
        $('#cart_table').on('keyup', '.coupon_money_input', function () {
            cart_coupon_discount($(this));
        });
        $('#cart_table').on('change', '.extra_charge', function () {
            cart_extra_charge($(this));
        });
        $('#cart_table').on('keyup', '.extra_charge', function () {
            cart_extra_charge($(this));
        });
        $('#cart_table').on('click', '.cart_delete_row', function () {
            var id = $(this).data('id'),
                cart_subtotal = parseFloat($('.cart_subtotal_' + id).text()),
                cart_product_price = parseFloat($('.cart_product_price').text()),
                order_total = parseFloat($('.order_total').text());
            cart_product_price -= cart_subtotal;
            order_total -= cart_subtotal;

            $('.cart_product_price').text(cart_product_price);
            $('.order_total').text(order_total.toFixed(2));
            $('.coupon_money_input').data('order_total', order_total.toFixed(2));
            $('#cart_row_' + id).remove();
        });
        $('#edit_apply_coupon').on('click', function () {
            var coupon_code = $('#edit_coupon_code').val();
            if (coupon_code.length > 1) {
                $(this).html('<i class="fa fa-refresh fa-spin"></i> Applying........');
                var coupon_money = 10;
                $('.coupon_money_input').val(coupon_money);
                cart_coupon_discount($('.coupon_money_input'));
                $(this).html('<i class="fa fa-plus"></i> APPLY COUPON');
            }
            return false;
        });
    }


    function check_feild(feild, count) {
        var error = 1, feild_value = $('#' + feild).val();

        if (feild_value.length > count) {
            $('#' + feild).removeClass('warning');
        } else {
            error = 0;
            $('#' + feild).addClass('warning');
        }
//      console.log(feild + ' ' + feild_value + ' ' + count + ' ' + error);
        return error;
    }

    /**
     * Comment
     */
    function cart_date_expire(feild) {
        var error = 1, feild_value = $('#' + feild).val();
        var date = /^[0-9]{4}[-]{1}[0-9]{2}$/;
        if (date.test(feild_value)) {
            error = 1;
            $('#' + feild).removeClass('warning');
        } else {
            error = 0;
            $('#' + feild).addClass('warning');
        }
//      console.log(feild + ' ' + feild_value + ' ' + error);
        return error;
    }

    function credit_card(feild, type) {
        var error = 1, feild_value = $('#' + feild).val();
        var text = feild_value.replace(/-/g, "");
        var text = text.replace(/ /g, "");

        var card = /^[0-9]{16}$/;
        if (type == 'visa') {
            var card = /^[4]{1}[0-9]{15}$/;
        } else if (type == 'mastercard') {
            var card = /^[5]{1}[0-9]{15}$/;
        }

        if (card.test(text)) {
            error = 1;
            $('#' + feild).removeClass('warning');
        } else {
            error = 0;
            $('#' + feild).addClass('warning');
        }
//      console.log(feild + ' ' + feild_value + ' ' + text + ' ' + type + ' ' + error);
        return error;
    }

    if ($('#edit_order_form').length > 0) {
        $('.payment_method').on('change', function () {
            var payment_method = $(this).val();
            $('.payment_div').slideUp();
            if ($("." + payment_method).length > 0) {
                $("." + payment_method).slideDown();
            }
        });

        $('#edit_order_submit').on('click', function () {
            var error = 1;
            var payment_method = $('.payment_method').val();
            var need_to_pay = parseFloat($('#need_to_pay').val());
            if (need_to_pay != 0 && payment_method == 'visa') {
                error *= credit_card('visa_number', 'visa');
                error *= cart_date_expire('visa_expire');
                error *= check_feild('visa_cvv2', 1);
                error *= check_feild('visa_first_neme', 1);
                error *= check_feild('visa_last_neme', 1);

            } else if (need_to_pay != 0 && payment_method == 'mastercard') {
                error *= credit_card('mc_number', 'mastercard');
                error *= cart_date_expire('mc_expire');
                error *= check_feild('mc_cvv2', 1);
                error *= check_feild('mc_first_neme', 1);
                error *= check_feild('mc_last_neme', 1);
            }

            //console.log(error);
            if (error === 1) {
                $('#edit_order_form').submit();
            }
            return false;
        });
    }
    $('#datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss'
    });
    if ($('.datepicker').length > 0) {
        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-60:+0",
            dateFormat: "yy-mm-dd"
        });
    }
    if ($('.month_year_calender').length > 0) {
        $(".month_year_calender").datepicker({
            dateFormat: 'mm-yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function (dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
            }
        });

        $(".month_year_calender").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
    }

    if ($('#search_user_by_name').length > 0) {
        $('#search_user_by_name').on('keyup', function () {
            var $this = $(this), text = $this.val(), _token = $('#table_csrf_token').val();
            if (text.length > 2) {
                $('.user_search_loading').fadeIn();
                $.ajax({
                    url: smAdminUrl + "companies/search_users",
                    data: {text: text, _token: _token},
                    type: "post",
                    success: function (response) {
                        $('.user_suggestion').find("ul").html(response).fadeIn();
                        $('.user_suggestion').fadeIn();
                        $('.user_search_loading').fadeOut();
                    }
                });
            }
        });

        $('.user_suggestion').on('click', '.choose_user', function () {
            var user_id = $(this).data('user_id');
            var text = $(this).text();
            var _token = $('#table_csrf_token').val();
            $('#user_id').val(user_id);
            $('#search_user_by_name').val(text);
            $('.user_suggestion').slideUp();

            $.ajax({
                url: smAdminUrl + "companies/search_company",
                data: {user_id: user_id, _token: _token},
                type: "post",
                success: function (response) {
                    if (response.trim() != '') {
                        $('.company_suggestion').html(response).fadeIn();
                    }
                }
            });

        });
    }
    if ($('#search_company_by_name').length > 0) {
        $('#search_company_by_name').on('keyup', function () {
            var $this = $(this), text = $this.val(), _token = $('#table_csrf_token').val();
            if (text.length > 2) {
                $('.company_search_loading').fadeIn();
                $.ajax({
                    url: smAdminUrl + "projects/search_companies",
                    data: {text: text, _token: _token},
                    type: "post",
                    success: function (response) {
                        $('.company_suggestion').find("ul").html(response).fadeIn();
                        $('.company_suggestion').fadeIn();
                        $('.company_search_loading').fadeOut();
                    }
                });
            }
        });

        $('.company_suggestion').on('click', '.choose_company', function () {
            var company_id = $(this).data('company_id');
            var text = $(this).text();
            $('#users_company_id').val(company_id);
            $('#search_company_by_name').val(text);
            $('.company_suggestion').slideUp();
        });
    }


    if ($('#search_private_user_by_name').length > 0) {
        $('#search_private_user_by_name').on('keyup', function () {
            var $this = $(this), text = $this.val(), _token = $('#table_csrf_token').val();
            if (text.length > 2) {
                $('.user_search_loading').fadeIn();
                $.ajax({
                    url: smAdminUrl + "projects/search_users",
                    data: {text: text, _token: _token},
                    type: "post",
                    success: function (response) {
                        $('.user_suggestion').find("ul").html(response).fadeIn();
                        $('.user_suggestion').fadeIn();
                        $('.user_search_loading').fadeOut();
                    }
                });
            }
        });

        $('.user_suggestion').on('click', '.choose_user', function () {
            var user_id = $(this).data('user_id');
            var text = $(this).text();
            var selected_users = [];
            if ($('#users option[value=' + user_id + ']').length < 1) {
                var option = '<option value="' + user_id + '">' + text + '</option>';
                $('#users').append(option);
            }
            $('#users :selected').each(function (i, selected) {
                selected_users.push($(selected).val());
            });
            selected_users.push(user_id + "");
            $('#search_private_user_by_name').val("");
            $('#users').val(selected_users);
            $('#users').trigger("change");
            $('.user_suggestion').slideUp();
        });
    }

    if ($('.slider_btn_row').length > 0) {
        $(".slider_btn_row").on("click", ".add_more_btn", function () {
            var html = $(this).parent(".col-md-1").parent(".row").clone();
            html.find(".col-md-1").html('<a class="btn btn-danger slider_btn remove_btn"><i class="fa fa-times"></i></a>');
            $(".slider_btn_row").append(html);
        });
        $(".slider_btn_row").on("click", ".remove_btn", function () {
            $(this).parent(".col-md-1").parent(".row").remove();
        });
    }
    $(".sortable").sortable();
    $(".sortable").disableSelection();

    /* nptl theme option js start */
    if ($(".smThemeAddablePopUp").length > 0) {

        $(".smThemeOptionPopupModal .col-md-7").each(function () {
            $(this).addClass("col-md-12").removeClass("col-md-7");
        });
        $(".smThemeOptionPopupModal .col-md-9").each(function () {
            $(this).addClass("col-md-10").removeClass("col-md-9");
        });
        $(".smThemeAddablePopUp").on("click", ".sm_theme_remove_popup_item", function () {
            //console.log("sm_theme_edit_popup_item clicked");
            $(this).parent("li").remove();
        });
        $(".smThemeAddablePopUp").on("click", ".add_more_popup", function () {
            var info = $(this).attr('data-info');
            var modal = $(this).data("target");
            var formattedvalue = $(this).attr('data-formattedvalue');
            // console.log("info = " + info + " modal = " + modal);
            var saveId = 'save_sm_theme_popup';
            if ($("#" + modal).find(".update_sm_theme_popup").length) {
                saveId = 'update_sm_theme_popup';
            }
            $("#" + modal).find('.sortable').html('');
            $("#" + modal + ' .sm_theme_popup_field').each(function () {
                var type = $(this).attr('type');
                if (type !== 'radio' && type !== 'checkbox') {
                    $(this).val('');
                    $(this).removeAttr('name');
                }
            });
            // $("#" + modal).find('.sm_theme_popup_field').removeAttr('name');
            $("#" + modal).find("." + saveId).attr('data-formattedvalue', formattedvalue);
            $("#" + modal).find("." + saveId).attr('data-value', "");
            $("#" + modal).find("." + saveId).attr('data-info', info);
            if (saveId == 'update_sm_theme_popup') {
                $("#" + modal).find(".update_sm_theme_popup").addClass("save_sm_theme_popup").removeClass("update_sm_theme_popup");
            }
            $("#" + modal).modal("show");
            return false;
        });
        $(".smThemeAddablePopUp").on("click", ".sm_theme_edit_popup_item", function () {
            //console.log("sm_theme_edit_popup_item clicked");
            var info = $(this).attr('data-info');
            var mainid = $(this).data("mainid");
            var children = $(this).data("children");
            var modal = mainid + "_Modal";
            var value = $(this).siblings('.sm_theme_popup_field').val();
            value = typeof value == 'string' ? value : JSON.stringify(value);
            var formattedvalue = $(this).siblings('.sm_theme_popup_field').attr('data-formattedvalue');
            formattedvalue = typeof formattedvalue == 'string' ? formattedvalue : JSON.stringify(formattedvalue);
            // console.log("mainId = " + mainid + " modal = " + modal + " info = " + info + " children= " + children);
            // console.log("value = " + value + " formattedValue= " + formattedvalue);
            // console.log(formattedvalue);
            remove_sm_theme_option_active_sortable(children);
            $(this).parent(".ui-state-default").addClass("sm_theme_option_active_sortable" + children);
            $("#" + modal).find('.sortable').html('');
            $("#" + modal).find(".save_sm_theme_popup").attr('data-value', value);
            $("#" + modal).find(".update_sm_theme_popup").attr('data-value', value);
            $("#" + modal).find(".save_sm_theme_popup").attr('data-formattedvalue', formattedvalue);
            $("#" + modal).find(".update_sm_theme_popup").attr('data-formattedvalue', formattedvalue);

            value = typeof value === 'string' ? JSON.parse(value) : value;
            // console.log(value);
            formattedvalue = typeof formattedvalue == 'string' ? JSON.parse(formattedvalue) : formattedvalue;
            // console.table(formattedvalue);
            for (var index in formattedvalue) {
                // for (var infoId in formattedvalue[index]) {
                var single = formattedvalue[index];
                // var single = formattedvalue[index][infoId];
                // console.log("loop index "+index+" single = "+JSON.stringify(single));
                var id = single["id"];
                var type = single["type"];
                var val = single["value"];
                var name = single["name"];
                var selector = single["selector"];


                // console.log("modal = " + modal + " type = " + type + " id = " + id + " val = " + val + " name = " + name + " selector = " + selector);

                if (type !== undefined && type.length > 0) {
                    if (type === "upload") {
                        mrksGetImageResponse(modal, selector, val);
                    } else if (type === 'radio' || type === 'checkbox') {
                        $("#" + modal).find(".sm_theme_popup_" + id).each(function () {
                            var currentVal = $(this).val();
                            // console.log("val = "+val+" currentVal = "+currentVal);
                            if (val === currentVal) {
                                // console.log("ok");
                                $(this).prop("checked", true);
                            } else {
                                $(this).prop("checked", false);
                            }
                        });
                    } else if (type === 'addable-popup') {
                        // console.log('addable-popup');
                        var itemTemplate = $('#' + mainid + "_" + id + '__add_more').data('template');
                        // console.log("id = " + id + " mainid = " + mainid + " itemTemplate = " + itemTemplate + " value = " + value);
                        // console.table(val);
                        var html = '';
                        if (val != '') {
                            for (var pIndes in val) {
                                // console.log("val "+JSON.stringify(val));
                                var jsonformattedvalue = val[pIndes];
                                var newValue = typeof value == 'string' ? JSON.parse(value) : value;
                                var jsonvalue = newValue[id][pIndes];
                                // console.log("itemTemplate = " + itemTemplate + " jsonvalue = " + jsonvalue);

                                jsonvalue = typeof jsonvalue == 'string' ? JSON.parse(jsonvalue) : jsonvalue;

                                var title = jsonvalue[itemTemplate] || "title";
                                html += '<li class="ui-state-default">\n' +
                                    '<i class="fa fa-sort"></i>';

                                var jsonvalue = typeof jsonvalue === 'string' ? jsonvalue : JSON.stringify(jsonvalue);
                                var jsonformattedvalue = typeof jsonformattedvalue === 'string' ? jsonformattedvalue : JSON.stringify(jsonformattedvalue);

                                html += generateInput('<input type="hidden" ' +
                                    'value="" ' +
                                    'data-formattedvalue="" ' +
                                    'class="sm_theme_popup_field sm_theme_popup_' + id + ' ' + mainid + "_" + id + '_value" ' +
                                    'data-selector="' + selector + '" ' +
                                    'data-info="' + id + '" ' +
                                    '>', jsonvalue, jsonformattedvalue);


                                html += '<span class="sm_theme_popup_title"> ' + title + '</span>';
                                html += '<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">\n' +
                                    '<i class="fa fa-times"></i>\n' +
                                    '</a>\n' +
                                    '<a href="javascript:void(0)" class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"\n' +
                                    ' data-children="2"\n' +
                                    ' data-template="' + id + '"\n' +
                                    ' data-info="' + id + '"\n' +
                                    ' data-mainid="' + mainid + "_" + id + '_">\n' +
                                    '<i class="fa fa-pencil"></i>\n' +
                                    '</a>\n' +
                                    '</li>';
                            }
                        }
                        $("#" + modal).find('.sortable').html(html);

                    } else {
                        $("#" + modal).find(".sm_theme_popup_" + id).val(val);
                    }
                } else {
                    $("#" + modal).find(".sm_theme_popup_" + id).val(val);
                }
                // }
            }

            $("#" + modal).find(".save_sm_theme_popup").attr('data-info', info);
            $("#" + modal).find(".update_sm_theme_popup").attr('data-info', info);
            $("#" + modal).find(".save_sm_theme_popup").addClass("update_sm_theme_popup").removeClass("save_sm_theme_popup");
            $("#" + modal).modal("show");
            return false;
        });

        $(".smThemeAddablePopUp").on("click", ".update_sm_theme_popup", function () {
            // console.log("update_sm_theme_popup");
            var template = $(this).data("template");
            var info = $(this).data("info");
            var children = $(this).data("children");
            var modal = $(this).data("insert");
            var formattedvalue = $(this).data("formattedvalue");
            var value = $(this).data("value");

            value = typeof value == 'string' ? JSON.parse(value) : value;
            formattedvalue = typeof formattedvalue == 'string' ? JSON.parse(formattedvalue) : formattedvalue;
            var pcReturn = processPopUpInfo(modal, formattedvalue, template, children, info);

            var jsonvalue = typeof pcReturn.value === 'string' ? pcReturn.value : JSON.stringify(pcReturn.value);
            var jsonformattedvalue = typeof pcReturn.formattedvalue === 'string' ? pcReturn.formattedvalue : JSON.stringify(pcReturn.formattedvalue);
            $('.sm_theme_option_active_sortable' + children).find(".sm_theme_popup_field").val(jsonvalue);
            $('.sm_theme_option_active_sortable' + children).find(".sm_theme_popup_field").attr('data-formattedvalue', jsonformattedvalue);
            $(this).addClass("save_sm_theme_popup").removeClass("update_sm_theme_popup");
            remove_sm_theme_option_active_sortable(children);
            $("#" + modal + "_Modal").modal("hide");
            return false;
        });


        $(".smThemeAddablePopUp").on("click", ".save_sm_theme_popup", function () {
            // console.log("save_sm_theme_popup");
            var id = $(this).data("insert");
            var info = $(this).attr("data-info");
            var children = $(this).data("children");
            var inputname = $(this).data("inputname");
            var template = $(this).data("template");
            var iteration = $(this).data("formattedvalue");
            var count = parseInt($("#" + id + "_count").val());
            var title = "Title";
            // console.log(iteration);
            // console.log("template " + template + " save_sm_theme_popup " + id + " info =" + info);

            var html = '<li class="ui-state-default">\n' +
                '                            <i class="fa fa-sort"></i>';
            var value = {}, formattedvalue = [], parentname;


            // for (var index in iteration) {
            //     var single = iteration[index];
            //     console.log("\n\nsingle =" + JSON.stringify(single));
            //     if (single.type != 'addable-popup') {
            //
            //         var $this = $("#" + id + "_Modal").find('.sm_theme_popup_' + single.id);
            //         parentname = single.name;
            //         var name = $this.data("name");
            //         var selector = $this.data("selector");
            //         var val = $this.val();
            //         // $(this).val("");
            //         if (template === single.id) {
            //             title = val;
            //         }
            //         value[single.id] = val;
            //         var newformattedvalue = {}, newformattedvalue2 = {};
            //         newformattedvalue.id = single.id;
            //         newformattedvalue.type = single.type;
            //         newformattedvalue.name = name;
            //         newformattedvalue.value = val;
            //         newformattedvalue.selector = selector;
            //         newformattedvalue2[single.id] = newformattedvalue;
            //
            //         formattedvalue.push(newformattedvalue2);
            //
            //         // console.log("in loop info = "+info+" type = "+single.type+" name = "+name+" val= "+val+" selector = "+selector+" newformattedvalue2 ="+JSON.stringify(newformattedvalue2));
            //         console.log("in loop value =" + JSON.stringify(value));
            //         console.log("in loop newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
            //     } else {
            //         var newInput = [];
            //         var newFormatttedValue = [];
            //         $("#" + id + "_Modal .sm_theme_popup_" + single.id).each(function () {
            //             var singleInfo = $(this).val();
            //             var singleFV = $(this).attr('data-formattedvalue');
            //             newInput.push(singleInfo);
            //             newFormatttedValue.push(singleFV);
            //         });
            //
            //
            //         parentname = single.name;
            //         var name = single.name;
            //         var selector = single.selector + "__" + single.id + "_";
            //         var val = newInput;
            //         // $(this).val("");
            //         if (template === single.id) {
            //             title = val;
            //         }
            //         value[single.id] = val;
            //         var newformattedvalue = {}, newformattedvalue2 = {};
            //         newformattedvalue.id = single.id;
            //         newformattedvalue.type = single.type;
            //         newformattedvalue.name = name;
            //         newformattedvalue.value = newFormatttedValue;
            //         newformattedvalue.selector = selector;
            //         newformattedvalue2[single.id] = newformattedvalue;
            //
            //         formattedvalue.push(newformattedvalue2);
            //
            //         // console.log("in loop info = "+info+" type = "+single.type+" name = "+name+" val= "+val+" selector = "+selector+" newformattedvalue2 ="+JSON.stringify(newformattedvalue2));
            //         console.log("in loop else single =" + JSON.stringify(value));
            //         console.log("in loop else newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
            //     }
            //
            // }

            var pcReturn = processPopUpInfo(id, iteration, template, children);

            var jsonvalue = typeof pcReturn.value === 'string' ? pcReturn.value : JSON.stringify(pcReturn.value);
            var jsonformattedvalue = typeof pcReturn.formattedvalue === 'string' ? pcReturn.formattedvalue : JSON.stringify(pcReturn.formattedvalue);
            // console.log('\n\njsonvalue ' + jsonvalue);
            // console.log('jsonformattedvalue ' + jsonformattedvalue);
            var nameFiled = '';
            if (children == 1) {
                nameFiled = 'name="' + inputname + '"';
            }
            // console.log("info = "+info);
            html += generateInput('<input type="hidden" ' +
                'value="" ' +
                'data-formattedvalue="" ' +
                'class="sm_theme_popup_field sm_theme_popup_' + info + ' ' + id + 'value" ' +
                'data-selector="' + id + '" ' +
                'data-info="' + info + '" ' +
                nameFiled + '>', jsonvalue, jsonformattedvalue);


            html += '<span class="sm_theme_popup_title"> ' + pcReturn.title + '</span>';
            html += '<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">\n' +
                '<i class="fa fa-times"></i>\n' +
                '</a>\n' +
                '<a href="javascript:void(0)" class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"\n' +
                ' data-children="' + children + '"\n' +
                ' data-template="' + template + '"\n' +
                ' data-info="' + info + '"\n' +
                ' data-mainid="' + id + '">\n' +
                '<i class="fa fa-pencil"></i>\n' +
                '</a>\n' +
                '                        </li>';
            $("#" + id + "_count").val(++count);
            $("#" + id).find('.sortable').append(html);
            $("#" + id + "_Modal").modal("hide");
            return false;
        });


        // $(".smThemeAddablePopUp").on("click", ".sm_theme_edit_popup_item", function () {
        //
        //     var modal = $(this).data("modal");
        //     remove_sm_theme_option_active_sortable();
        //     $(this).parent(".ui-state-default").addClass("sm_theme_option_active_sortable");
        //
        //     $(this).siblings(".sm_theme_popup_input").each(function () {
        //         var val = $(this).val();
        //         var id = $(this).data("id");
        //         var type = $(this).data("type");
        //         // console.log("modal = " + modal + " type = " + type + " id = " + id + " val = " + val);
        //
        //         if (type !== undefined && type.length > 0) {
        //             if (type === "upload") {
        //                 var _token = $('#table_csrf_token').val();
        //                 $.ajax({
        //                     url: smAdminUrl + "get_image_src",
        //                     data: {is_upload: 1, ids: val, _token: _token},
        //                     type: 'post',
        //                     success: function (response) {
        //                         $("#" + modal).find(".smthemesingleimagediv#" + id + "_ph").html(response);
        //                     }
        //                 });
        //             } else if (type === 'radio') {
        //                 $("#" + modal).find(".sm_theme_popup_" + id).each(function () {
        //                     var currentVal = $(this).val();
        //                     // console.log("val = "+val+" currentVal = "+currentVal);
        //                     if (val === currentVal) {
        //                         // console.log("ok");
        //                         $(this).prop("checked", true)
        //                     }
        //                 });
        //             } else {
        //                 $("#" + modal).find(".sm_theme_popup_" + id).val(val);
        //             }
        //         } else {
        //             $("#" + modal).find(".sm_theme_popup_" + id).val(val);
        //         }
        //     });
        //     $("#" + modal).find(".save_sm_theme_popup").addClass("update_sm_theme_popup").removeClass("save_sm_theme_popup");
        //     $("#" + modal).modal("show");
        // });


        // $(".smThemeAddablePopUp").on("click", ".update_sm_theme_popup", function () {
        //     // console.log("update_sm_theme_popup");
        //     var template = $(this).data("template");
        //     var modal = $(this).data("insert");
        //     $("#" + modal + "_Modal .sm_theme_popup_field").each(function () {
        //         var info = $(this).data("info");
        //         var inputType = $(this).attr("type");
        //         if (inputType === 'radio') {
        //             var val = $("#" + modal + "_Modal .sm_theme_popup_" + info + ":checked").val();
        //             // console.log("radio info=" + info + " val=" + val + " type = " + inputType);
        //         } else {
        //             var val = $(this).val();
        //             // console.log("info=" + info + " val=" + val + " type = " + inputType);
        //         }
        //         if (template == info) {
        //             $(".sm_theme_option_active_sortable").find(".sm_theme_popup_title").text(val);
        //         }
        //
        //         $(".sm_theme_option_active_sortable").find(".sm_theme_popup_input_" + info).val(val);
        //     });
        //     $(this).addClass("save_sm_theme_popup").removeClass("update_sm_theme_popup");
        //     remove_sm_theme_option_active_sortable();
        //     $("#" + modal + "_Modal").modal("hide");
        //
        // });


        // $(".smThemeAddablePopUp").on("click", ".save_sm_theme_popup", function () {
        //     // console.log("save_sm_theme_popup");
        //     var id = $(this).data("insert");
        //     var template = $(this).data("template");
        //     var count = parseInt($("#" + id + "_count").val());
        //     var title = "Title";
        //
        //     console.log("template " + template + " save_sm_theme_popup " + id);
        //
        //     var html = '<li class="ui-state-default">\n' +
        //         '                            <i class="fa fa-sort"></i>';
        //     $("#" + id + "_Modal .sm_theme_popup_field").each(function () {
        //         var info = $(this).data("info");
        //         var basename = $(this).data("name");
        //         var val = $(this).val();
        //         $(this).val("");
        //         if (template == info) {
        //             title = val;
        //         }
        //         html += '<input class="sm_theme_popup_input sm_theme_popup_input_' + info + '" ' +
        //             'type="hidden" value="' + val + '" data-id="' + info + '" ' +
        //             'data-basename="' + basename + '" name=""> ';
        //     });
        //     html += '<span class="sm_theme_popup_title">' + title + '</span>';
        //     html += '<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">\n' +
        //         '<i class="fa fa-times"></i>\n' +
        //         '</a>\n' +
        //         '<a href="javascript:void(0)" class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"\n' +
        //         ' data-modal="' + id + '_Modal">\n' +
        //         '<i class="fa fa-pencil"></i>\n' +
        //         '</a>\n' +
        //         '                        </li>';
        //     console.log(html);
        //     $("#" + id + "_count").val(++count);
        //     $("#" + id).find('.sortable').append(html);
        //     $("#" + id + "_Modal").modal("hide");
        // });

        $(".sm_theme_option_save").on("click", function () {
            var $this = $(this), html = $this.html();
            $this.html('<i class="fa fa-refresh fa-spin"></i> Saving...');
            $this.attr("disabled", true);
            sorting_position_change();
            $("#smThemeOptionPopupModal").remove();
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            // $("#sm_theme_option_form").submit();
            var formData = $("#sm_theme_option_form").serialize();
            var action = $("#sm_theme_option_form").attr('action');
            $.ajax({
                url: action,
                data: formData,
                type: 'post',
                success: function (response) {
                    $this.removeAttr("disabled");
                    $this.html(html);
                    swal({
                        type: 'success',
                        icon: "success",
                        title: response,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
            return false;
        });


    }


    function processPopUpInfo(id, iteration, template, children, info) {
        var title = "Title";
        // console.log("id "+id);
        // console.log("iteration");
        // console.log(iteration);
        // console.log("template "+template);
        // console.log("children " +children);
        var value = {}, formattedvalue = {}, parentname;
        for (var index in iteration) {
            // console.log("index "+index);
            var single = iteration[index];
            var newformattedvalue = {}, newformattedvalue2 = {};

            if (single.type !== 'addable-popup') {
                parentname = single.name;
                if (single.type == 'radio') {
                    var $this = $("#" + id + "_Modal").find('.sm_theme_popup_' + single.id + ':checked');
                } else {
                    var $this = $("#" + id + "_Modal").find('.sm_theme_popup_' + single.id);
                }
                var name = $this.data("name");
                var selector = $this.data("selector");
                var val = $this.val();
                if (single.type === 'checkbox') {
                    if ($this.is(':checked')) {
                        val = $this.val();
                    } else {
                        val = "";
                    }
                }
                // console.log("single.type " + single.type + " single.id " + single.id + " val " + val);
                // $(this).val("");
                if (template === single.id) {
                    title = val;
                    $(".sm_theme_option_active_sortable" + children).find(".sm_theme_popup_title").text(val);
                }
                value[single.id] = val;
                newformattedvalue.id = single.id;
                newformattedvalue.type = single.type;
                newformattedvalue.name = name;
                newformattedvalue.value = val;
                newformattedvalue.selector = selector;
                // newformattedvalue2[single.id] = newformattedvalue;

                formattedvalue[single.id] = (newformattedvalue);

                // console.log("in loop info = "+info+" type = "+single.type+" name = "+name+" val= "+val+" selector = "+selector+" newformattedvalue2 ="+JSON.stringify(newformattedvalue2));
                //console.log("in loop value =" + JSON.stringify(value));
                //console.log("in loop newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
            } else {
                var newInput = [];
                var newFormatttedValue = [];
                var currentModalField = "#" + id + "_Modal .sm_theme_popup_" + single.id;
                // console.log("single.type " + single.type + " single.id " + single.id+" currentModalField "+currentModalField);
                $(currentModalField).each(function () {
                    var singleInfo = $(this).val();
                    // console.log("singleInfo "+singleInfo);
                    var singleFV = $(this).attr('data-formattedvalue');
                    newInput.push(singleInfo);
                    newFormatttedValue.push(singleFV);
                });


                parentname = single.name;
                var name = single.name;
                var selector = single.selector + "__" + single.id + "_";
                var val = newInput;
                // $(this).val("");
                if (template === single.id) {
                    title = val;
                    $(".sm_theme_option_active_sortable" + children).find(".sm_theme_popup_title").text(val);
                }
                value[single.id] = val;
                newformattedvalue.id = single.id;
                newformattedvalue.type = single.type;
                newformattedvalue.name = name;
                newformattedvalue.value = newFormatttedValue;
                newformattedvalue.selector = selector;
                // newformattedvalue2[single.id] = newformattedvalue;

                formattedvalue[single.id] = (newformattedvalue);

                // console.log("in loop id = " + single.id + " type = " + single.type + " name = " + name + " val= " + val + " selector = " + selector + " newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
                // console.log("in loop else single =" + JSON.stringify(value));
                // console.log("in loop else newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
                // console.log("in loop "+"#" + id + "_Modal .sm_theme_popup_" + single.id);
                // console.table(newFormatttedValue);
            }

        }
        var fnReturun = {};
        fnReturun.title = title;
        fnReturun.value = value;
        fnReturun.parentname = parentname;
        fnReturun.formattedvalue = formattedvalue;
        return fnReturun;
    }

    function remove_sm_theme_option_active_sortable(children) {
        $(".sm_theme_option_active_sortable" + children).each(function () {
            $(this).removeClass("sm_theme_option_active_sortable" + children);
        });
    }

    function sorting_position_change() {
        $(".smThemeAddablePopUp ul").each(function () {
            var loop = 0;
            $(this).children("li").each(function () {
                $(this).children(".sm_theme_popup_input").each(function () {
                    var id = $(this).data("id");
                    var basename = $(this).data("basename");
                    if (basename.length > 0) {
                        //console.log("basename = " + basename + "[" + loop + "]" + "[" + id + "]");
                        $(this).attr("name", basename + "[" + loop + "]" + "[" + id + "]");
                    }
                });
                loop++;
            });
        });
    }

    $(".sm_post_save_process").on("click", function () {
        sorting_position_change();
    });
    $('.colorpicker').colorpicker({
        colorSelectors: {
            'black': '#000000',
            'white': '#ffffff',
            'red': '#FF0000',
            'default': '#777777',
            'primary': '#337ab7',
            'success': '#5cb85c',
            'info': '#5bc0de',
            'warning': '#f0ad4e',
            'danger': '#d9534f'
        }
    });


    /* end nptl theme option js */


    /**
     * Generate slug
     */
    function checkSlug($this) {
        // console.log("checkSlug");
        var slug = $this.val();
        var table = $this.data("table");
        var current_info_id = $('#current_info_id').val();
        var _token = $('#table_csrf_token').val();
        if (slug.length != '' && table.length != '') {
            $.ajax({
                type: 'post',
                url: smAdminUrl + "check-slug",
                data: {slug: slug, table: table, 'current_info_id': current_info_id, _token: _token},
                success: function (response) {
                    $("#slug").val(response);
                }
            });
        }
    }

    if ($(".sm-title-section").length > 0) {
        $("#slug").on("change", function () {
            checkSlug($(this));
        });
        $("#title").on("change", function () {
            checkSlug($(this));
        });
    }

    /**
     * package page js
     */

    if ($('#type').length > 0) {
        $('#type').on('change', function () {
            var type = $(this).val();
            packageTypeChanged(type);
        });
    }


    if ($("#paymentMethodType").length > 0) {
        paymentMethodChanged();
        $("#paymentMethodType").on("change", function () {
            paymentMethodChanged();
        });
    }

    if ($("#order_list_wid").length > 0) {
        $("#order_list_wid").on("change", '.payment_change_status', function () {
            var $this = $(this),
                payment_status = parseInt($this.val()),
                due = parseInt($this.data('due')),
                row = parseInt($this.data('row')),
                post_id = parseInt($(this).data('post_id'));
            if (due > 0 && payment_status === 1) {
                $("#pm_order_id").val(post_id);
                $("#pm_pay").val(due);
                $("#pm_payment_status").val(payment_status);
                $("#pm_row").val(row);
                $("#sm_order_payment_modal").modal("show");
            } else {
                var _token = $('#table_csrf_token').val();
                var message = "";
                if (payment_status === 1) {
                    message = "Are you sure to confirm this?";
                } else if (payment_status === 2) {
                    message = "Are you sure to pending this?";
                } else {
                    message = "Are you sure to cancel this?";
                }

                swal({
                    title: "Warning?",
                    text: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            url: smAdminUrl + "orders/payment_status_update",
                            data: {_token: _token, post_id: post_id, payment_status: payment_status},
                            success: function (response) {
                                if (parseInt(response) == 1) {
                                    swal({
                                        type: 'success',
                                        icon: "success",
                                        title: 'Payment Status Updated Successfully',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    swal({
                                        type: 'warning',
                                        icon: "warning",
                                        title: 'Status Update Cancelled',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            },
                            error: function (error) {
                                var text = '';
                                var errors = error.responseJSON.errors;
                                for (var err in errors) {
                                    text += errors[err][0];
                                    text += "\n";
                                }
                                swal({
                                    type: 'error',
                                    icon: "error",
                                    title: 'Error',
                                    text: text,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        });
                    } else {
                        swal({
                            type: 'warning',
                            icon: "warning",
                            title: 'Status Update Cancelled',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });

        $("#payment_status_form").on("submit", function () {
            var $this = $(this),
                row = parseInt($("#pm_row").val());
            $("#save_payment_info").html('<i class="fa fa-refresh fa-spin"></i> Save Order Info');
            $.ajax({
                type: 'post',
                url: $this.attr("action"),
                data: $this.serialize(),
                success: function (response) {
                    //console.log(response);
                    $("#paid_" + row).text("$" + response.order.paid);
                    $("#due_" + row).text(response.due);
                    $("#sm_order_payment_modal").modal("hide");
                    if (response.hasError == 1) {
                        $("#payment_change_status_" + row).val(2);
                    }
                    swal({
                        type: 'success',
                        icon: "success",
                        title: 'Update Status',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $("#save_payment_info").html('<i class="fa fa-save"></i> Save Order Info');
                },
                error: function (error) {
                    var text = '';
                    var errors = error.responseJSON.errors;
                    for (var err in errors) {
                        text += errors[err][0];
                        text += "\n";
                    }
                    swal({
                        type: 'error',
                        icon: "error",
                        title: 'Error',
                        text: text,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#save_payment_info").html('<i class="fa fa-save"></i> Save Order Info');
                }
            });
            return false;
        });


        $("#order_list_wid").on("change", '.order_change_status', function () {
            var $this = $(this),
                order_status = parseInt($this.val()),
                row = parseInt($this.data('row')),
                due = parseInt($this.data('due')),
                post_id = parseInt($(this).data('post_id'));
            if (order_status === 1) {
                $("#od_order_id").val(post_id);
                $("#od_pay").val(due);
                $("#od_order_status").val(order_status);
                $("#od_row").val(row);
                if (due < 1) {
                    $("#od_pay_div").fadeOut();
                }
                $("#image").val('');
                $("#od_mail_message").val('');
                $("#first_ph").html('');
                $("#sm_order_status_modal").modal("show");
            } else {
                var _token = $('#table_csrf_token').val();
                var message = "";
                if (order_status === 1) {
                    message = "Are you sure to confirm this order status?";
                } else if (order_status === 2) {
                    message = "Are you sure to progress this order status?";
                } else if (order_status === 3) {
                    message = "Are you sure to pending this order status?";
                } else {
                    message = "Are you sure to cancel this order status?";
                }

                swal({
                    title: "Warning?",
                    text: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            url: smAdminUrl + "orders/order_status_update",
                            data: {_token: _token, post_id: post_id, order_status: order_status},
                            success: function (response) {
                                if (parseInt(response) == 1) {
                                    swal({
                                        type: 'success',
                                        icon: "success",
                                        title: 'Order Status Updated Successfully',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    swal({
                                        type: 'warning',
                                        icon: "warning",
                                        title: 'Status Update Cancelled',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            },
                            error: function (error) {
                                var text = '';
                                var errors = error.responseJSON.errors;
                                for (var err in errors) {
                                    text += errors[err][0];
                                    text += "\n";
                                }
                                swal({
                                    type: 'error',
                                    icon: "error",
                                    title: 'Error',
                                    text: text,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        });
                    } else {
                        swal({
                            type: 'warning',
                            icon: "warning",
                            title: 'Status Update Cancelled',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });
        $("#order_status_form").on("submit", function () {
            var $this = $(this),
                row = parseInt($("#od_row").val());
            $("#save_order_info").html('<i class="fa fa-refresh fa-spin"></i> Saving Order Info and Sending Mail');
            $.ajax({
                type: 'post',
                url: $this.attr("action"),
                data: $this.serialize(),
                success: function (response) {
                    //console.log(response);
                    $("#paid_" + row).text("$" + response.order.paid);
                    $("#due_" + row).text(response.due);
                    if (response.filesHtml != '') {
                        $("#files_" + row).html(response.filesHtml);
                    }
                    if (response.hasError == 1) {
                        $("#order_change_status_" + row).val(2);
                    }
                    $("#sm_order_status_modal").modal("hide");
                    swal({
                        type: 'success',
                        icon: "success",
                        title: 'Update Status',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#save_order_info").html('<i class="fa fa-save"></i> Save Order Info and Send Mail');
                },
                error: function (error) {
                    var text = '';
                    var errors = error.responseJSON.errors;
                    for (var err in errors) {
                        text += errors[err][0];
                        text += "\n";
                    }
                    swal({
                        type: 'error',
                        icon: "error",
                        title: 'Error',
                        text: text,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#save_order_info").html('<i class="fa fa-save"></i> Save Order Info and Send Mail');
                }
            });
            return false;
        });


        $("#order_mail_form").on("submit", function () {
            var $this = $(this);
            $("#send_order_info").html('<i class="fa fa-refresh fa-spin"></i> Sending Mail');
            $.ajax({
                type: 'post',
                url: $this.attr("action"),
                data: $this.serialize(),
                success: function (response) {
                    $("#sm_mail_modal").modal("hide");
                    swal({
                        type: 'success',
                        icon: "success",
                        title: 'Update Status',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#send_order_info").html('<i class="fa fa-envelope"></i> Send Mail');
                },
                error: function (error) {
                    var text = '';
                    var errors = error.responseJSON.errors;
                    for (var err in errors) {
                        text += errors[err][0];
                        text += "\n";
                    }
                    swal({
                        type: 'error',
                        icon: "error",
                        title: 'Error',
                        text: text,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#send_order_info").html('<i class="fa fa-envelope"></i> Send Mail');
                }
            });
            return false;
        });
    }


    /**
     * package save
     */

    smValidator("package_form", {
        title: {
            'notEmpty': {
                message: "The title is required"
            }
        },
        slug: {
            'notEmpty': {
                message: "The slug is required"
            }
        },
        description: {
            'notEmpty': {
                message: "The description is required"
            }
        },
        status: {
            'notEmpty': {
                message: "The status is required"
            }
        },
        image: {
            'notEmpty': {
                message: "The package banner is required"
            }
        },
        type: {
            'notEmpty': {
                message: "The package type is required"
            },
            'itsDependable': {
                rules: {
                    1: {
                        'pricing_detail_1[price_type]': {
                            'notEmpty': {
                                message: "The package price type is required"
                            }
                        },
                        'pricing_detail_1[particular_title]': {
                            'notEmpty': {
                                message: "The package particular title is required"
                            }
                        },
                        'pricing_detail_1[advanced_pricing_title]': {
                            'notEmpty': {
                                message: "The package advanced price title is required"
                            }
                        },
                        'pricing_detail_1[professional_pricing_title]': {
                            'notEmpty': {
                                message: "The package professional price title is required"
                            }
                        },
                        'pricing_detail_1[price_advanced]': {
                            'notEmpty': {
                                message: "The package advanced Price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_1[price_professional]': {
                            'notEmpty': {
                                message: "The package professional Price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_1_pricing_info_': {
                            'count': {
                                min: 1,
                                type: 'class',
                                massageDivId: 'pricing_detail_1_pricing_info__add_more',
                                selector: '#pricing_detail_1_pricing_info_ .ui-state-default',
                                message: "The package info is required!"
                            }
                        },
                    },
                    2: {
                        'pricing_detail_2[price_type]': {
                            'notEmpty': {
                                message: "The package price type is required"
                            }
                        },
                        'pricing_detail_2[basic_pricing_title]': {
                            'notEmpty': {
                                message: "The package basic price title is required"
                            }
                        },
                        'pricing_detail_2[silver_pricing_title]': {
                            'notEmpty': {
                                message: "The package silver price title is required"
                            }
                        },
                        'pricing_detail_2[gold_pricing_title]': {
                            'notEmpty': {
                                message: "The package gold price title is required"
                            }
                        },
                        'pricing_detail_2[price_basic]': {
                            'notEmpty': {
                                message: "The package basic price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_2[price_silver]': {
                            'notEmpty': {
                                message: "The package silver price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_2[price_gold]': {
                            'notEmpty': {
                                message: "The package gold price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_2_pricing_info_': {
                            'count': {
                                min: 1,
                                type: 'class',
                                massageDivId: 'pricing_detail_2_pricing_info__add_more',
                                selector: '#pricing_detail_2_pricing_info_ .ui-state-default',
                                message: "The package info is required!"
                            }
                        },
                    },
                    3: {
                        'pricing_detail_3[basic_pricing_title]': {
                            'notEmpty': {
                                message: "The package basic price title is required"
                            }
                        },
                        'pricing_detail_3[silver_pricing_title]': {
                            'notEmpty': {
                                message: "The package silver price title is required"
                            }
                        },
                        'pricing_detail_3[gold_pricing_title]': {
                            'notEmpty': {
                                message: "The package gold price title is required"
                            }
                        },
                        'pricing_detail_3[price_basic1]': {
                            'notEmpty': {
                                message: "The package basic price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3[price_basic2]': {
                            'notEmpty': {
                                message: "The package basic price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3[price_basic3]': {
                            'notEmpty': {
                                message: "The package basic price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3[price_silver1]': {
                            'notEmpty': {
                                message: "The package silver price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3[price_silver2]': {
                            'notEmpty': {
                                message: "The package silver price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3[price_silver3]': {
                            'notEmpty': {
                                message: "The package silver price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3[price_gold1]': {
                            'notEmpty': {
                                message: "The package gold price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3[price_gold2]': {
                            'notEmpty': {
                                message: "The package gold price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3[price_gold3]': {
                            'notEmpty': {
                                message: "The package gold price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_3_pricing_info_1_': {
                            'count': {
                                min: 1,
                                type: 'class',
                                massageDivId: 'pricing_detail_3_pricing_info_1__add_more',
                                selector: '#pricing_detail_3_pricing_info_1_ .ui-state-default',
                                message: "The package info is required!"
                            }
                        },
                        'pricing_detail_3_pricing_info_2_': {
                            'count': {
                                min: 1,
                                type: 'class',
                                massageDivId: 'pricing_detail_3_pricing_info_2__add_more',
                                selector: '#pricing_detail_3_pricing_info_2_ .ui-state-default',
                                message: "The package info is required!"
                            }
                        },
                        'pricing_detail_3_pricing_info_3_': {
                            'count': {
                                min: 1,
                                type: 'class',
                                massageDivId: 'pricing_detail_3_pricing_info_3__add_more',
                                selector: '#pricing_detail_3_pricing_info_3_ .ui-state-default',
                                message: "The package info is required!"
                            }
                        },
                    },
                    4: {
                        'pricing_detail_4_pricing_content_': {
                            'count': {
                                min: 1,
                                type: 'class',
                                massageDivId: 'pricing_detail_4_pricing_content__add_more',
                                selector: '#pricing_detail_4_pricing_content_ .ui-state-default',
                                message: "The package info is required!"
                            }
                        },
                    },
                    5: {
                        'pricing_detail_5[price_type]': {
                            'notEmpty': {
                                message: "The package price type is required"
                            }
                        },
                        'pricing_detail_5[basic_pricing_title]': {
                            'notEmpty': {
                                message: "The package starter price title is required"
                            }
                        },
                        'pricing_detail_5[subtitle][basic_pricing_subtitle]': {
                            'notEmpty': {
                                message: "The package starter price subtitle is required"
                            }
                        },
                        'pricing_detail_5[silver_pricing_title]': {
                            'notEmpty': {
                                message: "The package standard price title is required"
                            }
                        },
                        'pricing_detail_5[subtitle][silver_pricing_subtitle]': {
                            'notEmpty': {
                                message: "The package standard price subtitle is required"
                            }
                        },
                        'pricing_detail_5[gold_pricing_title]': {
                            'notEmpty': {
                                message: "The package advanced price title is required"
                            }
                        },
                        'pricing_detail_5[subtitle][gold_pricing_subtitle]': {
                            'notEmpty': {
                                message: "The package advanced price title is required"
                            }
                        },
                        'pricing_detail_5[price_basic]': {
                            'notEmpty': {
                                message: "The package starter price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_5[price_silver]': {
                            'notEmpty': {
                                message: "The package standard price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_5[price_gold]': {
                            'notEmpty': {
                                message: "The package advanced price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_5_pricing_info_': {
                            'count': {
                                min: 1,
                                type: 'class',
                                massageDivId: 'pricing_detail_5_pricing_info__add_more',
                                selector: '#pricing_detail_5_pricing_info_ .ui-state-default',
                                message: "The package info is required!"
                            }
                        },
                    },
                    6: {
                        'pricing_detail_6[price_type]': {
                            'notEmpty': {
                                message: "The package price type is required"
                            }
                        },
                        'pricing_detail_6[basic_pricing_title]': {
                            'notEmpty': {
                                message: "The package starter price title is required"
                            }
                        },
                        'pricing_detail_6[subtitle][basic_pricing_subtitle]': {
                            'notEmpty': {
                                message: "The package starter price subtitle is required"
                            }
                        },
                        'pricing_detail_6[silver_pricing_title]': {
                            'notEmpty': {
                                message: "The package standard price title is required"
                            }
                        },
                        'pricing_detail_6[subtitle][silver_pricing_subtitle]': {
                            'notEmpty': {
                                message: "The package standard price subtitle is required"
                            }
                        },
                        'pricing_detail_6[premium_pricing_title]': {
                            'notEmpty': {
                                message: "The package premium price title is required"
                            }
                        },
                        'pricing_detail_6[subtitle][premium_pricing_subtitle]': {
                            'notEmpty': {
                                message: "The package premium price subtitle is required"
                            }
                        },
                        'pricing_detail_6[gold_pricing_title]': {
                            'notEmpty': {
                                message: "The package advanced price title is required"
                            }
                        },
                        'pricing_detail_6[subtitle][gold_pricing_subtitle]': {
                            'notEmpty': {
                                message: "The package advanced price subtitle is required"
                            }
                        },
                        'pricing_detail_6[price_basic]': {
                            'notEmpty': {
                                message: "The package starter price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_6[price_silver]': {
                            'notEmpty': {
                                message: "The package standard price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_6[price_gold]': {
                            'notEmpty': {
                                message: "The package advanced price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_6[price_premium]': {
                            'notEmpty': {
                                message: "The package premium price is required"
                            },
                            'stringLength': {
                                min: 1,
                                max: 10,
                                message: "Price must be less then 10 digit."
                            }
                        },
                        'pricing_detail_6_pricing_info_': {
                            'count': {
                                min: 1,
                                type: 'class',
                                massageDivId: 'pricing_detail_6_pricing_info__add_more',
                                selector: '#pricing_detail_6_pricing_info_ .ui-state-default',
                                message: "The package info is required!"
                            }
                        },
                    }
                }

            }
        }

    }, 1);
    // package validation end


    /**
     * global ajax pagination
     */
    if ($('#smpagination_links').length > 0) {
        $("#smpagination_links").on('click', 'a', function () {
            $(this).html('<i class="fa fa-refresh fa-spin"></i>');
            var href = $(this).attr('href');
            $.ajax({
                type: 'get',
                url: href,
                success: function (response) {
                    $("#dataBody").html(response.data);
                    $("#smpagination_links").html(response.smPagination);
                },
                error: function (err) {
                    console.log("AJAX Error");
                }
            });
            return false;
        });
    }


    /**
     * Reset all fields
     */
    if ($(".reset_fields").length > 0) {
        $(".reset_fields").on('click', function () {
            $(document).find('.form-control').val('');
            swal({
                type: 'success',
                icon: "success",
                title: 'All fields cleared successfully!',
                showConfirmButton: false,
                timer: 2500
            });
        });
    }

    /**
     * report package search
     */
    if ($("#package_search").length > 0) {
        $("#package_search").on('keyup', function () {
            var packageV = $(this).val();
            var _token = $("#table_csrf_token").val();
            var html = '';
            $("#pid").val("");
            $.ajax({
                type: 'post',
                url: smAdminUrl + "package_search",
                data: {_token: _token, package: packageV},
                success: function (response) {
                    if (response.length > 0) {
                        for (var index in response) {
                            var pkg = response[index];
                            html += '<a user="' + pkg.id + '" class="list-group-item search_item" href="javascript:void(0)">' + pkg.title + '</a>';
                        }
                    }
                    $("#package_search_div").html(html);
                },
                error: function (error) {
                    $("#package_search_div").html(html);
                }
            })
        })
    }
    /**
     * report customer search
     */

    if ($("#customer_search").length > 0) {
        $("#customer_search").on('keyup', function () {
            var customer = $(this).val();
            var _token = $("#table_csrf_token").val();
            var html = '';
            $("#cid").val("");
            $.ajax({
                type: 'post',
                url: smAdminUrl + "customer_search",
                data: {_token: _token, customer: customer},
                success: function (response) {
                    if (response.length > 0) {
                        for (var index in response) {
                            var user = response[index];
                            var name = user.fullname == '' || user.fullname == null ? user.username : user.fullname;
                            html += '<a user="' + user.id + '" class="list-group-item search_item" href="javascript:void(0)">' + name + '</a>';
                        }
                    }
                    $("#customer_search_div").html(html);
                },
                error: function (error) {
                    $("#customer_search_div").html(html);
                }
            })
        })
    }

    if ($('.search_div').length > 0) {
        $('.search_div').on('click', '.search_item', function () {
            var id = $(this).attr("user");
            var text = $(this).text();
            var selector = $(this).parents(".list-group").parents(".search_div");
            // console.log("id = " + id + " text = " + text);
            $(this).parents(".list-group").html("");
            selector.siblings(".itemvalue").val(id);
            selector.siblings(".itemtext").val(text);
        });
    }


    //subscribe mail start
    if ($(".allCheck").length > 0) {
        $(".allCheck").on('click', function () {
            if ($(this).is(':checked')) {
                $(document).find('.smCheckbox').prop('checked', true);
            } else {
                $(document).find('.smCheckbox').prop('checked', false);
            }
        });
    }

    // if ($(".showOrderMailModal").length > 0) {
    $("#order_list_wid").on("click", '.showOrderMailModal', function () {
        // $(".showOrderMailModal").on('click', function () {
        var order_id = $(this).data('post_id');
        $("#mail_order_id").val(order_id);
        $('#sm_mail_modal').modal("show");
        return false;
    });
    // }
    if ($("#showOfferMailPopUp").length > 0) {
        $("#showOfferMailPopUp").on('click', function () {
            var checkedCount = $('.subscriber:checked').size();
            if (checkedCount > 0) {
                var html = '';
                $('.subscriber:checked').each(function () {
                    var row = $(this).val();
                    var email = $('.subscriberemail' + row).text();
                    html += '<li>';
                    html += '<input type="hidden" value="' + email + '" name="email[]">';
                    html += email;
                    html += '</li>';
                });
                $("#mailTo").html(html);
                $('#sm_mail_modal').modal("show");
            } else {
                swal({
                    type: 'warning',
                    icon: "warning",
                    title: 'Warning',
                    text: 'Please select subscriber!',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
            return false;
        });
    }
    if ($(".showOfferMailPopUpForSingleSubscriber").length > 0) {
        $(document).on('click', '.showOfferMailPopUpForSingleSubscriber', function () {
            var row = $(this).attr("row");
            $('.subscriber' + row).attr('checked', true);
            var html = '';
            var email = $('.subscriberemail' + row).text();
            html += '<li>';
            html += '<input type="hidden" value="' + email + '" name="email[]">';
            html += email;
            html += '</li>';
            $("#mailTo").html(html);
            $('#sm_mail_modal').modal("show");
            return false;
        });
    }


    var rules = {
        'email[]': {
            notEmpty: {
                message: 'The email field is required'
            }
        },
        discount_title: {
            notEmpty: {
                message: "The discount title field is required!"
            }
        },
        available_title: {
            notEmpty: {
                message: 'The available title field is required'
            }
        },
        message: {
            notEmpty: {
                message: 'The mail message field is required'
            }
        },
        btn_title: {
            notEmpty: {
                message: 'The button title field is required'
            }
        },
        btn_link: {
            notEmpty: {
                message: 'The button title field is required'
            }
        },
        image: {
            notEmpty: {
                message: 'The image field field is required'
            }
        },
    };
    var buttonHtml = $(".sendOfferMain").html();
    var beforeCallback = function () {
        document.getElementById('sendOfferMain').innerHTML = '<i class="fa fa-refresh fa-spin"></i> Please wait, Mail Sending...';
    };
    var mailCallback = function (response) {
        if (response.isSuccess) {
            $(document).find('.smCheckbox').prop('checked', false);
            // $("#sendOfferMain").removeAttr('disbaled');
            $("#sendOfferMain").html(buttonHtml);
            $("#mailTo").html('');
            $('#sm_mail_modal').modal("hide");
            swal({
                type: 'success',
                icon: 'success',
                title: response.response,
                showConfirmButton: false,
                timer: 3000
            });
        } else {
            // $("#sendOfferMain").removeAttr('disbaled');
            $("#sendOfferMain").html(buttonHtml);
            swal({
                type: 'warning',
                icon: 'warning',
                title: response.response
            });
        }
    };
    smValidator("mailForm", rules, 3, mailCallback, beforeCallback);


    //subscribe mail end


    //service layout change
    if ($("#service_layout").length > 0) {
        $("#service_layout").on('change', function () {
            var layout = $(this).val();
            // console.log("service_layout " + layout);
            if (layout == 2) {
                $("#wid-add-service-extra-main").slideUp();
            } else {
                $("#wid-add-service-extra-main").slideDown();
            }
        })
    }


    if ($("#case_style").length > 0) {
        $("#case_style").on('change', function () {
            var style = $(this).val();
            // console.log("style " + style);
            $(".case_style_content").fadeOut();
            $("#case_style" + style).fadeIn();
            // console.log("style " + style);
        });
    }


    if ($(".support-comment-list").length > 0) {
        $('.support-comments-area').scrollTop($('.support-comment-list').height());
    }
    //support reply form submit
    if ($("#admin_support_ticket_reply").length > 0) {
        $("#admin_support_ticket_reply").on('submit', function () {
            var $this = $(this), data = $this.serialize();
            $.ajax({
                type: 'post',
                url: $this.attr('action'),
                data: data,
                success: function (response) {
                    $(".no_support_reply").fadeOut();
                    $("#admin_last_loaded_support").val(response.id);
                    $("#admin_support_ticket_reply").find(".error-notice").html("");
                    $("#support_message").val("");
                    $('.support-comment-list').append(response.html);
                    $('.support-comments-area').scrollTop($('.support-comment-list').height());
                },
                error: function (error) {
                    $("#admin_support_ticket_reply").find(".error-notice").html(error.responseJSON.errors.message[0]);
                }
            });
            return false;
        });

        // load older post
        $("#admin_load_more_support").on("click", function () {
            var $this = $(this), last = $this.attr("data-last"), current = parseInt($this.attr("data-current")) + 1,
                href = $this.attr("href") + "?page=" + current;
            $this.html('<i class="fa fa-refresh fa-spin"></i> Loading Older Message');
            if (last <= current) {
                $this.fadeOut();
            }
            $.ajax({
                type: 'get',
                url: href,
                success: function (response) {
                    $this.html('<i class="fa fa-refresh"></i> Load Older Message');
                    $this.attr("data-current", current);
                    $('.support-comment-list').prepend(response);
                }
            });
            return false;
        });
    }
})(jQuery);

function paymentMethodChanged() {
    var type = parseInt($("#paymentMethodType").val());
    //console.log('type ' + type);
    if (type === 2 || type === 3) {
        $('#paymentMethodTypeApi').slideDown();
    } else {
        $('#paymentMethodTypeApi').slideUp();
    }
}


function packageTypeChanged(type) {
    $('.div_package').slideUp();
    $('.div_package_' + type).slideDown();
}

function get_the_file_width(str, width) {
    return str.replace('112x112', width + 'x' + width);
}


function imagePrev(imageID, imageHolder) {
    var imgPath = $('#' + imageID)[0].value;
    var extn = imgPath.substring(imgPath.lastIndexOf(".") + 1).toLowerCase();
//        alert(imageID + " " + imageHolder + " " + imgPath + " " + extn);
    if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {
        if (typeof (FileReader) !== "undefined") {
            var image_holder = $("#" + imageHolder);
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "image-prev"
                }).appendTo(image_holder);

            };
            image_holder.show();
            reader.readAsDataURL($('#' + imageID)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    } else {
        alert("Pls select only images");
    }
}


function mrksGetImageResponse(modal, selector, val) {
    var imagePlaceholder = selector + "_ph";
    var _token = $('#table_csrf_token').val();
    $("#" + modal).find("#" + selector).val(val);
    $.ajax({
        url: smAdminUrl + "get_image_src",
        data: {is_upload: 1, ids: val, _token: _token},
        type: 'post',
        success: function (response) {
            $("#" + modal).find(".smthemesingleimagediv#" + imagePlaceholder).html(response);
        }
    });
}

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

window.onload = function () {
//Check File API support
    if (window.File && window.FileList && window.FileReader) {

        var filesInput = document.getElementById("userfile");
        if (filesInput != null) {
            filesInput.addEventListener("change", function (event) {

                var files = event.target.files; //FileList object
                var output = document.getElementById("result");
                $('#result li').remove();
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    //Only pics
                    if (!file.type.match('image'))
                        continue;
                    var picReader = new FileReader();
                    picReader.addEventListener("load", function (event) {

                        var picFile = event.target;
                        var div = document.createElement("li");
                        div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                            "title='" + picFile.name + "'/>";
                        output.insertBefore(div, null);
                    });
                    //Read the image
                    picReader.readAsDataURL(file);
                }

            });
        }
    } else {
        console.log("Your browser does not support File API");
    }

}
