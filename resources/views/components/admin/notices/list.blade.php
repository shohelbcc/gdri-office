<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Notices</h4>
                    </div>
                    <div class="align-items-center col">
                        <span id="createbtn">
                            @can('create-admin-notice')
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

                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th class="bg-secondary text-white" style="text-align: center; width: 10px !important;">#</th>
                                <th class="bg-secondary text-white">Title</th>
                                <th class="bg-secondary text-white">Published Date</th>
                                <th class="bg-secondary text-white">Assigned To</th>
                                @can(['view-admin-notice', 'edit-admin-notice', 'delete-admin-notice'])
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
                let res = await axios.get("/admin/notice/list");
                //    hideLoader();

                let tableList = $("#tableList");
                let myTable = $("#myTable");

                myTable.DataTable().destroy();
                tableList.empty();

                res.data.data.forEach(function (item, index) {
                    let publishedDate = item.published_at ? item.published_at.substring(0, 10) : '';
                    let assignedTo = item.users.length > 0 ? item.users.map(user => `<span class="badge bg-primary">${user.name}</span>`).join(' ') : 'Not Assigned';
                    let row = `<tr>
                                    <td style="text-align: center; width: 10px !important;">${++index}</td>
                                    <td>${item.title}</td>
                                    <td>${publishedDate}</td>
                                    <td>${assignedTo}</td>
                                    @can(['view-admin-notice', 'edit-admin-notice', 'delete-admin-notice'])
                                        <td class="action">
                                        <div class="dropdown d-xl-none">
                                            <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @can('view-admin-notice')
                                                    <li><button data-id="${item.id}" class="text-primary infoBtn dropdown-item">View</button></li>
                                                @endcan
                                                @can('edit-admin-notice')
                                                    <li><button data-id="${item.id}" class="text-success editBtn dropdown-item">Edit</button></li>
                                                @endcan
                                                @can('delete-admin-notice')
                                                    <li><button data-id="${item.id}" class="text-danger deleteBtn dropdown-item">Delete</button></li>
                                                @endcan
                                            </ul>
                                        </div>
                                        @can('view-admin-notice')
                                            <button data-id="${item.id}" class="d-none d-xl-inline-block btn btn-sm infoBtn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></button>
                                        @endcan
                                        @can('edit-admin-notice')
                                            <button data-id="${item.id}" class="d-none d-xl-inline-block btn btn-sm editBtn btn-sm btn-outline-success"><i class="fa fa-edit"></i></button>
                                        @endcan
                                        @can('delete-admin-notice')
                                            <button data-id="${item.id}" class="d-none d-xl-inline-block btn btn-sm deleteBtn btn-sm btn-outline-danger mx-1"><i class="fa fa-trash"></i></button>
                                        @endcan
                                    </td>
                                    @endcan
                                </tr>`
                    tableList.append(row)
                })

                $('.infoBtn').on('click', async function () {
                    let id = $(this).data('id');
                    await FillUpInfoForm(id)
                    $("#info_modal").modal('show');
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

                new DataTable('#myTable', {
                    order: [[0, 'asc']],
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
                            title: 'notices List',
                            text: '<i class="fa fa-copy"></i>',
                            titleAttr: 'Copy',
                            className: 'btn btn-sm btn-outline-primary'
                        },
                        {
                            extend: 'excelHtml5',
                            title: 'notices List',
                            text: '<i class="fa fa-file-excel"></i>',
                            titleAttr: 'Excel',
                            className: 'btn btn-sm btn-outline-success'
                        },
                        {
                            extend: 'print',
                            title: 'notices List',
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