$(document).ready(function () {
    // expose them globally:
    window.successToast = function (msg) {
        Toastify({
            gravity: "top",
            position: "right",
            text: msg,
            className: "rounded bg-success text-dark mb-5",
        }).showToast();
    };

    window.errorToast = function (msg) {
        Toastify({
            gravity: "top",
            position: "right",
            text: msg,
            className: "rounded bg-danger text-dark mb-5",
        }).showToast();
    };

    // Data Table
    $("#myTable").DataTable({
        responsive: true,
        autoWidth: false,
        columnDefs: [{ orderable: false, targets: -1 }],
    });

    // Alert Time Out
    setTimeout(function () {
        $(".alert").slideUp("slow", function () {
            $(this).remove();
        });
    }, 5000);

    // Others Script
    // Add your custom scripts here
});
