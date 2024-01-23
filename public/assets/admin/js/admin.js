function previewImage(input, imageId, display = false) {
    var preview = document.getElementById(imageId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = display ? 'block' : 'none';
    }
}
function confirmDelete(deleteUrl) {
    // Display a confirmation dialog
    if (confirm('Bạn có chắc xóa bài viết này?')) {
        // If user clicks OK, redirect to the delete URL
        window.location.href = deleteUrl;
    }
    // If user clicks Cancel, do nothing
}

