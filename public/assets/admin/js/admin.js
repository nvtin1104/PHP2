function previewMultipleImages(input) {
    var imagesPreview = document.getElementById('image_previews');
    imagesPreview.innerHTML = '';

    if (input.files) {
        var filesAmount = input.files.length;
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(event) {
                var img = document.createElement('img');
                img.src = event.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                imagesPreview.appendChild(img);
            }

            reader.readAsDataURL(input.files[i]);
        }
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

