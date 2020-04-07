/* if(document.getElementById('flashMessage') !== null) {
    window.setTimeout("document.getElementById('flashMessage').style.display='none';", 3000);
} */

var fxUser = {
    'UIHelper': function () {
        $("[data-toggle='tooltip']").tooltip();
        
        $('.form-control').on('input change', function () {
            console.log('fxUser UIHelper');
            $(this).removeClass('is-invalid');
            $(this).nextAll('.help-block').fadeOut();
        });
    },
    'displayFormErrorMessages': function(errors, form) {
        $(form).find($(".errors")).remove();
        
        $.each(errors, function(fieldName, message){
            $(form).find("[id="+fieldName+"]").addClass('is-invalid');
            
            if (message.length == 1) {
                $(form).find("[id="+fieldName+"]").nextAll(".help-block").remove();
                $(form).find("[id="+fieldName+"]").after("<span class='help-block'>" + message[0] + "</span>")
            } else {
                for (i = 0; i < message.length - 1; i++) {
                    $(form).find("[id="+fieldName+"]").nextAll(".help-block").fadeOut();
                    if (i == message.length - 1) {
                        console.log('w/o br');
                        $(form).find("[id="+fieldName+"]").after("<span class='help-block'>" + message[i] + "<br></span>")
                    } else {
                        console.log('w/ br');
                        $(form).find("[id="+fieldName+"]").after("<span class='help-block'>" + message[i] + "</span>")
                    }
                }
            }
        });
    }
};

$(function () {
    fxUser.UIHelper();
    $("body").on("click", ".post_content, .like_post, .comment_post, .edit_comment, .delete_comment,"+
                          ".edit_post, .share_post, .delete_post, .restore_post,"+
                          ".follow_user, .unfollow_user, .edit_profile, .get_follow," +
                          ".update_picture, .change_password", function (event) {
        event.preventDefault();
        
        var form = $(this).closest("form").not(".form-group"),
            action = form.attr("action"),
            formId = form.attr('id'),
            className = $(this).attr("class").split(" ")[0],
            url = $(this).attr("href"),
            modal = false,
            me = this,
            fd = new FormData();

        switch (className) {
            case 'like_post':
                var postId = $(this).attr("postid");
                data = {
                    post_id: postId 
                };
                posting = $.post(url, data);
                break;
            case 'follow_user':
            case 'unfollow_user':
                var followingId = $(this).attr("followingId");
                data = {
                    following_id: followingId
                };
                posting = $.post(url, data);
                break;
            default:
                if (action == undefined) {
                    if(className != 'get_follow') {
                        modal = true;
                    }
                    posting = $.get(url);
                } else {
                    form.find("input, file, select").each(function () {
                        if ($(this).attr("type") != "file") {
                            fd.append($(this).attr("name"), $(this).val());
                        } else {
                            fd.append($(this).attr("name"), $(this)[0].files[0]);
                        }
                    });
                    
                    posting = $.ajax({
                        type: "post",
                        url: action,
                        data: fd,
                        cache: false,
                        processData: false,
                        contentType: false
                    });
                }
                break;
        }
        console.log(action);
        posting.done(function (data) {
                console.log(data);
            if(action == undefined) {
                console.log(data);
                if(modal) {
                    switch (className) {
                        /* case "comment_post":
                        case "share_post":
                            width = "modal-lg";
                            break; */
                        default:
                            width = undefined;
                            break;
                    }
    
                    fx.displayCustomizedDialogBox(
                        data,
                        className,
                        width
                    );
                    fx.modalUiHelper();
                }
                    
                switch (className) {
                    case "follow_user":
                    case "unfollow_user":
                        $("#mainContent").load(location.href);
                        break;
                    case "get_follow":
                        $("#mainContent").html(data);
                        break;
                    default:
                        $("#mainContent").load(location.href);
                        break;
                }
            } else {
                if(data.success) {
                    switch (className)
                    {
                        case "add_post":
                        case "edit_post":
                        case "comment_post":
                        case "edit_profile":
                        case "edit_comment":
                            suffix = "ed";
                            break;
                        default:
                            suffix = "d";
                            break;
                    }

                    $(".modal").modal("hide");
                    var title = className.split("_")[1],
                        notifAction = className.split("_")[0];
                        switch (className)
                        {
                            case "update_picture":
                                location.reload();
                                break;
                            case "edit_profile":
                            case "edit_post":
                            case "share_post":
                            case "comment_post":
                            case "delete_post":
                            case "restore_post":
                            case "edit_comment":
                            case "delete_comment":
                            case "change_password":
                                fx.displayNotify(
                                    title.charAt(0).toUpperCase() + title.slice(1),
                                    "Successfully " + notifAction + suffix + ".",
                                    "success"
                                );
                                setTimeout(function () {
                                    $("#mainContent").load(location.href);
                                }, 1500);
                                break;
                            default:
                                $("#mainContent").load(location.href);
                                break;
                        }
                } else {
                    if(data.error) {
                        fxUser.displayFormErrorMessages(data.error, form);
                    }
                }
            }
        }).fail(function (xhr, status, error) {
            fx.displayNotify("User", error, "danger");
        });
    });

    $('#search').on('keypress',function(e) {
        if(e.which == 13) {
            var value = $(this).val(),
                url = $(this).attr("href");
            if(!value) {
                fx.displayNotify(
                    "Search field",
                    "can't be empty",
                    "danger"
                );
            } else {
                
                posting = $.post(url, {user: value});
                posting.done(function (data) {
                    // window.location = url;
                    $("#mainContent").html(data);
                    // console.log(data);
                })
                // window.location = url + "/user:"+value;
            }
        }
    });
});
