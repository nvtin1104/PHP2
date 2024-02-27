$(document).ready(function () {
    let locationInfo = {
        province: "",
        ward: "",
        district: "",
        service_id: "",
        service_type_id: "",
        total: 0,
    };

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
        let email = $("#email").val();
        let address = $("#address").val();
        let note = $("#order_note").val();
        let payment = $("#payment").val();
        let cartIds = []; // Initialize an array to store the values
        let province = $("#province").find(":selected").text();
        let district = $("#district").find(":selected").text();
        let ward = $("#ward").find(":selected").text();
        if (address === '' || ward === '' || district === '' || province === '') {
            displayToastNotification('Vui lòng nhập đầy đủ địa chỉ', 'error');
            return;
        }
        else {

            const addressInfo = `${address}, ${ward}, ${district}, ${province}`;

            $(".cart_id").each(function () {
                cartIds.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: path + "/cart/handleCheckout",
                data: {

                    user_id: user_id,
                    phone: phone,
                    fullname: fullname,
                    address: addressInfo,
                    email: email,
                    note: note,
                    total_price: locationInfo.total,
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
                        Object.keys(locationInfo).forEach(key => {
                            locationInfo[key] = null; // hoặc locationInfo[key] = undefined;
                        });

                        if (payment == 2) {
                            setTimeout(() => {
                                window.location.href = path + `/cart/handlePayment?order_id=${response.data.order_id}&total=${response.data.total_price}&order_code=${response.data.order_code.slice(1)}`;
                            }, 2000)
                        }
                        else {
                            setTimeout(() => {
                                window.location.href = path;
                            }, 2000)
                        }

                    }
                },
                error: function (xhr, status, error) {
                    $("#bg_loading").hide();
                    // Xử lý lỗi AJAX (nếu có)
                    console.error("Lỗi AJAX: " + status + " - " + error);
                }
            });
        }

    });
    // Get gee GHN
    var apiKey = "7293aab0-b9b0-11ee-b38e-f6f098158c7e";
    var apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/master-data/";
    function fetchProvinceData() {

        $.ajax({
            url: apiUrl + "province",
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
        let container = $("#provinceContainer");
        let selectProvince = $("<select id='province' class='country_option nice-select wide'></select>");
        selectProvince.style = "margin-bottom: 12px;";
        selectProvince.append('<option value="" selected>--chọn tỉnh--</option>');

        provinceData.forEach(function (province) {
            selectProvince.append('<option value="' + province.ProvinceID + '">' + province.ProvinceName + "</option>");
        });

        container.append(selectProvince);
        locationInfo.province = '';
        // // Set up event listener for province change
        selectProvince.on("change", function () {
            renderDistrictsDropdown([]);
            renderWardsDropdown([]);
            var selectedProvinceId = $(this).val();
            if (selectedProvinceId) {
                locationInfo.province = selectedProvinceId;
                fetchDistrictsData(selectedProvinceId);
            } else {
                renderDistrictsDropdown([]);
                renderWardsDropdown([]);
            }
        });
    }
    function fetchDistrictsData(provinceId) {
        $.ajax({
            url: apiUrl + "district",
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Token: apiKey,
            },
            data: {
                province_id: provinceId,
            },
            success: function (data) {
                renderDistrictsDropdown(data.data);
            },
            error: function (error) {
                console.error("Error fetching district data:", error);
            },
        });
    }
    function renderDistrictsDropdown(districtsData) {
        let container = $("#districtContainer");
        container.empty();
        var selectDistricts = $("<select id='district' class='country_option nice-select wide'></select>");

        selectDistricts.append('<option value="" selected>--chọn huyện--</option>');
        selectDistricts.style = "margin-bottom: 12px;";
        districtsData.forEach(function (district) {
            selectDistricts.append('<option value="' + district.DistrictID + '">' + district.DistrictName + "</option>");
        });
        container.append(selectDistricts);

        locationInfo.district = '';
        // Set up event listener for district change
        selectDistricts.on("change", function () {
            var selectedDistrictId = $(this).val();
            renderWardsDropdown([]);

            if (selectedDistrictId) {
                locationInfo.district = selectedDistrictId;
                fetchWardsData(selectedDistrictId);
            } else {
                // If no district selected, clear wards dropdown
                renderWardsDropdown([]);
            }
        });
    }
    function fetchWardsData(districtId) {
        $.ajax({
            url: apiUrl + "ward",
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Token: apiKey,
            },
            data: {
                district_id: districtId,
            },
            success: function (data) {
                renderWardsDropdown(data.data);
            },
            error: function (error) {
                console.error("Error fetching ward data:", error);
            },
        });
    }
    function renderWardsDropdown(wardsData) {
        let container = $("#wardContainer");
        container.empty();
        var selectWards = $("<select id='ward' class='country_option nice-select wide'></select>");
        selectWards.style = "margin-bottom: 12px;";
        selectWards.append('<option value="" selected>--chọn xã--</option>');

        wardsData.forEach(function (ward) {
            selectWards.append('<option value="' + ward.WardCode + '">' + ward.WardName + "</option>");
        });
        container.append(selectWards);
        selectWards.on("change", function () {
            let selectedWardId = $(this).val();
            console.log(selectWards);
            if (selectedWardId) {
                locationInfo.ward = selectedWardId;
                fetchService(locationInfo.district);
            }
        });
    }
    function fetchService(districtId) {
        let apiService = "https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/available-services";
        $.ajax({
            url: apiService,
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Token: apiKey,
            },
            data: {
                shop_id: 2506771,
                from_district: 1788,
                to_district: districtId,
            },
            success: function (data) {
                if (data.data && data.data.length > 0) {
                    const firstService = data.data[0];
                    locationInfo.service_id = firstService.service_id;
                    locationInfo.service_type_id = firstService.service_type_id;
                    fetchFee(locationInfo.ward, locationInfo.district, locationInfo.service_id);
                } else {
                    console.error("No available services found.");
                    callback(null); // or handle the absence of services in another way
                }
            },
            error: function (error) {
                console.error("Error fetching service data:", error);
                callback(null);
            },
        });
    }
    function fetchFee(ward, district, serviceId) {
        let apiService = "https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee";
        console.log(district, ward, serviceId);
        $.ajax({
            url: apiService,
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Token: apiKey,
            },
            data: {
                from_district_id: 1788,
                // from_ward_code: "21211",
                service_id: serviceId,
                // service_type_id: null,
                to_district_id: district,
                to_ward_code: ward,
                " height": 50,
                " length": 20,
                weight: 200,
                " width": 20,
                insurance_value: 0,
                // cod_failed_amount: 2000,
                // coupon: null
            },
            success: function (data) {
                renderFee(data.data.total);
            },
            error: function (error) {
                console.error("Error fetching ward data:", error);
            },
        });
    }
    function renderFee(fee) {
        let feeHtml = $("#GHNFee");
        feeHtml.empty();

        // Lấy giá trị firstTotal và chuyển đổi thành số
        let firstTotal = $("#firstTotal").text();
        let firstTotalValue = parseFloat(firstTotal.replace(/[₫,.]/g, ""));


        // Đảm bảo 'fee' đã được định nghĩa trước khi sử dụng
        let total = firstTotalValue + fee;
        locationInfo.total = total;
        // Định dạng lại fee và hiển thị
        let numberFormat = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        });
        let formattedFee = numberFormat.format(fee);
        formattedFee = formattedFee.replace('₫', "VND");

        feeHtml.text(formattedFee);

        // Định dạng lại total và hiển thị
        let formattedTotal = total.toLocaleString("vi-VN", { style: "currency", currency: "VND" });
        formattedTotal = formattedTotal.replace('₫', "VND");
        console.log(formattedTotal);
        $("#endTotal").empty().text(formattedTotal);
    }


    fetchProvinceData();
});