$(document).ready(async function () {
    let route = $('#root-route').data('route');

    const fetchData = async () => {
        try {
            const response = await fetch(route + '/product/data_search');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };
    const dataResponse = await fetchData();
    console.log(dataResponse);
    let search = $('#search-input');
    let typingTimer;
    let doneTypingInterval = 1000; // Thời gian chờ sau khi ngừng nhập, tính bằng mili giây

    // Khi người dùng nhập vào ô tìm kiếm
    search.on('input', () => {
        // Xóa bộ đếm thời gian nếu có
        clearTimeout(typingTimer);

        // Bắt đầu bộ đếm thời gian mới
        typingTimer = setTimeout(() => {
            let searchValue = search.val();
            let matchingProducts = [];
            dataResponse.forEach((item) => {
                if (item.product_name.toLowerCase().includes(searchValue.toLowerCase())) {
                    matchingProducts.push(item.product_name);
                }
            });

            // Tạo một phần tử <select> mới
            let selectElement = $('<ul>');

            // Thêm tùy chọn vào phần tử <select>
            matchingProducts.forEach((product_name) => {
                let optionElement = $('<li>');
                let aElement = $('<a>').text(product_name);
                aElement.attr('href', route + '/product/search/' + product_name);
                optionElement.append(aElement);
                optionElement.attr('value', product_name);
                selectElement.append(optionElement);
            });

            // Đặt id cho phần tử <select>
            selectElement.attr('id', 'matching-emails-select');

            // Đặt tên cho phần tử <select>
            selectElement.attr('name', 'matching-emails');
            console.log(selectElement);
            // Đưa phần tử <select> vào DOM
            $('#select-search').append(selectElement);

        }, doneTypingInterval);
    });



});
