    
<footer id="footer"><!--Footer-->
    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Service</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Online Help</a></li>
                            <li><a href="{{ url('page/contact') }}">Contactez-nous</a></li>
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Change Location</a></li>
                            <li><a href="#">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Quock Shop</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">T-Shirt</a></li>
                            <li><a href="#">Mens</a></li>
                            <li><a href="#">Womens</a></li>
                            <li><a href="#">Gift Cards</a></li>
                            <li><a href="#">Shoes</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Policies</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{{ url('/page/terms-conditions') }}">Conditions d'utilisation</a></li>
                            <li><a href="{{ url('/page/politique-confidentialite') }}">Politique de confidentialité</a></li>
                            <li><a href="#">Refund Policy</a></li>
                            <li><a href="#">Billing System</a></li>
                            <li><a href="#">Ticket System</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About E-Master</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{{ url('/page/about-page') }}">Qui sommmes nous?</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Store Location</a></li>
                            <li><a href="#">Affillate Program</a></li>
                            <li><a href="#">Copyright</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>About E-Master</h2>
                        <form action="javascript:void(0);" class="searchform" type="post">
                            @csrf
                            <input onfocus="enableSubscriber();" onfocusout="checkSubscriber();" name="subscriber_email" id="subscriber_email" type="email" placeholder="Votre adresse email" required />
                            <button onclick="checkSubscriber(); addSubscriber();"" type="submit" class="btn btn-default" id="btnSubmit"><i class="fa fa-arrow-alt-circle-right"></i></button>
                            <div id="statusSubscriber"></div>
                            <p>Obtenez les dernières mises à jour de <br/> notre site et soyez mis à jour vous-même ...</p>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2020 E-Master Inc. All rights reserved.</p>
                <p class="pull-right">Designed by <span>Andry Ranarison</span></p>
            </div>
        </div>
    </div>
    
</footer><!--/Footer-->
<script>
    function checkSubscriber(){
        var subscriber_email = $('#subscriber_email').val();
        // alert(subscriber_email);
        $.ajax({
            type:'post',
            url: '/check-subscriber-email',
            data:{subscriber_email:subscriber_email},
            success:function(resp){
                // alert(resp);
                if(resp=="exists"){
                    // alert("email existe déjà");
                    $('#statusSubscriber').show();
                    $('#btnSubmit').hide();
                    $('#statusSubscriber').html("<div class=' text-2xl text-red-700 mt-2 px-2 py-2'>L\' adresse email existe déjà!</div> ");

                }
            },error:function(){
                alert("Error");
            }
        });
    }

    function addSubscriber(){
        var subscriber_email = $('#subscriber_email').val();
        // alert(subscriber_email);
        $.ajax({
            type:'post',
            url: '/add-subscriber-email',
            data:{subscriber_email:subscriber_email},
            success:function(resp){
                // alert(resp);
                if(resp=="exists"){
                    // alert("email existe déjà");
                    $('#statusSubscriber').show();
                    $('#btnSubmit').hide();
                    $('#statusSubscriber').html("<div class=' text-2xl text-red-700 mt-2 px-2 py-2'>L\' adresse email existe déjà!</div> ");

                }else if(resp=="saved"){
                    $('#statusSubscriber').show();
                    $('#statusSubscriber').html("<div class=' text-2xl text-green-700 mt-2 px-2 py-2'>Merci pour votre souscription aux Newsletters!</div> ");
                }
            },error:function(){
                alert("Error");
            }
        });
    }


    function enableSubscriber(){
        $('#btnSubmit').show();
        $("#statusSubscribe").hide();
    }
</script>