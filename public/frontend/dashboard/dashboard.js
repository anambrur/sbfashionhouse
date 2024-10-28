/** user profile picture update start ***/
if ($("#profile_picture_form").length > 0) {
    $("#profile_picture_form").on("change", function () {
        $(".change-profile-pic i").removeClass("fa-camera");
        $(".change-profile-pic i").addClass("fa-refresh fa-spin");
        $.ajax({
            type: 'post',
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $("#profile_picture_img").attr("src", response.src);
                $(".change-profile-pic i").removeClass("fa-refresh fa-spin");
                $(".change-profile-pic i").addClass("fa-camera");
            },
            error: function (error) {
                console.log(error);
            }
        });
        return false;
    });
}
/** user profile picture update end ***/