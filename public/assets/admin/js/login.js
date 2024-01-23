$(document).ready(function () {
    $("#loginAdminBtn").click(function (event) {
        event.preventDefault();
        let url = $(this).attr("data-url");
        var username = $("#signin-email").val();
        var password = $("#signin-password").val();
        console.log(password);
        $.ajax({
            type: "POST",
            url: url + "/auth/login",
            data: {
                username: username,
                password: password
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
                    alert(response.success);
                    window.location.href = "<?php echo _WEB_ROOT ?>/home";
                } else if (response.log) {
                    // Hiển thị thông báo thành công
                    console.log(response.log);
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