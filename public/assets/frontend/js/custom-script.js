$(document).ready(function () {
     // home banner slick slider
     $('.banner-slider').slick({
        arrows: true,
        autoplay: true,
        fade: true,
        speed: 1000,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    dots: true,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    dots: true,
                }
            }
        ]
    });
    // promotion slider
    $('.promotion-slider').slick({
        arrows: true,
        autoplay: true,
        slidesToShow: 1,
        variableWidth: true,
        infinite: true,
    });
    // recent post slider
    $('.recent-post-slider').slick({
        arrows: true,
        dots: true,
        autoplay: false,
        slidesToShow: 3,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    arrows: false,
                    dots: true,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });
    // ads slider
    $('.approved-ads-slider').slick({
        arrows: true,
        autoplay: true,
        slidesToShow: 2,
    });
    // my services slider
    $('.my-services-slider').slick({
        arrows: true,
        autoplay: true,
    });
    // sticky header
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('header').addClass('sticky');
        } else {
            $('header').removeClass('sticky');
        }
    });
    // mobilemenu add class
    $(".navbar-toggler").click(function (e) {
        e.preventDefault();
        $(this).toggleClass("show-menu");
    });
    // profile btn for mobile add class
    $(".prof-btn").click(function (e) {
        e.preventDefault();
        $(".profile-sidebar").addClass("show-sidebar");
    });
    // profile btn for mobile remove class
    $(".close-sidebar-btn").click(function (e) {
        e.preventDefault();
        $(".profile-sidebar").removeClass("show-sidebar");
    });
    // open dashboard sidebar
    $(".open-dash-sidebar").click(function (e) {
        e.preventDefault();
        $(this).toggleClass("active");
        $(".sidebar-menu").toggleClass("show-dash-sidebar");
        $("body").toggleClass("overflow-hidden");
    });
    // close dashboard on outside click
    if ($(window).width() < 768) {
        $(document).mouseup(function (e) {
            var sidebarContainer = $(".sidebar-menu");
            if(!sidebarContainer.is(e.target) &&
            sidebarContainer.has(e.target).length === 0) {
            sidebarContainer.removeClass("show-dash-sidebar");
            $("body").removeClass("overflow-hidden");
            $(".open-dash-sidebar").removeClass("active");
          }
        });
     }
    // language dropdown
    $('.nav-language-select').select2({
        dropdownCssClass: "open-language nav-language",
        minimumResultsForSearch: -1
    });
    // language dropdown
    $('.language-select').select2({
        dropdownCssClass: "open-language nav-language location-dropdown",
        minimumResultsForSearch: -1
    });
    // location dropdown
    $('.language-select.location-banner-select').select2({
        dropdownCssClass: "open-language nav-language banner-location-dropdown",
    });
    // filter dropdown
    $('.filter-select').select2({
        dropdownCssClass: "open-language",
        minimumResultsForSearch: -1
    });
    // filter dropdown
    $('.record-select').select2({
        dropdownCssClass: "open-language open-record-select",
        minimumResultsForSearch: -1
    });
    // filter dropdown btn
    $(".filter-btn").click(function (e) {
        e.preventDefault();
        $(".more-filter").toggleClass("show-filter");
    });
    // read more link
    $(document).on('click',".read-more", function (e) {
        e.preventDefault();
        $(this).text(function (i, text) {
            return text === "Read more" ? "Read Less" : "Read more";
        })
        $(this).parents('.rating-card').toggleClass("show-rating-cnt");
    });
    // hide password
    $(".show-pass").click(function (e) {
        e.preventDefault();
        $(this).toggleClass("hide-pass");
        let input = $(this).parent().find('input');
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    // popular article slick slider
    $('.popular-articles-slider').slick({
        arrows: true,
        autoplay: false,
    });

    $(document).on('click', ".save-button", function (e) {
        var element     =   $(this);
        var vendor_id   =   element.data('id');

        if(vendor_id){
            $.ajax({
                type        :   'POST',
                dataType    :   'JSON',
                url         :   UrlSaveListStore,
                data        :   {
                    _token      :   $('meta[name="csrf-token"]').attr("content"),
                    vendor_id   :    vendor_id,
                },
                success: function(response) {
                    if(element.hasClass('filled-todo')){
                        element.html(element.html().replace(StrAddedInToList, StrAddToList));
                    }else{
                        element.html(element.html().replace(StrAddToList, StrAddedInToList));
                    }

                    element.toggleClass('filled-todo');
                },
                error: function(response) {
                    window.location.href = UrLogin;
                },
            });
        }
    })

    const PSelement           =   $(".pass-strength-card");
    const PSclassName         =   'strength-verified';
    const PSdisplayNoneClass  =   'd-none';
    const PSstrongClass       =   'strong';
    const PSweekClass         =   'week';

    $(document).on('keyup focusout', 'input[name=password]', function(){
        var password    =   $(this).val();
        var is_min      =   is_capital  =   is_special  =   is_number   =   false;

        // Show modal
        if(password){
            PSelement.removeClass(PSdisplayNoneClass);
        }else{
            PSelement.addClass(PSdisplayNoneClass);
        }

        // min length
        if (password.length >= 8) {
            is_min = true;
            addRemoveClass('add', PSelement, 'min', PSclassName);
        }else{
            is_min = false;
            addRemoveClass('remove', PSelement, 'min', PSclassName);
        }

        // capital letter
        if (/[A-Z]/.test(password)) {
            is_capital = true;
            addRemoveClass('add', PSelement, 'capital', PSclassName);
        }else{
            is_capital = false;
            addRemoveClass('remove', PSelement, 'capital', PSclassName);
        }

        // special character
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password)) {
            is_special = true;
            addRemoveClass('add', PSelement, 'special', PSclassName);
        }else{
            is_special = false;
            addRemoveClass('remove', PSelement, 'special', PSclassName);
        }

        // number
        if (/[0-9]/.test(password)) {
            is_number = true;
            addRemoveClass('add', PSelement, 'number', PSclassName);
        }else{
            is_number = false;
            addRemoveClass('remove', PSelement, 'number', PSclassName);
        }

        if(is_min && is_capital && is_special && is_number){
            PSelement.find('.'+PSstrongClass).removeClass(PSdisplayNoneClass);
            PSelement.find('.'+PSweekClass).addClass(PSdisplayNoneClass);
        }else{
            PSelement.find('.'+PSstrongClass).addClass(PSdisplayNoneClass);
            PSelement.find('.'+PSweekClass).removeClass(PSdisplayNoneClass);
        }
    });

    function addRemoveClass(event, element, elementClass, className){
        if(event == 'add'){
            element.find("."+elementClass).addClass(className);
        }
        if(event == 'remove'){
            element.find("."+elementClass).removeClass(className);
        }
    }

    // banner custom dropdown scroll js
    var box = document.getElementById('custom-dropdown-banner-main');
    if(box){
        new SimpleBar(box);
    }
   
    // home banner categories dropdown custom js
    $('#language-select').on('select2:open', function (e) {
        $(".language-select-dropdown-inner").removeClass("active");
    });

    $('.select-dropdown-title').on("click",function(){
        $('.language-select-dropdown-inner').toggleClass('active');
        $(".language-select-dropdown-inner .dropdown-menu-main li").each(function( i ) {
            $(this).removeClass("active");
            $('.dropdown-sub-menu').not($(this).find('.dropdown-sub-menu')).removeClass("active");
        });
    });

    $('.language-select-dropdown-inner .dropdown-menu-main').on("click",function(){
        $('.language-select-dropdown-inner').toggleClass('active');
    });

    $('.language-select-dropdown-inner .dropdown-menu-main li').on("click",function(e){
        var title       =   $(this).find(".dropdown-menu-inner").find("span").html();
        var category    =   $(this).find(".dropdown-menu-inner").find("span").data('slug');

        $(".select-dropdown-title").html(title);
        $("#category").val(category);
        $("#sub_category").val("");

        e.stopPropagation();
        $(this).toggleClass('active').siblings().removeClass('active');
        $(this).find(".dropdown-sub-menu").toggleClass("active");
        $('.dropdown-sub-menu').not($(this).find('.dropdown-sub-menu')).removeClass("active");
    });

    $('.language-select-dropdown-inner .dropdown-sub-menu li').on("click",function(e){
        var title           =   $(this).find("label").html();
        var category        =   $(this).parent(".dropdown-sub-menu").siblings(".dropdown-menu-inner").find("span").data('slug');
        var sub_category    =   $(this).find("label").data('slug');

        $(".select-dropdown-title").html(title);
        $("#category").val(category);
        $("#sub_category").val(sub_category);

        $(".language-select-dropdown-inner").removeClass("active");
    });
    
    $(document).on('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("location-area")){
            $(".language-select-dropdown-inner").removeClass("active");
        }
    });

    // Selected image file name to display
    $('input[type="file"]').on('change',function() {
        var fileName = $(this)[0].files[0].name;
        $(this).siblings('p').text(fileName);
    })

    // country select
    if($("#mobile_code").length > 0){
        var intlNumber = $("#mobile_code").intlTelInput({
            initialCountry: "ae",
            separateDialCode: true,
        });

        // set as per user country code
        if(UsrCountryCode){
            $(".iti__country").each(function(){
                if( $(this).find(".iti__dial-code").html() == UsrCountryCode ){
                    intlNumber.intlTelInput("setCountry", $(this).data("country-code"));
                }
            });
        }

        // country change
        intlNumber.on("countrychange", function() {
            $("#country_code").val($(".iti__selected-dial-code").html());
        });
    }
});
