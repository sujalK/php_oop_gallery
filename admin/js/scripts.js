$(document).ready(function() {

    $(".modal_thumbnails").click(function() {

        var user_href;
        var user_href_splitted;
        var user_id;

        var image_src;
        var image_href_splitted;
        var image_name;

        var photo_id;


        $("#set_user_image").prop("disabled", false);

        user_href            =  $("#user-id").prop("href");
        user_href_splitted   =  user_href.split("=");
        window.user_id       =  parseInt(user_href_splitted[1]);

        image_src            = $(this).prop("src");
        image_href_splitted  = image_src.split("/");
        window.image_name    = image_href_splitted[image_href_splitted.length - 1];


        photo_id= $(this).attr("data");

        // make another ajax call when we click on the picture
        $.ajax({
            url: 'includes/ajax_code.php',
            data: { photo_id: photo_id },
            type: 'POST',
            success: function(data) {
                if(!data.error) {
                    $("#modal_sidebar").html(data);
                }
            }
        });

    });

    $("#set_user_image").click(function() {

        $.ajax({
            url: "includes/ajax_code.php",
            data: {
                image_name: image_name, user_id: user_id
            },
            type: "POST",
            success: function(data) {
                if(!data.error) {
                    // alert(data);
                    // location.reload(true);

                    $("#display_image").prop("src", data);

                }
            }
        });

    });

});


/****************** edit photo sidebar  ******************/
$(".info-box-header").click(function() {
    $(".inside").toggle("fast");
    $("#toggle").toggleClass("glyphicon-menu-down glyphicon",  "glyphicon-menu-up glyphicon");
});


// delete function
$(".delete_link").click(function() {

    return confirm("Are you sure to delete?");

});