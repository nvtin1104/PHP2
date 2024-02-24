$(document).ready(function () {
    let ward = "";
    let district = "";
    let service_id = "";
    let service_type_id = "";
    function fetchProvinceData() {
        ward = "";
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

    function fetchDistrictsData(provinceId) {
        ward = "";
        var apiUrl =
            "https://online-gateway.ghn.vn/shiip/public-api/master-data/district";
        var apiKey = "7293aab0-b9b0-11ee-b38e-f6f098158c7e"; // Replace with your actual API key

        $.ajax({
            url: apiUrl,
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
    function fetchFee(ward, district, serviceId) {
        var apiUrl =
            "https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee";
        var apiKey = "7293aab0-b9b0-11ee-b38e-f6f098158c7e"; // Replace with your actual API key

        console.log(district, ward, serviceId);
        $.ajax({
            url: apiUrl,
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
                // console.log(data.data.total);
            },
            error: function (error) {
                console.error("Error fetching ward data:", error);
            },
        });
    }
    function fetchWardsData(districtId) {
        var apiUrl =
            "https://online-gateway.ghn.vn/shiip/public-api/master-data/ward";
        var apiKey = "7293aab0-b9b0-11ee-b38e-f6f098158c7e"; // Replace with your actual API key

        $.ajax({
            url: apiUrl,
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

    function renderProvinceDropdown(provinceData) {
        var selectProvince = $("#province");
        selectProvince.empty();
        selectProvince.append(
            '<option value="" selected>--chọn tỉnh--</option>'
        );

        provinceData.forEach(function (province) {
            selectProvince.append(
                '<option value="' +
                province.ProvinceID +
                '">' +
                province.ProvinceName +
                "</option>"
            );
        });

        // Set up event listener for province change
        selectProvince.on("change", function () {
            var selectedProvinceId = $(this).val();
            if (selectedProvinceId) {
                fetchDistrictsData(selectedProvinceId);
            } else {
                // If no province selected, clear districts and wards dropdowns
                renderDistrictsDropdown([]);
                renderWardsDropdown([]);
            }
        });
    }
    function renderFee(fee) {
        var feeHtml = $("#GHNfee");
        var numberFormat = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        });
        var formattedValue = document.getElementById("firstTotal").innerText;
        var firstTotalValue = parseFloat(formattedValue.replace(/,/g, ""));
        var total = firstTotalValue + fee; // Sửa đổi dòng này để thêm fee vào firstTotalValue
        //    console.log(total);
        var formattedFee = numberFormat.format(fee);
        feeHtml.text(formattedFee);
        $(".total").text(numberFormat.format(total));
        var formattedTotal = numberFormat.format(total);
        var numericValue = formattedTotal.replace(/\D/g, "");
        $("#yourInputId").val(numericValue);
    }


    function renderDistrictsDropdown(districtsData) {
        var selectDistricts = $("#districts");
        selectDistricts.empty();
        selectDistricts.append(
            '<option value="" selected>--chọn quận/huyện--</option>'
        );

        districtsData.forEach(function (district) {
            selectDistricts.append(
                '<option value="' +
                district.DistrictID +
                '">' +
                district.DistrictName +
                "</option>"
            );
        });

        // Set up event listener for district change
        selectDistricts.on("change", function () {
            var selectedDistrictId = $(this).val();
            if (selectedDistrictId) {
                district = selectedDistrictId;
                fetchWardsData(selectedDistrictId);
            } else {
                // If no district selected, clear wards dropdown
                renderWardsDropdown([]);
            }
        });
    }

    function renderWardsDropdown(wardsData) {
        ward = "";

        var selectWards = $("#ward");
        selectWards.empty();
        selectWards.append(
            '<option value="" selected>--chọn phường/xã--</option>'
        );
        // selectWards.on("click", fetchFree());
        wardsData.forEach(function (ward) {
            selectWards.append(
                '<option value="' +
                ward.WardCode +
                '">' +
                ward.WardName +
                "</option>"
            );
        });
        selectWards.on("change", function () {
            ward = $(this).val();
        });
    }
    function fetchService(districtId) {
        service_id = "";
        service_type_id = "";
        var apiUrl =
            "https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/available-services";
        var apiKey = "7293aab0-b9b0-11ee-b38e-f6f098158c7e"; // Replace with your actual API key
        // console.log(districtId);
        $.ajax({
            url: apiUrl,
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                Token: apiKey,
            },
            data: {
                shop_id: 4868495,
                from_district: 1788,
                to_district: districtId,
            },
            success: function (data) {
                if (data.data && data.data.length > 0) {
                    const firstService = data.data[0];
                    // console.log(firstService, ward, district);
                    const retrievedServiceId = firstService.service_id;
                    fetchFee(ward, district, retrievedServiceId);
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

    let btnBaoGia = $("#baogia");
    btnBaoGia.on("click", () => {
        if (ward !== "") {
            fetchService(district)
            fetchFee(ward, district, serviceId);
            // console.log(ward, district, serviceId);

            // Handle the case when serviceId is null or not available
        }

    });

    // Call the fetchProvinceData function to initiate the data fetching
    fetchProvinceData();
});
const apiDataUrl = "https://online-gateway.ghn.vn/shiip/public-api/master-data";
const apiKey = "7293aab0-b9b0-11ee-b38e-f6f098158c7e"; // Replace with your actual API key

const fetchProvinceData = () => {
    $.ajax({
        url: apiDataUrl + "/province",
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Token: apiKey,
        },
        success: function (data) {
            console.log("Province data:", data);
        },
        error: function (error) {
            console.error("Error fetching province data:", error);
        },
    });
}
export default { fetchProvinceData };