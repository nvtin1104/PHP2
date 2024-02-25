import api from './api.js';
$(document).ready(function () {
    let ward = "";
    let district = "";
    let service_id = "";
    let service_type_id = "";
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
    $("#goCheckout").click(function (event) {
        event.preventDefault();
        let user_id = $("#user_id").val();
        let phone = $("#phone").val();
        let path = $("#path").val();
        let fullname = $("#fullname").val();
        let country = $("#country").val();
        let email = $("#email").val();
        let address = $("#address").val();
        let note = $("#order_note").val();
        let total_price = $("#total_price").val();
        let payment = $("#payment").val();
        let cartIds = []; // Initialize an array to store the values

        $(".cart_id").each(function () {
            cartIds.push($(this).val());
        });
        // console.log(fullname, payment, cartIds, country, total_price, note, email, address);
        $.ajax({
            type: "POST",
            url: path + "/cart/handleCheckout",
            data: {

                user_id: user_id,
                phone: phone,
                fullname: fullname,
                country: country,
                address: address,
                email: email,
                note: note,
                total_price: total_price,
                payment: payment,
                cart_id: cartIds
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
                    // Hiển thị thông báo thành công
                    displayToastNotification(response.success, 'success');

                    setTimeout(() => {
                        window.location.href = path;
                    }, 2000)

                }
            },
            error: function (xhr, status, error) {
                $("#bg_loading").hide();
                // Xử lý lỗi AJAX (nếu có)
                console.error("Lỗi AJAX: " + status + " - " + error);
            }
        });
    });
    // Get gee GHN
    function fetchProvinceData() {
        // ward = "";
        var apiUrl =
            "https://online-gateway.ghn.vn/shiip/public-api/master-data/province";
        var apiKey = "7293aab0-b9b0-11ee-b38e-f6f098158c7e"; // Replace with your actual API key

        $.ajax({
            url: apiUrl,
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Token: apiKey,
            },
            success: function (data) {
                renderProvinceDropdown(data.data);
            },
            error: function (error) {
                console.error("Error fetching province data:", error);
            },
        });
    }
    function renderProvinceDropdown(provinceData) {
        var container = $("#provinceContainer");
        var selectProvince = $("<select id='province' class='country_option nice-select wide'></select>");

        selectProvince.append('<option value="" selected>--chọn tỉnh--</option>');

        console.log(provinceData);
        provinceData.forEach(function (province) {
            selectProvince.append('<option value="' + province.ProvinceID + '">' + province.ProvinceName + "</option>");
        });

        container.append(selectProvince);

        // // Set up event listener for province change
        // selectProvince.on("change", function () {
        //     var selectedProvinceId = $(this).val();
        //     if (selectedProvinceId) {
        //         fetchDistrictsData(selectedProvinceId);
        //     } else {
        //         // If no province selected, clear districts and wards dropdowns
        //         renderDistrictsDropdown([]);
        //         renderWardsDropdown([]);
        //     }
        // });
    }
    fetchProvinceData();
});