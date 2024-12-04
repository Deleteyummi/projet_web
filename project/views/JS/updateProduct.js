document.getElementById('updateProductForm').addEventListener(
    'submit', function (e) {
        let name = document.getElementById('name_update');
        let price = document.getElementById('price_update');
        let description = document.getElementById('description_update');
        let image = document.getElementById('image_update');

        let hasError = false;

        let name_error = document.getElementById('name_error_update');
        let price_error = document.getElementById('price_error_update');
        let description_error = document.getElementById('description_error_update');
        let image_error = document.getElementById('image_error_update');

        if (image.files.length > 0) {
            if (!image.files[0].type.startsWith('image/')) {
                image_error.innerHTML = "please choose an image type";
                hasError = true;
            }
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
            description_error.innerHTML = '';
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