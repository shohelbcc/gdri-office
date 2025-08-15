
$(document).ready(function () {

    // // Data Table
    // $('#dataTable').DataTable({
    //     responsive: true,
    //     autoWidth: false,
    //     columnDefs: [
    //         { orderable: false, targets: -1 }
    //     ]
    // });

    // Alert Time Out
    setTimeout(function () {
        $(".alert").slideUp("slow", function () {
            $(this).remove();
        });
    }, 3000);

    // Others Script
    // Add your custom scripts here
});

