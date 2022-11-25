
// Admin panel login form validation
function validateLoginForm() {
    const username = document.admin_login.username;
    const password = document.admin_login.password;
    let notError = true;

    if (username.value.trim() === "") {
        setLoginError(username, "نام کاربری یا ایمیل نمی‌تواند خالی باشد.");
        notError = false;
    } 
    if (password.value.trim() === "") {
        setLoginError(password, "رمز عبور نمی‌تواند خالی باشد.");
        notError = false;
    }
    return notError;
}

function setLoginError(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector("small span");

    small.innerText = message;
    formControl.className = "form-control error";
}

// Showing uplaoded img file 
const imgInps = document.querySelectorAll('.form-group input[type="file"]');
for (let imgInp of imgInps) {
    imgInp.onchange = (evt) => {
        const [file] = imgInp.files;
        if (file) {
            const label_inp = imgInp.nextElementSibling;
            label_inp.style.display = "none";
            label_inp.nextElementSibling.style.display = "flex";
            label_inp.nextElementSibling.querySelector("img").src = URL.createObjectURL(file);
        }
    };
}

// Product form validation
function validateFormProduct() {
    const formError = document.getElementById("add_product_error");
    const checked = document.querySelectorAll("input[type=checkbox]:checked").length;
    // const hasError = true;
    let hasError = true;

    if (document.form_product.title.value.trim() == "") {
        formError.querySelector("span").innerHTML = "فیلد نام محصول نباید خالی باشد.";
        document.form_product.title.focus();
    } else if (document.form_product.price.value.trim() == "") {
        formError.querySelector("span").innerHTML = "فیلد قیمت نباید خالی باشد.";
        document.form_product.price.focus();
    } else if (document.form_product.category.value.trim() == "") {
        formError.querySelector("span").innerHTML = "دسته بندی مورد نظر را انتخاب کنید.";
    } else if (!checked) {
        formError.querySelector("span").innerHTML = "حداقل یک رنگ باید انتخاب کنید.";
    } else if (document.form_product.description.value.trim() == "") {
        formError.querySelector("span").innerHTML = "فیلد توضیحات نباید خالی باشد.";
        document.form_product.description.focus();
    } else if (formError.classList.contains("checkImage")) {
        if (document.form_product.image.value.trim() == "") {
            formError.querySelector("span").innerHTML = "محصول باید عکس اصلی داشته باشد.";
        } else {
            hasError = false;
        }
    } else {
        hasError = false;
    }

    if (hasError) {
        formError.style.display = "block";
        window.scrollTo(0, 0);
        return false;
    } else {
        return true;
    }
}

// $(".table-container .card-body").scroll(function () {
//     $(".table-container .card-body").width($(".table-container .card-body").scrollLeft());
// });

// function validateForm() {
//     let title = document.forms["add_product"]["title"].value;
//     let price = document.forms["add_product"]["price"].value;
//     let description = document.forms["add_product"]["description"].value;

//     if (title == "") {
//         alert("این فیلد نباید خالی باشد!");
//         title.setCustomValidity("این فیلد نباید خالی باشد!");
//         title.reportValidity();
//         return false;
//     } else if (price == "") {
//         price.setCustomValidity("این فیلد نباید خالی باشد!");
//         price.reportValidity();
//         return false;
//     } else if (description == "") {
//         description.setCustomValidity("این فیلد نباید خالی باشد!");
//         description.reportValidity();
//         return false;
//     }
// }

// const title = document.forms["add_product"]["title"];
// const price = document.forms["add_product"]["price"];
// const description = document.forms["add_product"]["description"];
// const title = document.getElementById('title');
// const form_add_product = document.getElementById('add_product');
// const error_add_product = document.getElementById('error');

// form_add_product.addEventListener('submit', (e) => {
//     let messages = [];
//     if (title.value === '' || title.value == null) {
//         messages.push('فیلد نام محصول نباید خالی باشد.');
//     }

//     if (messages.length > 0){
//         e.preventDefault();
//         error_add_product.innerText = messages.join(', ');
//     }
// })
