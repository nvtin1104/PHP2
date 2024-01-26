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
    // Attach a click event handler to all buttons with the class 'addToCart'
    $('.addToCart').click(function (event) {
        // Prevent the default behavior of the button
        event.preventDefault();

        // Get the data-id attribute value for the clicked button
        let dataId = $(this).data('id');
        let dataPath = $(this).data('path');

        // Perform your AJAX request with the specific dataId
        $.ajax({
            url: dataPath + '/cart/handleAddToCart', // Replace with the actual endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: {
                product_id: dataId,
                quantity: 1
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
                    // Thay đổi hình ảnh
                    $('.count-cart').text(response.infor.quantity);
                    $('.modal-add-cart-product-img img').attr('src', response.infor.img);
                    let number = +response.infor.total_price;
                    let formattedNumber = number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    $('.modal-add-cart-product-shipping-info-price').text(formattedNumber);
                    // Thay đổi giá tiền
                    // Thay đổi số lượng
                    $('.modal-add-cart-product-shipping-info-quantity').text(response.infor.quantity);
                    $('#modalAddcart').modal('show');
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
    $("#addToCart").click(function (event) {
        event.preventDefault();
        let product_id = $("#product_id").val();
        let quantity = $("#quantity").val();
        let path = $("#path").val();
        console.log(product_id, quantity, path);
        $.ajax({
            type: "POST",
            url: path + "/cart/handleAddToCart",
            data: {
                product_id: product_id,
                quantity: quantity,
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
                    // Thay đổi hình ảnh
                    $('.count-cart').text(response.infor.quantity);
                    $('.modal-add-cart-product-img img').attr('src', response.infor.img);
                    let number = +response.infor.total_price;
                    let formattedNumber = number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    $('.modal-add-cart-product-shipping-info-price').text(formattedNumber);
                    // Thay đổi giá tiền
                    // Thay đổi số lượng
                    $('.modal-add-cart-product-shipping-info-quantity').text(response.infor.quantity);
                    $('#modalAddcart').modal('show');
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
    $('.addToWishlist').click(function (event) {
        // Prevent the default behavior of the button
        event.preventDefault();

        // Get the data-id attribute value for the clicked button
        let dataId = $(this).data('id');
        let dataPath = $(this).data('path');

        // Perform your AJAX request with the specific dataId
        $.ajax({
            url: dataPath + '/cart/handleAddToWishlist', // Replace with the actual endpoint URL
            type: 'POST', // or 'GET' depending on your server-side implementation
            data: {
                product_id: dataId,
                quantity: 1
            },
            dataType: "json", // Loại dữ liệu mà bạn mong đợi từ máy chủ
            beforeSend: function () {
                // Thêm hiệu ứng loading tại đây (ví dụ: hiển thị một biểu tượng loading)
                $("#bg_loading").show();
            },
            success: function (response) {
                $("#bg_loading").hide();
                if (response.error) {
                    displayToastNotification(response.error, 'error');
                } else if (response.success) {
                    displayToastNotification(response.success, 'success');
                }
                else if (response.infor) {
                    displayToastNotification(response.infor, 'infor');
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