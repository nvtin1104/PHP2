$(document).ready(function () {
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
                    alert(response.error);

                } else if (response.success) {
                    // Hiển thị thông báo thành công
                    // alert(response.success);
                    alert(response.success);
                    // if (response.location) {
                    //     window.location.href = "<? echo _WEB_ROOT ?>/home";
                    // }
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
