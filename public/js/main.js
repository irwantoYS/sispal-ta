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
    $(window).scroll(function () {
        if ($(this).scrollTop() > 90) {
            $(".nav-bar").addClass("sticky-top shadow");
        } else {
            $(".nav-bar").removeClass("sticky-top shadow");
        }
    });

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

    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: true,
        nav: true,
        navText: [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>',
        ],
    });

    // // Service carousel
    // $(".service-carousel").owlCarousel({
    //     autoplay: true,
    //     smartSpeed: 1000,
    //     center: true,
    //     margin: 25,
    //     dots: true,
    //     loop: true,
    //     nav : false,
    //     responsive: {
    //         0:{
    //             items:1
    //         },
    //         576:{
    //             items:2
    //         },
    //         768:{
    //             items:3
    //         },
    //         992:{
    //             items:2
    //         },
    //         1200:{
    //             items:3
    //         }
    //     }
    // });

    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        margin: 24,
        dots: true,
        loop: true,
        nav: false,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            },
        },
    });

    // Inisialisasi Owl Carousel untuk Staff
    $("#staffCarousel").owlCarousel({
        autoplay: true, // Aktifkan autoplay
        smartSpeed: 1000, // Kecepatan transisi
        margin: 25, // Jarak antar item
        dots: true, // Tampilkan titik navigasi
        loop: true, // Aktifkan loop tak terbatas
        nav: true, // Tampilkan tombol navigasi (panah kiri/kanan)
        navText: [
            '<i class="fas fa-chevron-left"></i>', // Ganti ke Font Awesome
            '<i class="fas fa-chevron-right"></i>', // Ganti ke Font Awesome
        ], // Kustomisasi teks/ikon tombol nav
        responsive: {
            0: {
                // Layar kecil (mobile)
                items: 1,
            },
            768: {
                items: 2, // Layar sedang (tablet)
            },
            992: {
                // Layar besar (desktop)
                items: 3,
            },
        },
    });
})(jQuery);
