<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Addendances</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">

                    {{-- Bulk Delete --}}
                    @can('bulk-delete-attendance')
                        <button id="bulkDeleteBtn" class="btn bulkDeleteBtn btn-danger btn-sm mb-3 d-none">
                        <i class="fa fa-trash"></i> Delete Selected
                    </button>
                    @endcan

                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th class="selectAll bg-secondary text-white"><input type="checkbox" id="selectAll" /></th>
                                <th class="bg-secondary text-white">Date</th>
                                <th class="bg-secondary text-white">Location</th>
                                <th class="bg-secondary text-white">Check In</th>
                                <th class="bg-secondary text-white">Late Check In</th>
                                <th class="bg-secondary text-white">Check Out</th>
                                <th class="bg-secondary text-white">Late Check Out</th>
                                <th class="bg-secondary text-white">Work Summery</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>

        getList();
        async function getList() {

            try {
                //    showLoader();
                let res = await axios.get("/admin/attendance/list");
                //    hideLoader();

                let tableList = $("#tableList");
                let myTable = $("#myTable");

                myTable.DataTable().destroy();
                tableList.empty();

                res.data.data.forEach(function (item, index) {
                    let row = `<tr>
                                    <td class="checkboxRow"><input type="checkbox" class="rowCheckbox" data-id="${item.id}" /></td>
                                    <td>${item.date}</td>
                                    <td>${item.location}</td>
                                    <td>${item.check_in}</td>
                                    <td>${item.late_check_in}</td>
                                    <td>${item.check_out}</td>
                                    <td>${item.late_check_out}</td>
                                    <td>${item.note}</td>
                                </tr>`
                    tableList.append(row)
                })

                // Bulk Delete
                // 1) “Select All” toggle
                $('#selectAll').on('change', function () {
                    $('.rowCheckbox').prop('checked', this.checked).trigger('change');
                });

                // 2) Enable/disable Bulk Delete based on selections
                $(document).on('change', '.rowCheckbox', function () {
                    const anyChecked = $('.rowCheckbox:checked').length > 0;
                    $('#bulkDeleteBtn').removeClass('d-none', !anyChecked);

                    // If not all individual boxes are checked, uncheck header;
                    // if all are checked, check header.
                    $('#selectAll').prop('checked',
                        $('.rowCheckbox').length === $('.rowCheckbox:checked').length
                    );
                });

                $('.bulkDeleteBtn').on('click', function () {
                    const ids = $('.rowCheckbox:checked').map(function () {
                        return $(this).data('id');
                    }).get();
                    $("#bulk_delete_modal").modal('show'); // Updated modal ID
                    $("#bulkDeleteId").val(ids); // Updated to set the value to the array of IDs
                })

                
                new DataTable('#myTable', {
                    order: [[0, 'desc']],
                    lengthMenu: [10, 15, 20, 30],
                    dom: `<"d-flex justify-content-between mb-2"
                                                        <"d-inline-flex align-items-center" f>
                                                        <"d-inline-flex align-items-center" l>
                                                        B
                                                    >
                                                    t
                                                    <"d-flex justify-content-between mt-2"<"info"i><"pagination"p>>
                                                    <"clear">`,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            title: 'attendances List',
                            text: '<i class="fa fa-copy"></i>',
                            titleAttr: 'Copy',
                            className: 'btn btn-sm btn-outline-primary'
                        },
                        {
                            extend: 'excelHtml5',
                            title: 'attendances List',
                            text: '<i class="fa fa-file-excel"></i>',
                            titleAttr: 'Excel',
                            className: 'btn btn-sm btn-outline-success'
                        },
                        {
                            extend: 'print',
                            title: 'attendances List',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            className: 'btn btn-sm btn-outline-warning'
                        }
                    ],
                    responsive: {
                        breakpoints: [
                            { name: 'desktop', width: Infinity },
                            { name: 'tablet', width: 1024 },
                            { name: 'phone', width: 480 }
                        ]
                    },
                });

            } catch (e) {
                unauthorized(e.response.status)
            }

        }


    </script>
@endpush