document.getElementById('productFormAdd').addEventListener(
    'submit', function (e) {
        let name = document.getElementById('name');
        let price = document.getElementById('price');
        let description = document.getElementById('description');
        let image = document.getElementById('image');

        let hasError = false;

        let name_error = document.getElementById('name_error');
        let price_error = document.getElementById('price_error');
        let description_error = document.getElementById('description_error');
        let image_error = document.getElementById('image_error');

        if (image.files.length === 0) {
            image_error.innerHTML = "image is required";
            hasError = true;
        } else if (!image.files[0].type.startsWith('image/')) {
            image_error.innerHTML = "please choose an image type";
            hasError = true;
        } else {
            image_error.innerHTML = '';
        }

        if(name.value.trim().length <= 0 || !name.value){
            name_error.innerHTML = "Name is required";
            hasError = true;
        } else {
            name_error.innerHTML = '';
        }

        if(description.value.trim().length < 20 || !description.value){
            description_error.innerHTML = "Description must contains at least 20 caracters";
            hasError = true;
        } else {
            name_error.innerHTML = '';
        }

        if(price.value <= 0 || !price.value){
            price_error.innerHTML = "Price is required and must be greater then 0";
            hasError = true;
        } else {
            price_error.innerHTML = '';
        }

        if(hasError) e.preventDefault();
    }
);