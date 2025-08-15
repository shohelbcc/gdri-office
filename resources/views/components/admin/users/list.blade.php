<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Users</h4>
                    </div>
                    <div class="align-items-center col">
                        <span id="createbtn">
                            @can('create-user')
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
                    @can('bulk-delete-user')
                        <button id="bulkDeleteBtn" class="btn bulkDeleteBtn btn-danger btn-sm mb-3 d-none">
                        <i class="fa fa-trash"></i> Delete Selected
                    </button>
                    @endcan

                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th class="selectAll bg-secondary text-white"><input type="checkbox" id="selectAll" /></th>
                                <th class="bg-secondary text-white" style="text-align: center; width: 10px !important;">#</th>
                                <th class="bg-secondary text-white">Name</th>
                                <th class="bg-secondary text-white">Email</th>
                                <th class="bg-secondary text-white">Phone</th>
                                @can('assign-role')
                                    <th class="bg-secondary text-white">Assign Role(s)</th>
                                @endcan
                                @can(['edit-user', 'delete-user', 'info-user'])
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
                let res = await axios.get("/admin/user/list");
                //    hideLoader();

                let tableList = $("#tableList");
                let myTable = $("#myTable");

                myTable.DataTable().destroy();
                tableList.empty();

                res.data.data.forEach(function (item, index) {
                    let row = `<tr>
                                    <td class="checkboxRow"><input type="checkbox" class="rowCheckbox" data-id="${item.id}" /></td>
                                    <td style="text-align: center; width: 10px !important;">${++index}</td>                    
                                    <td>${item.name}</td>
                                    <td>${item.email}</td>
                                    <td>${item.phone}</td>
                                    @can('assign-role')
                                        <td>
                                        <a href="user/assignRole/${item.id}" class="btn btn-sm btn-info">Assign Role(s)</a>
                                    </td>
                                    @endcan
                                    @can(['edit-user', 'delete-user', 'info-user'])
                                        <td class="action">
                                        <div class="dropdown d-xl-none">
                                            <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @can('edit-user')
                                                    <li><button data-id="${item.id}" class="text-success editBtn dropdown-item">Edit</button></li>
                                                @endcan
                                                @can('delete-user')
                                                    <li><button data-id="${item.id}" class="text-danger deleteBtn dropdown-item">Delete</button></li>
                                                @endcan
                                                @can('info-user')
                                                    <a href="/admin/user/profile/edit/${item.id}" class="text-primary infoBtn dropdown-item">Profile</a>
                                                @endcan
                                            </ul>
                                        </div>
                                        @can('edit-user')
                                            <button data-id="${item.id}" class="d-none d-xl-inline-block btn btn-sm editBtn btn-sm btn-outline-success"><i class="fa fa-edit"></i></button>
                                        @endcan
                                        @can('delete-user')
                                            <button data-id="${item.id}" class="d-none d-xl-inline-block btn btn-sm deleteBtn btn-sm btn-outline-danger mx-1"><i class="fa fa-trash"></i></button>
                                        @endcan
                                        @can('info-user')
                                            <a href="/admin/user/profile/edit/${item.id}" class="d-none d-xl-inline-block btn btn-sm infoBtn btn-sm btn-outline-primary"><i class="fa fa-info-circle"></i></a>
                                        @endcan
                                    </td>
                                    @endcan
                                </tr>`
                    tableList.append(row)
                })
// <button data-id="${item.id}" data-path="${item.banner}" class="d-none d-xl-inline-block btn btn-sm deleteBtn btn-sm btn-outline-danger mx-1"><i class="fa fa-trash"></i></button>

                $('.infoBtn').on('click', async function () {
                    let id = $(this).data('id');
                    await FillUpInfoForm(id)
                    $("#info_modal").modal('show'); // Updated to show info modal
                })

                $('.editBtn').on('click', async function () {
                    let id = $(this).data('id');
                    await FillUpUpdateForm(id)
                    $("#update_modal").modal('show');
                })

                $('.deleteBtn').on('click', function () {
                    let id = $(this).data('id');
                    $("#delete_modal").modal('show');
                    $("#deleteId").val(id);
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
                            title: 'Users List',
                            text: '<i class="fa fa-copy"></i>',
                            titleAttr: 'Copy',
                            className: 'btn btn-sm btn-outline-primary'
                        },
                        {
                            extend: 'excelHtml5',
                            title: 'Users List',
                            text: '<i class="fa fa-file-excel"></i>',
                            titleAttr: 'Excel',
                            className: 'btn btn-sm btn-outline-success'
                        },
                        {
                            extend: 'print',
                            title: 'Users List',
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