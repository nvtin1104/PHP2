$(document).ready(function () {
    let toastCounter = 1;
    const toast = {
        success: {
            icon: "fa-check",
            color: "#27ae60",
            animation: "slide-in-slide-out"
        },
        error: {
            icon: "fa-triangle-exclamation",
            color: "#c0392b",
            animation: "slide-in-fade-out"
        },
        infor: {
            icon: "fa-info",
            color: "#2980b9",
            animation: "slide-in-slide-out"
        },
        warning: {
            icon: "fa-triangle-exclamation",
            color: "#f39c12",
            animation: "slide-in-fade-out"
        }
    };
    function displayToastNotification(msg, type) {
        let class_name = 'toast-' + toastCounter;
        let new_node;
        let htmlToast = toast[type];
        let icon = $('#icon-toast');
        icon.addClass(htmlToast.icon);
        console.log(icon);
        new_node = $('.master-toast-notification').clone().appendTo('.toasts').addClass(class_name + ' toast-notification').removeClass('master-toast-notification');
        new_node.find('.toast-msg').text(msg);
        new_node.find('.toast-icon').addClass('wiggle-me').css('background-color', htmlToast.color);
        new_node.removeClass('hide-toast').addClass(htmlToast.animation);
        setTimeout(function () {
            new_node.remove();
        }, 3800);
        toastCounter++;
    }
    let replyTo = 0;
    $('.reply-btn').click(function (e) {
        id = $(this).data('id');
        replyTo = id;
        let name = $(this).data('name');
        $('#comment-reply').val(name);

        console.log(replyTo);
    });
    $('#btn-remove-reply').click(function (e) {
        replyTo = 0;
        $('#comment-reply').val('');
    });
    // Sử dụng jQuery để bắt sự kiện click cho các nút có class là 'updateCart'
    $('#blog-btn-form').click(function (e) {
        e.preventDefault();
        let dataPath = $(this).data('path');
        let id = $(this).data('id');

        let name = $('#comment-name').val();
        let email = $('#comment-email').val();
        let content = $('#comment-review-text').val();
        $.ajax({
            url: dataPath + '/blogs/handleCreateComment', // Replace with the actual endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: {
                comment_to: id,
                name: name,
                email: email,
                content: content,
                type: 'blog',
                reply_to: replyTo,
            },
            dataType: "json", // Loại dữ liệu mà bạn mong đợi từ máy chủ
            beforeSend: function () {
                // Thêm hiệu ứng loading tại đây (ví dụ: hiển thị một biểu tượng loading)
                $("#bg_loading").show();
            },
            success: function (response) {
                $("#bg_loading").hide();
                if (response.error) {
                    // Hiển thị thông báo lỗi
                    displayToastNotification(response.error, 'error');

                } else if (response.success) {
                    displayToastNotification(response.success, 'success');
                } else if (response.log) {
                    // Hiển thị thông báo thành công
                    alert(response.log);
                }
            },
            error: function (xhr, status, error) {
                $("#bg_loading").hide();
                // Xử lý lỗi AJAX (nếu có)
                console.error("Lỗi AJAX: " + status + " - " + error);
            }
        });
    });

});
