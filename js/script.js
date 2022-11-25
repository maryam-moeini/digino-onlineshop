// Back to top button
var backtop = document.getElementById("backtop");

$(window).on("load", function () {
    $(".loading").fadeOut();
});

$(".sidebar-toggle-container label").click(function () {
    $(this).find("i").toggleClass("fa-angle-down fa-angle-up");
});

// When user scrolls down 80px from the top of the document, show the button
window.onscroll = function () {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        backtop.classList.add("visible");
    } else {
        backtop.classList.remove("visible");
    }
};

// opening search bar
const searchContainer = document.querySelector(".search-container");
function openSearch() {
    searchContainer.style.display = "flex";
}
const searchIcon = document.querySelector(".open-search");
searchIcon.addEventListener("click", openSearch, false);

// search enter keyword
const searchInput = document.querySelector(".search-bar input");
searchInput.addEventListener("keyup", function (event) {
    if (event.keyCode === 13) {
        document.search.submit();
    }
});

// click anywhere to close search bar
window.onclick = function (event) {
    if (event.target == searchContainer) {
        searchContainer.style.display = "none";
    }
};

//  Toggle menu on mobile view
const toggle = document.querySelector(".toggle");
const menu = document.querySelector(".menu");
const nav = document.querySelector("nav");
const openNav = document.querySelector(".open-nav");
const closeNav = document.querySelector(".close-nav");
const main = document.querySelector("main");
const footer = document.querySelector("footer");

function toggleMenu() {
    if (nav.classList.contains("active")) {
        nav.classList.remove("active");
        closeNav.style.display = "none";
        openNav.style.display = "block";
        main.style.display = "block";
        footer.style.display = "block";
    } else {
        nav.classList.add("active");
        openNav.style.display = "none";
        closeNav.style.display = "block";
        main.style.display = "none";
        footer.style.display = "none";
    }
}

openNav.addEventListener("click", toggleMenu, false);
closeNav.addEventListener("click", toggleMenu, false);

/* Activate Submenu */
const submenu_items = document.querySelectorAll(".has-submenu");

function toggleItem() {
    if (this.classList.contains("submenu-active")) {
        this.classList.remove("submenu-active");

        // If another submenu is open, it will close it
    } else if (nav.querySelector(".submenu-active")) {
        nav.querySelector(".submenu-active").classList.remove("submenu-active");
        this.classList.add("submenu-active");
    } else {
        this.classList.add("submenu-active");
    }
}

/* Event Listeners */
for (let item of submenu_items) {
    if (item.querySelector(".submenu")) {
        item.addEventListener("click", toggleItem, false);
        item.addEventListener("keypress", toggleItem, false);
    }
}

/* Close Submenu From Anywhere */
function closeSubmenu(e) {
    let isClickInside = nav.contains(e.target);

    if (!isClickInside && nav.querySelector(".submenu-active")) {
        nav.querySelector(".submenu-active").classList.remove("submenu-active");
    }
}
document.addEventListener("click", closeSubmenu, false);

//  Accordion in footer in mobile view
const accordion_footer = document.getElementsByClassName("accordion");

for (let i = 0; i < accordion_footer.length; i++) {
    accordion_footer[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var footer_panel = this.nextElementSibling;
        if (footer_panel.style.maxHeight) {
            footer_panel.style.maxHeight = null;
        } else {
            footer_panel.style.maxHeight = footer_panel.scrollHeight + "px";
        }
    });
}

// switch view of products list
const views = document.querySelectorAll(".view");
const productsView = document.querySelector(".products-view");

for (let view of views) {
    view.addEventListener("click", function () {
        if (view.classList.contains("list-view")) {
            view.classList.add("active");
            view.previousElementSibling.classList.remove("active");
            productsView.classList.add("products-list");
        } else if (view.classList.contains("grid-view")) {
            view.classList.add("active");
            view.nextElementSibling.classList.remove("active");
            productsView.classList.remove("products-list");
        }
    });
}

// Zoom product image
$(document).ready(function () {
    var native_width = 0;
    var native_height = 0;

    if ($(window).width() > 576) {
        //Now the mousemove function
        $(".product-mainimg").mousemove(function (e) {
            //When the user hovers on the image, the script will first calculate
            //the native dimensions if they don't exist. Only after the native dimensions
            //are available, the script will show the zoomed version.
            if (!native_width && !native_height) {
                //This will create a new image object with the same image as that in .main-img
                //We cannot directly get the dimensions from .main-img because of the
                //width specified. To get the actual dimensions we have
                //created this image object.
                var image_object = new Image();
                image_object.src = $(".main-img.active").attr("src");

                //This code is wrapped in the .load function which is important.
                //width and height of the object would return 0 if accessed before
                //the image gets loaded.
                native_width = image_object.width;
                native_height = image_object.height;
            } else {
                //x/y coordinates of the mouse
                //This is the position of .magnify with respect to the document.
                var magnify_offset = $(this).offset();
                //We will deduct the positions of .magnify from the mouse positions with
                //respect to the document to get the mouse positions with respect to the
                //container(.magnify)
                var mx = e.pageX - magnify_offset.left;
                var my = e.pageY - magnify_offset.top;

                //Finally the code to fade out the glass if the mouse is outside the container
                if (mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0) {
                    $(".zoom.active").fadeIn(100);
                } else {
                    $(".zoom.active").fadeOut(100);
                }
                if ($(".zoom.active").is(":visible")) {
                    //The background position of .zoom will be changed according to the position
                    //of the mouse over the .main-img image. So we will get the ratio of the pixel
                    //under the mouse pointer with respect to the image and use that to position the
                    //large image inside the magnifying glass
                    var rx =
                        Math.round(
                            (mx / $(".main-img.active").width()) * native_width -
                                $(".zoom.active").width() / 2
                        ) * -1;
                    var ry =
                        Math.round(
                            (my / $(".main-img.active").height()) * native_height -
                                $(".zoom.active").height() / 2
                        ) * -1;
                    var bgp = rx + "px " + ry + "px";

                    //Time to move the magnifying glass with the mouse
                    var px = mx - $(".zoom.active").width() / 2;
                    var py = my - $(".zoom.active").height() / 2;
                    //Now the glass moves with the mouse
                    //The logic is to deduct half of the glass's width and height from the
                    //mouse coordinates to place it with its center at the mouse coordinates

                    //If you hover on the image now, you should see the magnifying glass in action
                    $(".zoom.active").css({ left: px, top: py, backgroundPosition: bgp });
                }
            }
        });
    }
});

// Single product page slideshow
const imagesZoom = document.getElementsByClassName("zoom");
const productImages = document.getElementsByClassName("main-img");
function currentImage(imgindex) {
    for (let imageZoom of imagesZoom) {
        imageZoom.classList.remove("active");
    }
    for (let productImage of productImages) {
        productImage.classList.remove("active");
    }
    // console.log(imagesZoom[imgindex]);
    imagesZoom[imgindex].classList.add("active");
    productImages[imgindex].classList.add("active");
}

// Checked first color of product
document.singleProduct.color[0].checked = true;

// Show name of the checked color
const selectedColor = document.querySelector(".selected-color");
const currentColor = document.querySelector('.p-colors input[name="color"]:checked').value;
selectedColor.innerHTML = currentColor;
const productColors = document.querySelectorAll('.p-colors input[name="color"]');
for (let productColor of productColors) {
    productColor.addEventListener("click", function () {
        if (productColor.checked) {
            selectedColor.innerHTML = productColor.value;
        }
    });
}

// Increase number of products button
function increaseCount(a, b) {
    var input = b.nextElementSibling;
    var value = parseInt(input.value, 10);
    if (value < 9) {
        // value = isNaN(value) ? 0 : value;
        value++;
        input.value = value;
    }
}
// Decrease number of products button
function decreaseCount(a, b) {
    var input = b.previousElementSibling;
    var value = parseInt(input.value, 10);
    if (value > 1) {
        value--;
        input.value = value;
    }
}

// Going to review section in productpage
function goToReview() {
    document.getElementById("tab-2").checked = true;
    document.getElementById("reviews").scrollIntoView();
}
// Going to add review section in productpage
function goToAddReview() {
    document.getElementById("tab-2").checked = true;
    document.getElementById("add-review").scrollIntoView();
}

// Thumps up & down count
function clickThump(e) {
    var clicks = parseInt(e.nextElementSibling.innerHTML);
    if (
        e.querySelector("i").classList.contains("far") ||
        e.querySelector("i").classList.contains("far")
    ) {
        clicks += 1;
    } else {
        clicks -= 1;
    }
    e.nextElementSibling.innerHTML = clicks;
}

$(".review-like").click(function () {
    $(this).find("i").toggleClass("far fas");
});
$(".review-dislike").click(function () {
    $(this).find("i").toggleClass("far fas");
});

// Contact form validation
function validateContactForm() {
    const formError = document.getElementById("contact-form-errormessage");
    let hasError = true;

    if (document.contact_form.subject.value.trim() == "") {
        formError.innerHTML = "فیلد موضوع نمی‌تواند خالی باشد.";
        document.contact_form.subject.focus();
    } else if (document.contact_form.name.value.trim() == "") {
        formError.innerHTML = "فیلد نام‌ و نام‌خانوادگی نمی‌تواند خالی باشد.";
        document.contact_form.name.focus();
    } else if (document.contact_form.email.value.trim() == "") {
        formError.innerHTML = "فیلد ایمیل نمی‌تواند خالی باشد.";
        document.contact_form.email.focus();
    } else if (document.contact_form.phone.value.trim() == "") {
        formError.innerHTML = "فیلد شماره تماس نمی‌تواند خالی باشد.";
        document.contact_form.phone.focus();
    } else if (document.contact_form.message.value.trim() == "") {
        formError.innerHTML = "فیلد پیام نمی‌تواند خالی باشد.";
        document.contact_form.message.focus();
    } else {
        hasError = false;
    }

    if (hasError) {
        formError.parentElement.parentElement.style.display = "block";
        return false;
    } else {
        return true;
    }
}

// Signup and Login form validation
function setError(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector("small");

    small.innerText = message;
    formControl.className = "form-control error";
}

function unsetError(input) {
    const formControl = input.parentElement;
    formControl.className = "form-control";
}

// function setSuccessFor(input) {
//     const formControl = input.parentElement;
//     formControl.className = "form-control success";
// }

// Signup form validation
function validateSignupForm() {
    const username = document.signup.username;
    const email = document.signup.email;
    const password = document.signup.password;
    const password2 = document.signup.password2;
    const usernamePattern = "^([a-z][0-9]*)+$";
    const passwordPattern = "^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$";
    let notError = true;

    if (username.value.trim() === "") {
        setError(username, "نام کاربری نمی‌تواند خالی باشد.");
        notError = false;
    } else if (username.value.trim().length < 4 || username.value.trim().length > 25) {
        setError(username, "نام کاربری باید بین ۴ تا ۲۵ کاراکتر باشد.");
        notError = false;
    } else if (!username.value.match(usernamePattern)) {
        setError(username, "نام کاربری فقط می‌تواند شامل حروف کوچک انگلیسی و اعداد انگلیسی باشد.");
        notError = false;
    } else {
        unsetError(username);
    }

    if (email.value.trim() === "") {
        setError(email, "ایمیل نمی‌تواند خالی باشد.");
        notError = false;
    } else {
        unsetError(email);
    }

    if (password.value.trim() === "") {
        setError(password, "رمز عبور نمی‌تواند خالی باشد.");
        notError = false;
    } else if (password.value.trim().length < 8 || password.value.trim().length > 25) {
        setError(password, "رمز عبور باید بین ۸ تا ۲۵ کاراکتر باشد.");
        notError = false;
    } else if (!password.value.match(passwordPattern)) {
        setError(
            password,
            "رمز عبور باید حداقل دارای یک عدد، یک حرف کوچک و یک حرف بزرگ انگلیسی باشد."
        );
        notError = false;
    } else {
        unsetError(password);
    }

    if (password2.value.trim() === "") {
        setError(password2, "تکرار رمز عبور نمی‌تواند خالی باشد.");
        notError = false;
    } else if (password.value.trim() !== password2.value.trim()) {
        setError(password2, "تکرار رمز عبور صحیح نمی باشد.");
        notError = false;
    } else {
        unsetError(password2);
    }

    return notError;
}

// Login form validation
function validateLoginForm() {
    const username = document.login.username;
    const password = document.login.password;
    let notError = true;

    if (username.value.trim() === "") {
        setError(username, "نام کاربری یا ایمیل نمی‌تواند خالی باشد.");
        notError = false;
    } else {
        unsetError(username);
    }

    if (password.value.trim() === "") {
        setError(password, "رمز عبور نمی‌تواند خالی باشد.");
        notError = false;
    } else if (password.value.trim().length < 8) {
        setError(password, "رمز عبور نمی‌تواند کمتر از ۸ کاراکتر باشد.");
        notError = false;
    } else {
        unsetError(password);
    }

    return notError;
}

function validateProfileForm() {
    const formError = document.querySelector(".profile-error span");
    const username = document.account_info.username;
    const email = document.account_info.email;
    const phone = document.account_info.phone;
    const usernamePattern = "^([a-z][0-9]*)+$";
    let hasError = true;

    if (username.value.trim() == "") {
        formError.innerHTML = "فیلد نام کاربری نمی‌تواند خالی باشد.";
        username.parentElement.classList = "account-info-item focus";
        username.focus();
    } else if (username.value.length < 4 || username.value.length > 25) {
        formError.innerHTML = "نام کاربری باید بین ۴ تا ۲۵ کاراکتر باشد.";
        username.parentElement.classList = "account-info-item focus";
        username.focus();
    } else if (!username.value.match(usernamePattern)) {
        formError.innerHTML =
            "نام کاربری فقط می‌تواند شامل حروف کوچک انگلیسی و اعداد انگلیسی باشد.";
        username.parentElement.classList = "account-info-item focus";
        username.focus();
    } else if (email.value.trim() == "") {
        formError.innerHTML = "فیلد ایمیل نمی‌تواند خالی باشد.";
        email.parentElement.classList = "account-info-item focus";
        email.focus();
    } else if (phone.value.length < 11 && phone.value.trim().length != 0) {
        formError.innerHTML = "شماره تماس صحیح نمی‌باشد.";
        phone.parentElement.classList = "account-info-item focus";
        phone.focus();
    } else {
        hasError = false;
    }

    if (hasError) {
        formError.parentElement.style.display = "block";
        return false;
    } else {
        return true;
    }
}

function setErrorProfileForm(error_name) {
    const formError = document.querySelector(".profile-error span");
    const username = document.account_info.username;
    const email = document.account_info.email;
    if (error_name == "username") {
        formError.innerHTML = "نام کاربری وارد شده قبلاً ثبت شده است.";
        username.parentElement.classList = "account-info-item focus";
        username.focus();
    } else {
        formError.innerHTML = "ایمیل وارد شده قبلاً ثبت شده است.";
        email.parentElement.classList = "account-info-item focus";
        email.focus();
    }
    formError.parentElement.style.display = "block";
    document.account_info.submit = false;
}

function validatePasswordForm() {
    const formError = document.querySelector(".profile-error span");
    const old_password = document.update_password.old_password;
    const new_password = document.update_password.new_password;
    const new_password2 = document.update_password.new_password2;
    const passwordPattern = "^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]+$";
    let hasError = true;

    if (old_password.value.trim() == "") {
        formError.innerHTML = "فیلد رمز عبور فعلی نمی‌تواند خالی باشد.";
        old_password.focus();
    } else if (new_password.value.trim() == "") {
        formError.innerHTML = "فیلد رمز عبور جدید نمی‌تواند خالی باشد.";
        new_password.focus();
    } else if (new_password.value.length < 8 || new_password.value.length > 25) {
        formError.innerHTML = "رمز عبور جدید باید بین ۸ تا ۲۵ کاراکتر باشد.";
        new_password.focus();
    } else if (!new_password.value.match(passwordPattern)) {
        formError.innerHTML =
            "رمز عبور جدید باید حداقل دارای یک عدد، یک حرف کوچک و یک حرف بزرگ انگلیسی باشد.";
        new_password.focus();
    } else if (old_password.value.trim() == new_password.value.trim()) {
        formError.innerHTML = "رمز عبور جدید نمی‌تواند با رمز عبور فعلی یکسان باشد.";
        new_password.focus();
    } else if (new_password2.value.trim() == "") {
        formError.innerHTML = "فیلد رمز عبور جدید نمی‌تواند خالی باشد.";
        new_password2.focus();
    } else if (new_password.value.trim() !== new_password2.value.trim()) {
        formError.innerHTML = "تکرار رمز عبور جدید صحیح نمی‌باشد.";
        new_password2.focus();
    } else {
        hasError = false;
    }

    if (hasError) {
        // formError.parentElement.style.display = "block";
        formError.parentElement.classList.add("active");
        return false;
    } else {
        return true;
    }
}

function validateCheckoutForm() {
    const formError = document.querySelector(".checkout-error span");
    const name = document.checkout.name;
    const phone = document.checkout.phone;
    const address = document.checkout.address;
    const postal = document.checkout.postal;
    const onlinePayment = document.checkout.onlinepayment;
    let hasError = true;

    if (name.value.trim() == "") {
        formError.innerHTML = "فیلد نام و نام‌خانوادگی نمی‌تواند خالی باشد.";
        name.focus();
    } else if (phone.value.trim() == "") {
        formError.innerHTML = "فیلد شماره تماس نمی‌تواند خالی باشد.";
        phone.focus();
    } else if (address.value.trim() == "") {
        formError.innerHTML = "فیلد آدرس نمی‌تواند خالی باشد.";
        address.focus();
    } else if (postal.value.trim() == "") {
        formError.innerHTML = "فیلد کد پستی نمی‌تواند خالی باشد.";
        postal.focus();
    } else if (!onlinePayment.checked) {
        formError.innerHTML = "نحوه پرداخت را انتخاب کنید.";
        onlinePayment.focus();
    } else {
        hasError = false;
    }

    if (hasError) {
        formError.parentElement.classList.add("active");
        return false;
    } else {
        return true;
    }
}
// const productMainImage = document.querySelector(".product-mainimg");
// productMainImage.addEventListener("mousemove", function () {
//     var img, glass, w, h, bw;
//     img = document.getElementsByClassName('main-img');
//     const zoom = 2;
//     /* Create magnifier glass: */
//     glass = document.createElement("DIV");
//     // glass = document.getElementsByClassName('zoom');
//     glass.setAttribute("class", "img-magnifier-glass");

//     /* Insert magnifier glass: */
//     img.parentElement.insertBefore(glass, img);

//     /* Set background properties for the magnifier glass: */
//     glass.style.backgroundImage = "url('" + img.src + "')";
//     glass.style.backgroundRepeat = "no-repeat";
//     glass.style.backgroundSize = img.width * zoom + "px " + img.height * zoom + "px";
//     bw = 3;
//     w = glass.offsetWidth / 2;
//     h = glass.offsetHeight / 2;

//     /* Execute a function when someone moves the magnifier glass over the image: */
//     glass.addEventListener("mousemove", moveMagnifier);
//     img.addEventListener("mousemove", moveMagnifier);

//     /*and also for touch screens:*/
//     glass.addEventListener("touchmove", moveMagnifier);
//     img.addEventListener("touchmove", moveMagnifier);
//     function moveMagnifier(e) {
//         var pos, x, y;
//         /* Prevent any other actions that may occur when moving over the image */
//         e.preventDefault();
//         /* Get the cursor's x and y positions: */
//         pos = getCursorPos(e);
//         x = pos.x;
//         y = pos.y;
//         /* Prevent the magnifier glass from being positioned outside the image: */
//         if (x > img.width - w / zoom) {
//             x = img.width - w / zoom;
//         }
//         if (x < w / zoom) {
//             x = w / zoom;
//         }
//         if (y > img.height - h / zoom) {
//             y = img.height - h / zoom;
//         }
//         if (y < h / zoom) {
//             y = h / zoom;
//         }
//         /* Set the position of the magnifier glass: */
//         glass.style.left = x - w + "px";
//         glass.style.top = y - h + "px";
//         /* Display what the magnifier glass "sees": */
//         glass.style.backgroundPosition =
//             "-" + (x * zoom - w + bw) + "px -" + (y * zoom - h + bw) + "px";
//     }

//     function getCursorPos(e) {
//         var a,
//             x = 0,
//             y = 0;
//         e = e || window.event;
//         /* Get the x and y positions of the image: */
//         a = img.getBoundingClientRect();
//         /* Calculate the cursor's x and y coordinates, relative to the image: */
//         x = e.pageX - a.left;
//         y = e.pageY - a.top;
//         /* Consider any page scrolling: */
//         x = x - window.pageXOffset;
//         y = y - window.pageYOffset;
//         return { x: x, y: y };
//     }
// });
