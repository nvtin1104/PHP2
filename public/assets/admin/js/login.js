$(document).ready(function () {
    $("#loginAdminBtn").click(function (event) {
        event.preventDefault();
        let url = $(this).attr("data-url");
        var username = $("#signin-email").val();
        var password = $("#signin-password").val();
        console.log(password, username, url);
        $.ajax({
            type: "POST",
            url: url + "/auth/handleLogin",
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
                    launch_toast();
                } else if (response.success) {
                    // Hiển thị thông báo thành công
                    alert(response.success);
                    window.location.href = url + "/admin/dashboard";
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
    function launch_toast(type = "success", message = "Thành công!") {
        let x = $("#toast");
        let img = $(".toast-img");
        img.html(type === 'success' ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>' : 'error');
        img.addClass(type);
        x.addClass("show");
        setTimeout(function () { x.removeClass("show"); }, 2300);
    }
});
