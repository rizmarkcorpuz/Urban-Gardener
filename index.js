$(document).ready(function(){

    //Banner Owl Carousel
    $("#banner-area .owl-carousel").owlCarousel({
        dots: true,
        loop: true,
        items: 1
    });

    //Banner Owl Carousel
    $("#product-picture .owl-carousel").owlCarousel({
        items:1,
        loop:false,
        center:true,
        margin:10,
        URLhashListener:true,
        autoplayHoverPause:true,
        startPosition: 'URLHash',
        dots: false,
    });

    //Top Sale Owl Carousel
    $("#top-sale .owl-carousel").owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items:5
            }
        }
    });

    //Isotope Filter
    var $grid = $(".grid").isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows',
        getSortData:{
            name: function(element){
                return $(element).text();
            }
        }
    });

    //Filter Items on Button Click
    $("#filters").on("click","button",function(){
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({filter: filterValue});
    })

    //Sort Items on Button Click
    $("#sorts").on("click","button",function(){
        var sortValue = $(this).attr('data-sort-by');
        if(sortValue === "Z-A"){
            $grid.isotope({sortBy: '.name', sortAscending: false});
        }else{
            $grid.isotope({sortBy: sortValue, sortAscending: true});
            console.log(sortValue);
        }
        
    })
    

    //New Plants Owl Carousel
    $("#new-plants .owl-carousel").owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items:5
            }
        }
    });

    // product qty section
    let $qty_up = $(".qty .qty-up");
    let $qty_down = $(".qty .qty-down");
    let $deal_price = $("#deal-price");
    // let $input = $(".qty .qty_input");

    // click on qty up button
    $qty_up.click(function(e){

        let $input = $(`.qty_input[data-id='${$(this).data("id")}']`);
        let $price = $(`.product_price[data-id='${$(this).data("id")}']`);
        let $input2 = $(`.qty_input2[data-id='${$(this.data("id"))}']`);

        // change product price using ajax call
        $.ajax({url: "template/ajax.php", type : 'post', data : { itemid : $(this).data("id")}, success: function(result){
                let obj = JSON.parse(result);
                let item_price = obj[0]['item_price'];
                let item_quantity = obj[0]['item_quantity'];

                if($input.val() >= 1 && $input.val() <= 9){
                    $input.val(function(i, oldval){
                        return ++oldval;
                    });

                    //increase the price of the product
                    $price.text(parseInt(item_price * $input.val()).toFixed(2));
                    $input2.text(parseInt(item_quantity * $input.val()));

                    //set subtotal price
                    let subtotal = parseInt($deal_price.text()) + parseInt(item_price);
                    $deal_price.text(subtotal.toFixed(2));
            }


            }}); //closing ajax request



    });

    // click on qty down button
    $qty_down.click(function(e){
        let $input = $(`.qty_input[data-id='${$(this).data("id")}']`);
        let $price = $(`.product_price[data-id='${$(this).data("id")}']`);


        // change product price using ajax call
        $.ajax({url: "template/ajax.php", type : 'post', data : { itemid : $(this).data("id")}, success: function(result){
                let obj = JSON.parse(result);
                let item_price = obj[0]['item_price'];

                if($input.val() > 1 && $input.val() <= 10){
                    $input.val(function(i, oldval){
                        return --oldval;
                    });

                    //increase the price of the product
                    $price.text(parseInt(item_price * $input.val()).toFixed(2));

                    //set subtotal price
                    let subtotal = parseInt($deal_price.text()) - parseInt(item_price);
                    $deal_price.text(subtotal.toFixed(2));
                }

             }}); //closing ajax request
    });


});

$(document).ready(function (e) {

    let $uploadfile = $('#register .upload-profile-image input[type="file"]');

    $uploadfile.change(function () {
        readURL(this);
    });

    $("#reg-form").submit(function (event) {
        let $password = $("#password");
        let $confirm = $("#confirm_pwd");
        let $error = $("#confirm_error");
        if($password.val() === $confirm.val()){
            return true;
        }else{
            $error.text("Password not Match");
            event.preventDefault();
        }
    });



});

function readURL(input) {
    if(input.files && input.files[0]){
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#register .upload-profile-image .img").attr('src', e.target.result);
            $("#register .upload-profile-image .camera-icon").css({display: "none"});
        }

        reader.readAsDataURL(input.files[0]);

    }
}
/*
let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
};

window.onscroll = () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
};


document.querySelector('#close-edit').onclick = () =>{
    document.querySelector('.edit-form-container').style.display = 'none';
    window.location.href = 'admin.php';

}; */

// Toggle the side navigation
$("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
    };
});

// Close any open menu accordions when window is resized below 768px
$(window).resize(function() {
    if ($(window).width() < 768) {
        $('.sidebar .collapse').collapse('hide');
    };

    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
        $('.sidebar .collapse').collapse('hide');
    };
});

// Prevent the content wrapper from scrolling when the fixed side navigation hovered over
$('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
        var e0 = e.originalEvent,
            delta = e0.wheelDelta || -e0.detail;
        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
        e.preventDefault();
    }
});

// Scroll to top button appear
$(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
        $('.scroll-to-top').fadeIn();
    } else {
        $('.scroll-to-top').fadeOut();
    }
});

// Smooth scrolling using jQuery easing
$(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
});

$(document).ready(function (e) {

    $("#reg-edit").submit(function (event) {
        let $user_id = $("#user_id");


    });



});

function myFunction() {
    var x = document.getElementById("myPassword");
    var y = document.getElementById("mycPassword");
    if (x.type === "password") {
      x.type = "text";
      y.type = "text";
    } else {
      x.type = "password";
      y.type = "password";
    }
  }

  function showFunction() {
    var x = document.getElementById("hidden");
    
      x.style.display = "block";

  }

  function hideFunction() {
    var x = document.getElementById("hidden");
    
      x.style.display = "none";
  }

function withPot(){

    var withPot = document.getElementById("withPot");
    var withoutPot = document.getElementById("withoutPot");
    withPot.checked = true;
    withoutPot.checked = false;
}

function withoutPot(){

    var withPot = document.getElementById("withPot");
    var withoutPot = document.getElementById("withoutPot");
    withPot.checked = false;
    withoutPot.checked = true;
}

function showReason(){
    var x = document.getElementById("cancellationReason");
    document.getElementById("cancellationReason").required = true;

    x.style.display = "block";
}

function hideReason(){
    var x = document.getElementById("cancellationReason");
    document.getElementById("cancellationReason").required = false;

    x.style.display = "none";
}

function showGcash(){
    var x = document.getElementById("gcashPayment");

    x.style.opacity = 1;
    x.style.trasition = "all 2s";
}

function hideGcash(){
    var x = document.getElementById("gcashPayment");

    x.style.opacity = 0;
    x.style.trasition = "all 2s";
}


function dropdown (){
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {

    const select = dropdown.querySelector('.select');
    //const caret = dropdown.querySelector('.caret');
    const menu = dropdown.querySelector('.menu');
    const options = dropdown.querySelectorAll('.menu li');
    const selected = dropdown.querySelector('.selected');

    document.addEventListener('mousedown', (event) => {
        if (select.contains(event.target)) {
            select.classList.toggle('select-clicked');
            //caret.classList.toggle('caret-rotate');
            menu.classList.toggle('menu-open');
        }else if(menu.contains(event.target)){
            

        }else{
            select.classList.remove('select-clicked');
            menu.classList.remove('menu-open');
        }
        
    })

});
}







