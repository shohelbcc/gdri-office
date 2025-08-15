<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Addendances</h4>
                    </div>
                    <div class="align-items-center col">
                        <span id="createbtn">
                            @can('create-attendance')
                                <button type="button" data-bs-toggle="modal" data-bs-target="#create_modal"
                                class="float-right btn btn-sm btn-success m-0">
                                <i class="fa fa-plus"></i>
                                Add New
                            </button>
                            @endcan
                        </span>
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
                                @can(['edit-attendance'])
                                <th class="bg-secondary text-white">Action</th>
                                @endcan
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
                let res = await axios.get("/attendance/list");
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
                                    @can(['edit-attendance'])
                                        <td class="action">
                                        <div class="dropdown d-xl-none">
                                            <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @can('edit-attendance')
                                                    <li><button data-id="${item.id}" class="text-success editBtn dropdown-item">Edit</button></li>
                                                @endcan
                                            </ul>
                                        </div>
                                        @can('edit-attendance')
                                            <button data-id="${item.id}" class="d-none d-xl-inline-block btn btn-sm editBtn btn-sm btn-outline-success"><i class="fa fa-edit"></i></button>
                                        @endcan
                                    </td>
                                    @endcan
                                </tr>`
                    tableList.append(row)
                })

                $('.editBtn').on('click', async function () {
                    let id = $(this).data('id');
                    await FillUpUpdateForm(id)
                    $("#update_modal").modal('show');
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