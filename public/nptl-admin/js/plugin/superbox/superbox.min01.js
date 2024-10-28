/*! SmartAdmin - v1.4.0 - 2014-06-04 */
!function (a) {
    a.fn.SuperBox = function () {
        var b = a('<div class="superbox-show"></div>'),
            c = a('<img src="" class="superbox-current-img mrks-sb-img"><video class="mrks-sb-video" width="320" height="240" controls>\' +\n' +
                '                        \'<source type="video/mp4">\' +\n' +
                '                        \'Your browser does not support the video tag.\' +\n' +
                '                        \'</video><div id="imgInfoBox" class="superbox-imageinfo inline-block"> <h1>Image Title</h1><span><a href="javascript:void(0);" class="btn btn-primary btn-sm sm_media_file_download"><i class="fa fa-download"></i> Download</a>  <a href="javascript:void(0);" class="btn btn-danger btn-sm sm_media_file_delete"><i class="fa fa-trash-o"></i>  Delete</a> <a href="javascript:void(0);" class="btn btn-default btn-sm sm_media_file_copy" copy="file_id"><i class="fa fa-copy"></i> Copy ID</a>  <a href="javascript:void(0);" class="btn btn-default btn-sm sm_media_file_copy"  copy="file_slug"><i class="fa fa-copy"></i>  Copy Slug</a></span> <div class="sm_galay_file_meta"><p>ID:<br><input type="text" id="file_id" value="test" readonly></p><p>Slug: <input readonly type="text" id="file_slug" value="test"></p><p>Title:<br><input type="text" id="file_title" value="test"></p><p>ALT Text:<br><input type="text" id="file_alt" value="test"></p><p>Caption Text:<br><input type="text" id="file_caption" value="test"></p><p>Description:<br><textarea id="file_description">Test</textarea></p> <a href="javascript:void(0);" class="btn btn-success btn-sm" id="sm_galary_meta_save"><i class="fa fa-save"></i> Save Meta Info</a></div><style type="text/css">.sm_galay_file_meta input, .sm_galay_file_meta textArea {border-radius: 2px;color: black;margin-bottom: 7px;padding: 5px;width: 100%;}</style></div>'),
            d = a('<div class="superbox-close txt-color-white"><i class="fa fa-times fa-lg"></i></div>');
        b.append(c).append(d);
        a(".superbox-imageinfo");
        return this.each(function () {
            a(".superbox").on("click", ".superbox-list", function () {
                $this = a(this);
                var d = $this.find(".superbox-img"),
                    e = d.data("img"),
                    f = d.attr("alt") || "",
                    g = e,
                    h = d.attr("title") || "",
                    caption = d.attr("caption"),
                    description = d.attr("description"),
                    ftype = d.attr("ftype"),
                    img_id = d.attr("img_id"),
                    img_slug = d.attr("img_slug");
                console.log(e);
                if (ftype == 'mp4') {
                    c.find('.mrks-sb-img').fadeOut();
                    var video = c.find('.mrks-sb-video');
                    video.find('source').attr('src', e);
                    video.fadeIn();
                } else {
                    c.find('.mrks-sb-video').fadeOut();
                    c.attr('src', e);
                    c.find('.mrks-sb-img').fadeIn();
                }

                a(".superbox-list").removeClass("active"),
                    $this.addClass("active"),
//                c.find("em").text(g),
                    c.find(">:first-child").text(h),
//                c.find(".superbox-img-description").text(f),
                    c.find("#file_id").val(img_id),
                    c.find("#file_slug").val(e),
                    c.find("#file_title").val(h),
                    c.find("#file_alt").val(f),
                    c.find("#file_caption").val(caption),
                    c.find("#file_description").val(description),
                0 == a(".superbox-current-img").css("opacity") && a(".superbox-current-img").animate({
                    opacity: 1
                }),
                    a(this).next().hasClass("superbox-show")
                        ? (a(".superbox-list").removeClass("active"), b.toggle())
                        : (b.insertAfter(this).css("display", "block"), $this.addClass("active")),

                    a("html, body").animate({
                        scrollTop: b.position().top - d.width()
                    }, "medium")
            }),
                a(".superbox").on("click", ".superbox-close", function () {
                    a(".superbox-list").removeClass("active"), a(".superbox-current-img").animate({
                        opacity: 0
                    }, 200, function () {
                        a(".superbox-show").slideUp()
                    })
                })
        })
    }
}(jQuery);