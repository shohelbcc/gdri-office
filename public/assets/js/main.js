(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($("#spinner").length > 0) {
                $("#spinner").removeClass("show");
            }
        }, 1);
    };
    spinner();

    // Initiate the wowjs
    new WOW().init();

    // Sticky Navbar
    // $(window).scroll(function () {
    //     if ($(this).scrollTop() > 300) {
    //         $(".sticky-top").css("top", "0px");
    //     } else {
    //         $(".sticky-top").css("top", "-100px");
    //     }
    // });

    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";

    $(window).on("load resize", function () {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
                function () {
                    const $this = $(this);
                    $this.addClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "true");
                    $this.find($dropdownMenu).addClass(showClass);
                },
                function () {
                    const $this = $(this);
                    $this.removeClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "false");
                    $this.find($dropdownMenu).removeClass(showClass);
                }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".back-to-top").fadeIn("slow");
        } else {
            $(".back-to-top").fadeOut("slow");
        }
    });
    $(".back-to-top").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
        return false;
    });

    

    // Course filter
    var courseIsotope = $(".course-container").isotope({
        itemSelector: ".course-item-filter",
        layoutMode: "fitRows",
    });

    $("#course-filter li").on("click", function () {
        $("#course-filter li").removeClass("filter-active");
        $(this).addClass("filter-active");
        courseIsotope.isotope({ filter: $(this).data("filter") });
    });

    // Alert Time Out
    setTimeout(function () {
        $(".alert").slideUp("slow", function () {
            $(this).remove();
        });
    }, 5000);
})(jQuery);
