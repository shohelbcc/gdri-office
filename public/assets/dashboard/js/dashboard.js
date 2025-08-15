
// =============================================================================================
// Top Navbar From Medium Device Include


// $(window).scroll(function() {
//     var scroll = $(window).scrollTop();

//     if (scroll >= 10) {
//         $("#dashboardNav").addClass("shadow");
//     } else {
//         $("#dashboardNav").removeClass("shadow");
//     }
// });



// $('.breadcrumb-item').on('click', function () {
//     $('.breadcrumb-item').removeClass('active');
//     $(this).addClass('active')
// });






$(function() {
    $('.js-conveyor-example').jConveyorTicker({
        // anim_duration: 200,
        // force_loop: true,
    });
  });


  function errorToast(msg) {
    Toastify({
        gravity: "bottom", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "red",
        }
    }).showToast();
  }

  function successToast(msg) {
    Toastify({
        gravity: "bottom", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "green",
        }
    }).showToast();
  }

  setTimeout(function(){
    $('.alert').slideUp();
  },4000);


//   $(function() {
//     $('.js-conveyor-example').jConveyorTicker({
//       anim_duration: 500
//     });
//   });

//   $(function() {
//     $('.js-conveyor-example').jConveyorTicker({
//       reverse_elm: true
//     });
//   });

//   $(function() {
//     $('.js-conveyor-example').jConveyorTicker({
//       force_loop: true
//     });
//   });

//   $(function() {
//     $('.js-conveyor-example').jConveyorTicker({
//       start_paused: true
//     });
//   });

// $('.user_link').on('click', function () {
//     $('.user_link').removeClass('shohel');
//     $(this).addClass('shohel');
// });

