function previewImages(event, inputName) {
    var previewContainer = document.getElementById('preview-container-' + inputName);
    previewContainer.innerHTML = ''; // Clear previous previews

    var files = event.target.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (!file.type.startsWith('image/')) {
            continue;
        }

        var img = document.createElement('img');
        img.classList.add('preview-image');
        img.file = file;

        var reader = new FileReader();
        reader.onload = (function(aImg) {
            return function(e) {
                aImg.src = e.target.result;
            };
        })(img);
        reader.readAsDataURL(file);

        previewContainer.appendChild(img);
    }
}

