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
    let typingTimer = 200;
    let doneTypingInterval = 500; // Thời gian chờ sau khi ngừng nhập, tính bằng mili giây

    // Khi người dùng nhập vào ô tìm kiếm
    search.on('input', () => {
        // Xóa bộ đếm thời gian nếu có
        clearTimeout(typingTimer);

        // Bắt đầu bộ đếm thời gian mới
        typingTimer = setTimeout(() => {
            let searchValue = search.val();
            let matchingProducts = [];
            dataResponse.forEach((item) => {
                let product = {};
                if (item.product_name.toLowerCase().includes(searchValue.toLowerCase())) {
                    product.name = item.product_name;
                    product.id = item.id;
                    product.thumbnail = item.thumbnail;
                    matchingProducts.push(product);
                }
            });
            if (matchingProducts.length === 0) {
                let product = {};
                product.name = 'Không tìm thấy sản phẩm nào phù hợp với từ khóa tìm kiếm của bạn!';
                product.id = '#';
                product.thumbnail = '#';
                matchingProducts.push(product);
            }
            // Tạo một phần tử <select> mới
            let selectElement = $('<ul>');

            // Thêm tùy chọn vào phần tử <select>
            matchingProducts.forEach((product) => {
                let urlImg = product.thumbnail;
                console.log(product.thumbnail)// Thay thế bằng route thực tế của bạn
                if (urlImg.includes('upload')) {
                    urlImg = route + urlImg;
                }

                let optionElement = $('<li>');
                let imgElement;
                product.id !== '#' ? imgElement = $('<img>').attr('src', urlImg) : imgElement = '';
                if (imgElement !== '') {
                    imgElement.css({
                        'width': '50px',
                        'height': '50px',
                        'margin': '10px'
                    });
                }
                optionElement.append(imgElement);
                let aElement = $('<a>').text(product.name);
                product.id === '#' ? '' : aElement.attr('href', route + '/product/detail?id=' + product.id);
                optionElement.append(aElement);

                optionElement.attr('value', product.name);
                selectElement.append(optionElement);
            });

            // Đặt id cho phần tử <select>
            selectElement.attr('id', 'matching-emails-select');

            // Đặt tên cho phần tử <select>
            selectElement.attr('name', 'matching-emails');
            // Đưa phần tử <select> vào DOM
            $('#select-search').empty();
            $('#select-search').css({
                'padding': '32px'
            });
            $('#select-search').append(selectElement);

        }, doneTypingInterval);
    });



});
