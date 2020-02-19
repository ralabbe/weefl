/* 
    Nav styling on scroll
*/

$(window).scroll(function() {
    $nav_location = $('nav').offset().top;
    console.log($nav_location);
    // Checks if nav is at the top of the page
    if($nav_location <= 1){
        // Check screen size
        if ($( window ).width() > 959){
            $('nav.uk-navbar').removeClass("sticky");
        } else {
            $('nav.uk-navbar').removeClass("sticky");
        }
        $background = '';
        // Adjust padding for sticky nav
        $logo_width = "";
        $nav_link = "";
    } else {
        // Check screen size
        if ($( window ).width() > 959){
            $('nav.uk-navbar').addClass("sticky");
        } else {
            $('nav.uk-navbar').addClass("sticky");
        }

    }

});

// After document is ready
$( document ).ready(function(){

    // Add ajax loader to contact form
    $("#contact-send .ajax-loader").append("<div class='lds-ripple'><div></div><div></div></div>");

    // Make side nav visible (after styling)
    $("#offcanvas-slide").css("cssText","opacity: 1 !important;");


    // AJAX Filter Code
    jQuery(function($){
        $('.filter').submit(function(){
            var filter = $(this);
            var productName = $(this).find("[name=categoryName]").val();
            var productID = $(this).find("[name=categoryfilter]").val();
            var productDescription = $(this).find("[name=categoryDescription]").val();
            if (productID){
                $("#response").attr("data-products", productID);
            } else {
                $("#response").attr("data-products", "all");
            }
            $limit = $("#response").attr("data-limit");
            $limitquery = "&limit=" + $limit;
            
            $.ajax({
                url:filter.attr('action'),
                data:filter.serialize() + $limitquery, // form data
                type:filter.attr('method'), // POST
                
                beforeSend:function(xhr){

                    var placeholder = '<div class="opacity0 products-single"><figure><div class="uk-padding-small products-placeholder"></div></figure></div>';
                    var placeholderlist = "";

                    for ( i = 0; i < $limit; i++ ){
                        placeholderlist += placeholder;
                    }
                    $("#products-category").html(productName);
                    $("#response div").first().html(placeholderlist);
                    $("#response > div").removeClass("uk-hidden");
                    $("#pagination").html("");
                },
                success:function(data){
                    $("#products-category").html(productName);
                    $('#response').html(data); // insert data
                    if (productDescription){
                        $desc = "<p>" + productDescription + "</p>";
                        $("#response").prepend($desc);
                    }
                    $("#response > div").removeClass("uk-hidden");
                }
            });
            return false;
        });
    });

    $('.pagination a').first().addClass('active');
    jQuery(function($){
        $('body').on('click','.pagination a',function(e){
            e.preventDefault();
            $action = $("#pagination").attr("data-action");
            $limit = $("#response").attr("data-limit");
            $product_id = $("#response").attr("data-products");
            $method = "POST";
            $data = "page=" + $(this).text() + "&categoryfilter=" + $product_id + "&limit=" + $limit + "&action=myfilter";

            $('.pagination > ').removeClass('current');
            $(this).addClass('current');

            $.ajax({
                url:$action,
                data:$data, // form data
                type:$method, // POST
                beforeSend:function(xhr){

                    var placeholder = '<div class="opacity0 products-single"><figure><div class="uk-padding-small products-placeholder"></div></figure></div>';
                    var placeholderlist = "";
                    for ( i = 0; i < $limit; i++ ){
                        placeholderlist += placeholder;
                    }
                    $("#response > div").first().html(placeholderlist);
                    $("#response > div").removeClass("uk-hidden");
                },
                success:function(data){
                    $('#response').html(data); // insert data
                    $("#response > div").removeClass("uk-hidden");
                }
            });
            return false;
        });
    });


    // Remove query from url
    if ($("#default-message").html()){
        $("#cf-message textarea").val($("#default-message").html());
        var uri = window.location.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }
    }
});



