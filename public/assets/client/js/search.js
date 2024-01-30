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
            let matchingEmails = [];
            dataResponse.forEach((item) => {
                if (item.email.toLowerCase().includes(searchValue.toLowerCase())) {
                    matchingEmails.push(item.email);
                }
            });

            // Tạo một phần tử <select> mới
            let selectElement = $('<ul>');

            // Thêm tùy chọn vào phần tử <select>
            matchingEmails.forEach((email) => {
                let optionElement = $('<li>');
                let aElement = $('<a>').text(email);
                aElement.attr('href', route + '/product/search/' + email);
                optionElement.append(aElement);
                optionElement.attr('value', email);
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
