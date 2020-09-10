/*price range*/

const { get } = require("jquery");

$("#sl2").slider();

var RGBChange = function() {
    $("#RGB").css(
        "background",
        "rgb(" + r.getValue() + "," + g.getValue() + "," + b.getValue() + ")"
    );
};

/*scroll to top*/
$(document).ready(function() {
    $(function() {
        $.scrollUp({
            scrollName: "scrollUp", // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: "top", // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: "linear", // Scroll to top easing (see http://easings.net/)
            animation: "fade", // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });
});

$(document).ready(function() {
    // Change Price & Stock with size
    $("#selSize").change(function() {
        var idSize = $(this).val();
        if (idSize == "") {
            return false;
        }
        $.ajax({
            type: "get",
            url: "/get-product-price",
            data: { idSize: idSize },
            success: function(resp) {
                // alert(resp); return false;
                var arr = resp.split("#");
                // alert(arr[0]+" €"); return false;
                var arr1 = parseFloat(arr[0]).toFixed(2);
                var arr2 = arr1.split(".");
                // alert(arr2); return false;
                $("#getPrice").html(arr2 + " €");
                $("#price").val(arr[0]);
                if (arr[1] == 0) {
                    $("#cartButton").hide();
                    $("#Availability").text("Produit indisponible");
                } else {
                    $("#cartButton").show();
                    $("#Availability").text("En stock");
                }
            },
            error: function() {
                alert("error");
            }
        });
    });
});

$(document).ready(function() {
    // Replace main Image with Alternate Image
    $(".changeImage").click(function() {
        var image = $(this).attr("src");
        $(".mainImage").attr("src", image);
    });
});

// Instantiate EasyZoom instances
var $easyzoom = $(".easyzoom").easyZoom();

// Setup thumbnails example
var api1 = $easyzoom.filter(".easyzoom--with-thumbnails").data("easyZoom");

$(".thumbnails").on("click", "a", function(e) {
    var $this = $(this);

    e.preventDefault();

    // Use EasyZoom's `swap` method
    api1.swap($this.data("standard"), $this.attr("href"));
});

// Setup toggles example
var api2 = $easyzoom.filter(".easyzoom--with-toggle").data("easyZoom");

$(".toggle").on("click", function() {
    var $this = $(this);

    if ($this.data("active") === true) {
        $this.text("Switch on").data("active", false);
        api2.teardown();
    } else {
        $this.text("Switch off").data("active", true);
        api2._init();
    }
});


// Validate Register form on keyup and submit

$("#registerForm").validate({
    rules: {
        name: {
            required: true,
            minlength: 2,
            accept: "[a-zA-Z]+"
        },
        password: {
            required: true,
            minlength: 6
        },
        email: {
            required: true,
            email: true,
            remote: "/check-email"
        }
    },
    messages: {
        name: {
            required: "Merci de saisir votre nom",
            minlength: "Votre nom doit contenir 2 caractères au minimum",
            accept: "Votre nom doit contenir seulement des lettres"
        },
        password: {
            required: "Merci de saisir votre mot de passe",
            minlength:
                "Votre mot de passe doit contenir 6 caractères au minimum"
        },
        email: {
            required: "Merci de saisir votre Email",
            email: "Merci de saisir une adresse email valide",
            remote: "L'adresse email est déjà utilisé!"
        }
    }
});

// Validate Login form on keyup and submit
$("#loginForm").validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        password: {
            required: true
        }
    },
    messages: {
        email: {
            required: "Merci de saisir votre Email",
            email: "Merci de saisir une adresse email valide"
        },
        password: {
            required: "Merci de saisir votre mot de passe"
        }
    }
});

// Password Strength script
$("#myPassword").passtrength({
    minChars: 6,
    passwordToggle: true,
    tooltip: true,
    eyeImg: "/images/frontend_images/eye.svg" // toggle icon
});
