/*price range*/

// const { get } = require("jquery");

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


// Replace main Image with Alternate Image
$(".changeImage").click(function() {
    var image = $(this).attr("src");
    $(".mainImage").attr("src", image);
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


    // Validate Account form on keyup and submit
    $("#accountForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                accept: "[a-zA-Z]+"
            },
            address: {
                required: true,
                minlength: 6
            },
            city: {
                required: true,
                minlength:2
            },
            state: {
                required: true,
                minlength:2
            },
            country: {
                required: true,
            }

        },
        messages: {
            name: {
                required: "Merci de saisir votre nom",
                minlength: "Votre nom doit contenir 2 caractères au minimum",
                accept: "Votre nom doit contenir seulement des lettres"
            },
            address: {
                required: "Merci de saisir votre adresse",
                minlength: "Ce champ doit contenir 10 caractères au minimum"
            },
            city: {
                required: "Merci de saisir votre ville",
                minlength: "Ce champ doit contenir 2 caractères au minimum"
            },
            state: {
                required: "Merci de saisir votre Région",
                minlength: "Ce champ doit contenir 2 caractères au minimum"
            },
            country: {
                required: "Merci de selectionner votre Pays"
            }
        }
    });


	$("#passwordForm").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	

    // Check Current User Password
    $('#current_pwd').keyup(function(){
        var current_pwd = $(this).val();
        // alert(current_pwd);
        $.ajax({
			headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
            type:'post',
            url:'/check-user-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                // alert(resp);
                if(resp=="false"){
                    $('#chkPwd').html("<font color='red'>Mot de passe actuel est incorrect</font>");
                }else if(resp=="true"){
                    $('#chkPwd').html("<font color='green'>Mot de passe actuel est correct</font>");
                }
            },error:function() {
                 alert("Error");
            }
        });

    });

    // Password Strength script
    $("#myPassword").passtrength({
        minChars: 6,
        passwordToggle: true,
        tooltip: true,
        eyeImg: "/images/frontend_images/eye.svg" // toggle icon
    });


    // Copy Billing Address to Shipping Address Script
    $('#billtoship').click(function(){
        if(this.checked){
            $('#shipping_name').val($('#billing_name').val());
            $('#shipping_address').val($('#billing_address').val());
            $('#shipping_city').val($('#billing_city').val());
            $('#shipping_state').val($('#billing_state').val());
            $('#shipping_country').val($('#billing_country').val());
            $('#shipping_pincode').val($('#billing_pincode').val());
            $('#shipping_mobile').val($('#billing_mobile').val());
        }else{
            $('#shipping_name').val('');
            $('#shipping_address').val('');
            $('#shipping_city').val('');
            $('#shipping_state').val('');
            $('#shipping_country').val('');
            $('#shipping_pincode').val('');
            $('#shipping_mobile').val('');
        }
    });

    // $('#selectPaymentMethod').click(function(){
    //     if($('#Paypal').is(':checked') || $('#CB').is(':checked') ){
    //         // alert('checked');
    //     }else{
    //         alert('Merci de sélectionner un mode de paiement');
    //         return false;
    //     }
    // });

    $('#checkPincode').click(function(){
        var pincode = $("#chkPincode").val();
        if(pincode==""){
            alert("Merci de saisir votre code postal");return false;
        }
       $.ajax({
            type:'post',
            data:{pincode:pincode},
            url:'/check-pincode',
            success:function(resp){
                // alert(resp);
                if(resp=="Le code postal est valable pour la livraison"){
                    $('#pincodeResponse').html("<font color = 'green'>"+resp+"</b>");
                }else{
                    $('#pincodeResponse').html("<font color = 'red'>"+resp+"</b>");
                }
            },error:function(){
                alert("Error");
            }
       });
    });

   
