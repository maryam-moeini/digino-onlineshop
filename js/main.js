$(document).ready(function () {
    //Add Product into Cart
    $("body").delegate(".addShopping", "click", function (event) {
        var pid = $(this).attr("data-pid");
        event.preventDefault();
        $.ajax({
            url: "./include/action.php",
            method: "POST",
            data: { addToCart: 1, product_id: pid },
            success: function (data) {
                count_item();
                $("#invisible").html(data);
            },
        });
    });

    //Add Product into Cart in list view
    $("body").delegate(".addShopping_listview", "click", function (event) {
        var pid = $(this).attr("data-pid");
        event.preventDefault();
        // $(".loading").show();
        $.ajax({
            url: "./include/action.php",
            method: "POST",
            data: { addToCart: 1, product_id: pid },
            success: function (data) {
                count_item();
                // getCartItem();
                $("#invisible").html(data);
                // $('.loading').hide();
            },
        });
    });

    //Count user cart items funtion
    count_item();
    function count_item() {
        $.ajax({
            url: "./include/action.php",
            method: "POST",
            data: { count_item: 1 },
            success: function (data) {
                if (!$.trim(data)) {
                    $(".badge").removeClass("active");
                } else {
                    $(".badge").addClass("active");
                    $(".badge").html(data);
                }
            },
        });
    }

    //Add Product into Wishlist
    $("body").delegate(".addToWishlist", "click", function (event) {
        var pid = $(this).attr("data-pid");
        event.preventDefault();
        // $(".loading").show();
        $.ajax({
            url: "./include/action.php",
            method: "POST",
            data: { addToWishlist: 1, product_id: pid },
            success: function (data) {
                if (!$.trim(data)) {
                    $(".addToWishlist[data-pid ='" + pid + "']").find('i').toggleClass("far fas");
                } else {
                    $("#invisible").html(data);
                }
                // $('.loading').hide();
            },
        });
    });

});
